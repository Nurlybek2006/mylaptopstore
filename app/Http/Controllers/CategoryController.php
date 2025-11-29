<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->paginate(12);
        
        return view('categories.show', compact('category', 'products'));
    }

    public function create()
    {
        return view('categories.create');
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