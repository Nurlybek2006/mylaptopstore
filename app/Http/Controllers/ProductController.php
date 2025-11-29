<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Іздеу фильтрі
        $search = $request->get('search');
        $sort = $request->get('sort', 'name');

        // Сұрыптау параметрлері
        $sortOptions = [
            'name' => ['field' => 'name', 'direction' => 'asc'],
            'price_low' => ['field' => 'price', 'direction' => 'asc'],
            'price_high' => ['field' => 'price', 'direction' => 'desc'],
            'newest' => ['field' => 'created_at', 'direction' => 'desc'],
        ];

        $sortOption = $sortOptions[$sort] ?? $sortOptions['name'];

        // Өнімдерді алу
        $query = Product::with('category', 'user');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy($sortOption['field'], $sortOption['direction'])
                         ->paginate(12);

        $totalProducts = $products->total();

        return view('products.index', compact(
            'products', 
            'totalProducts', 
            'search', 
            'sort'
        ));
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