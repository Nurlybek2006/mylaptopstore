<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Өнімдерді алу (категориялармен бірге)
        $featuredProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Категорияларды алу
        $categories = Category::all();

        // Статистика
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();

        // Көп сатылған өнімдер (кездейсоқ 4)
        $popularProducts = Product::with('category')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'popularProducts'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}