<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Өнімдер тізімін алу - user байланысын пайдаланамыз
        $products = Product::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Категорияларды алу (формада қажет)
        $categories = Category::all();

        // Статистика
        $stats = [
            'total_products' => $products->count(),
            'available_products' => $products->where('stock', '>', 0)->count(),
            'out_of_stock' => $products->where('stock', 0)->count(),
            'average_price' => $products->avg('price')
        ];

        return view('admin.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $imagePath = null;

        // Файл жүктеу
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        // URL арқылы сурет
        elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Өнім сәтті қосылды!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $imagePath = $product->image;

        // Файл жүктеу
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Ескі суретті өшіру (тек жергілікті файл болса)
            if ($imagePath && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }
        // URL арқылы сурет
        elseif ($request->filled('image_url')) {
            // Ескі суретті өшіру (тек жергілікті файл болса)
            if ($imagePath && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->image_url;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Өнім сәтті жаңартылды!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Суретті өшіру (тек жергілікті файл болса)
        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Өнім сәтті өшірілді!');
    }

    // Өнім күйін өзгерту (белсенді/белсенді емес)
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        
        // Мысалы, stock арқылы күйді басқару
        $newStock = $product->stock > 0 ? 0 : 10; // Өнімді қайта белсендіру үшін 10 қор қоямыз
        
        $product->update(['stock' => $newStock]);

        $message = $newStock > 0 ? 'Өнім белсенді түрде қосылды!' : 'Өнім белсенді емес түрге өзгертілді!';

        return redirect()->route('admin.products.index')
            ->with('success', $message);
    }

    // Көптеген өнімдерді бір уақытта өшіру
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->product_ids)->get();

        foreach ($products as $product) {
            // Суреттерді өшіру
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', count($request->product_ids) . ' өнім сәтті өшірілді!');
    }
}