<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Constructor әдісін қосамыз
    public function __construct()
    {
        // Барлық әдістерге middleware қосамыз
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // Енді middleware тексергендіктен, қолмен тексеруді алып тастай аламыз
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }
        //
        // if (Auth::user()->role !== 'admin') {
        //     return redirect()->route('home')->with('error', 'Сізде админ құқығы жоқ!');
        // }

        // Статистика
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