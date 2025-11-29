<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(12);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'user')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->take(4)
                                ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Әкімшілік үшін - кейін толтырасыз
    }

    public function edit($id)
    {
        // Әкімшілік үшін - кейін толтырасыз
    }

    public function update(Request $request, $id)
    {
        // Әкімшілік үшін - кейін толтырасыз
    }

    public function destroy($id)
    {
        // Әкімшілік үшін - кейін толтырасыз
    }
}