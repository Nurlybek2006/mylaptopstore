<?php
// app/Http/Controllers/MarketplaceController.php

namespace App\Http\Controllers;

use App\Models\MarketplaceProduct;
use App\Models\MarketplaceMessage;
use App\Models\MarketplaceInterest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    /**
     * Marketplace басты беті
     */
    public function index(Request $request)
    {
        $query = MarketplaceProduct::with('user')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc');

        // Сүзгілер
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        // Категориялар тізімі
        $categories = MarketplaceProduct::where('status', 'active')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('marketplace.index', compact('products', 'categories'));
    }

    /**
     * Тауар қосу формасы
     */
    public function create()
    {
        // Категориялар тізімін алу
        $categories = MarketplaceProduct::where('status', 'active')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        // Егер категориялар бос болса, әдепкі категорияларды қосу
        if ($categories->isEmpty()) {
            $categories = collect([
                'Ноутбук',
                'Телефон',
                'Планшет',
                'Компьютер',
                'Монитор',
                'Принтер',
                'Телевизор',
                'Камера',
                'Құлаққап',
                'Тінтуір',
                'Пернетақта',
                'Қуат көзі',
                'Басқа',
            ]);
        }

        return view('marketplace.create', compact('categories'));
    }

    /**
     * Тауарды сақтау
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100', // Міндетті емес ету
            'brand' => 'nullable|string|max:100',
            'condition' => 'required|in:new,used,refurbished',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_urls' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Файл суреттерді өңдеу
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('marketplace', 'public');
                $imagePaths[] = Storage::url($path);
            }
        }

        // URL суреттерді өңдеу
        if ($request->filled('image_urls')) {
            $urls = explode(',', $request->image_urls);
            foreach ($urls as $url) {
                $url = trim($url);
                if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                    $imagePaths[] = $url;
                }
            }
        }

        // Категорияны өңдеу - егер бос болса, "Басқа" деп белгілеу
        $category = $request->category ?: 'Басқа';

        $product = MarketplaceProduct::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $category,
            'brand' => $request->brand,
            'condition' => $request->condition,
            'images' => $imagePaths,
            'status' => 'active'
        ]);

        return redirect()->route('marketplace.show', $product->id)
            ->with('success', 'Тауар сәтті қосылды!');
    }

    /**
     * Тауарды көрсету
     */
    public function show($id)
    {
        $product = MarketplaceProduct::with(['user', 'interests'])
            ->where('status', 'active')
            ->findOrFail($id);

        // Қаралым санын арттыру
        $product->increment('views');

        // Ұқсас тауарлар
        $similarProducts = MarketplaceProduct::with('user')
            ->where('status', 'active')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        // Белгілі бір тауар бойынша чат хабарламаларын алу
        $chatMessages = [];
        if (auth()->check() && auth()->id() != $product->user_id) {
            $chatMessages = MarketplaceMessage::with('sender')
                ->where('product_id', $product->id)
                ->where(function ($query) use ($product) {
                    $query->where('sender_id', auth()->id())
                        ->where('receiver_id', $product->user_id);
                })->orWhere(function ($query) use ($product) {
                    $query->where('sender_id', $product->user_id)
                        ->where('receiver_id', auth()->id());
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('marketplace.show', compact('product', 'similarProducts', 'chatMessages'));
    }

    /**
     * Тауарды өңдеу формасы
     */
    public function edit($id)
    {
        $product = MarketplaceProduct::where('user_id', Auth::id())
            ->findOrFail($id);

        $categories = MarketplaceProduct::where('status', 'active')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('marketplace.edit', compact('product', 'categories'));
    }

    /**
     * Тауарды жаңарту
     */
    public function update(Request $request, $id)
    {
        $product = MarketplaceProduct::where('user_id', Auth::id())
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100', // Міндетті емес
            'brand' => 'nullable|string|max:100',
            'condition' => 'required|in:new,used,refurbished',
            'status' => 'required|in:active,sold,inactive',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Суреттерді өңдеу
        $currentImages = $product->images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('marketplace', 'public');
                $currentImages[] = Storage::url($path);
            }
        }

        // Жойылатын суреттер
        if ($request->filled('remove_images')) {
            $imagesToRemove = json_decode($request->remove_images, true) ?? [];
            $currentImages = array_diff($currentImages, $imagesToRemove);
        }

        // Категорияны өңдеу
        $category = $request->category ?: 'Басқа';

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $category,
            'brand' => $request->brand,
            'condition' => $request->condition,
            'status' => $request->status,
            'images' => array_values($currentImages)
        ]);

        return redirect()->route('marketplace.myProducts')
            ->with('success', 'Тауар сәтті жаңартылды!');
    }

    /**
     * Тауарды жою
     */
    public function destroy($id)
    {
        $product = MarketplaceProduct::where('user_id', Auth::id())
            ->findOrFail($id);

        $product->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Тауар сәтті жойылды!'
            ]);
        }

        return redirect()->route('marketplace.myProducts')
            ->with('success', 'Тауар сәтті жойылды!');
    }


    /**
     * Хабарлама жіберу
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:marketplace_products,id',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Өзіне хабарлама жібере алмау
        if ($request->receiver_id == Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Өзіңізге хабарлама жібере алмайсыз'
            ]);
        }

        $message = MarketplaceMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'product_id' => $request->product_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Хабарлама жіберілді!'
        ]);
    }

    /**
     * Қызығушылық білдіру
     */
    public function addInterest($productId)
    {
        $product = MarketplaceProduct::findOrFail($productId);

        // Өзінің тауарына қызығушылық білдіре алмау
        if ($product->user_id == Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Өзіңіздің тауарыңызға қызығушылық білдіре алмайсыз'
            ]);
        }

        // Бұрын қызығушылық білдірген болса
        $existing = MarketplaceInterest::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Сіз бұрын қызығушылық білдіргенсіз'
            ]);
        }

        MarketplaceInterest::create([
            'user_id' => Auth::id(),
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Қызығушылығыңыз тіркелді!'
        ]);
    }

    /**
     * Чаттар тізімі
     */
    public function chats()
    {
        $userId = Auth::id();

        // User модельіндегі әдісті қолдану
        $chatList = Auth::user()->getMarketplaceChats();

        return view('marketplace.chats', compact('chatList'));
    }

    /**
     * Белгілі бір пайдаланушымен чат
     */
    public function chat($userId)
    {
        $otherUser = User::findOrFail($userId);
        $currentUserId = Auth::id();

        // Хабарламаларды алу
        $messages = MarketplaceMessage::with(['sender', 'product'])
            ->where(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                    ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Хабарламаларды оқылған деп белгілеу
        MarketplaceMessage::where('sender_id', $userId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('marketplace.chat', compact('otherUser', 'messages'));
    }

    /**
     * AJAX хабарламалар
     */
    public function getMessages($userId)
    {
        $currentUserId = Auth::id();

        $messages = MarketplaceMessage::with(['sender', 'product'])
            ->where(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                    ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * AJAX хабарлама жіберу
     */
    public function sendChatMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'product_id' => 'nullable|exists:marketplace_products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $message = MarketplaceMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'product_id' => $request->product_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        $message->load('sender');

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Тауар бойынша хабарлама жіберу
     */
    public function sendProductMessage(Request $request, $id)
    {
        $product = MarketplaceProduct::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Өзінің өніміне хабарлама жібере алмау
        if ($product->user_id == Auth::id()) {
            return redirect()->back()
                ->with('error', 'Өзіңіздің өніміңізге хабарлама жібере алмайсыз');
        }

        MarketplaceMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $product->user_id,
            'product_id' => $product->id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return redirect()->back()
            ->with('success', 'Хабарлама жіберілді!');
    }

    /**
     * Менің тауарларым
     */
    public function myProducts(Request $request)
    {
        $query = MarketplaceProduct::withCount('interests')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Сүзгілер
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        $products = $query->paginate(12);

        // Статистиканы есептеу
        $stats = [
            'total' => MarketplaceProduct::where('user_id', Auth::id())->count(),
            'active' => MarketplaceProduct::where('user_id', Auth::id())->where('status', 'active')->count(),
            'sold' => MarketplaceProduct::where('user_id', Auth::id())->where('status', 'sold')->count(),
            'inactive' => MarketplaceProduct::where('user_id', Auth::id())->where('status', 'inactive')->count(),
            'total_views' => MarketplaceProduct::where('user_id', Auth::id())->sum('views'),
        ];

        return view('marketplace.my-products', compact('products', 'stats'));
    }

    /**
     * Тауар статусын өзгерту
     */
    public function updateStatus(Request $request, $id)
    {
        $product = MarketplaceProduct::where('user_id', Auth::id())
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,sold,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Жарамсыз статус'
            ], 422);
        }

        $product->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Тауар статусы сәтті өзгертілді!'
        ]);
    }
}
