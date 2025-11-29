<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Middleware уақытша комментарийге аламыз
        // $this->middleware('admin');
    }

    public function dashboard()
    {
        // Админдік тексеру
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Сізде админ құқығы жоқ!');
        }

        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_products' => Product::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}