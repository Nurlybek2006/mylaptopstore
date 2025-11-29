<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;   // ← МІНДЕТТІ

class CartController extends Controller
{
    // Себет беті
    public function index()
    {
        // Тек кірген пайдаланушылар себетті көре алады
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Админ себетті көре алмайды
        if (Auth::user()->role === 'admin') {
            return redirect()->route('home')->with('error', 'Админ себетті көре алмайды');
        }

        $cart = session()->get('cart', []);
        $cart_items = [];
        $total = 0;
        $has_out_of_stock = false;

        foreach ($cart as $product_id => $quantity) {
            $product = Product::find($product_id);
            
            if ($product) {
                $item = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'stock' => $product->stock,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                    'out_of_stock' => $quantity > $product->stock
                ];
                
                $cart_items[] = $item;
                $total += $item['subtotal'];
                
                if ($item['out_of_stock']) {
                    $has_out_of_stock = true;
                }
            }
        }

        return view('cart.index', compact('cart_items', 'total', 'has_out_of_stock'));
    }

    // Себетке қосу
    public function add(Request $request, $product_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->back()->with('error', 'Админ себетке өнім қоса алмайды');
        }

        $product = Product::findOrFail($product_id);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $new_quantity = $cart[$product_id] + $quantity;
            if ($new_quantity <= $product->stock) {
                $cart[$product_id] = $new_quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Өнім саны себетте жаңартылды!');
            } else {
                return redirect()->back()->with('warning', 'Қорда осы өнімнен көп жоқ. Қолжетімді саны: ' . $product->stock);
            }
        } else {
            if ($quantity <= $product->stock) {
                $cart[$product_id] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Өнім себетке қосылды!');
            } else {
                return redirect()->back()->with('warning', 'Қорда осы өнімнен көп жоқ. Қолжетімді саны: ' . $product->stock);
            }
        }
    }

    // Себеттен жою
    public function remove($product_id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Өнім себеттен жойылды!');
        }

        return redirect()->back();
    }

    // Санды өзгерту
    public function update(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = intval($request->input('quantity'));

        $cart = session()->get('cart', []);
        $product = Product::find($product_id);

        if ($quantity > 0) {
            if ($product && $quantity <= $product->stock) {
                $cart[$product_id] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Саны жаңартылды!');
            } else {
                return redirect()->back()->with('error', 'Қорда жеткілікті өнім жоқ. Қолжетімді саны: ' . ($product ? $product->stock : 0));
            }
        } else {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Өнім себеттен жойылды!');
        }
    }

    // Барлығын тазалау
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Себет тазаланды!');
    }

    // Тапсырыс беру
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Себет бос');
        }

        try {
            DB::beginTransaction();

            $total_amount = 0;
            $out_of_stock_items = [];

            // Әр өнімнің қорын тексеру
            foreach ($cart as $product_id => $quantity) {
                $product = Product::find($product_id);
                
                if ($product) {
                    if ($quantity > $product->stock) {
                        $out_of_stock_items[] = $product->name;
                    } else {
                        $total_amount += $product->price * $quantity;
                    }
                }
            }

            if (!empty($out_of_stock_items)) {
                return redirect()->back()->with('error', 'Келесі өнімдердің қоры жеткіліксіз: ' . implode(', ', $out_of_stock_items));
            }

            // Тапсырыс жасау
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total_amount,
                'status' => 'pending'
            ]);

            // Тапсырыс элементтерін қосу және қорды жаңарту
            foreach ($cart as $product_id => $quantity) {
                $product = Product::find($product_id);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);

                // Қорды жаңарту
                $product->decrement('stock', $quantity);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Тапсырыс сәтті аяқталды! Тапсырыс нөміріңіз: #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Тапсырыс кезінде қате орын алды: ' . $e->getMessage());
        }
    }
}