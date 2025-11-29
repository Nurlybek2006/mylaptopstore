<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.orders.index');
    }

    public function show($id)
    {
        return view('admin.orders.show', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Уақытша
        return redirect()->route('admin.orders.index');
    }
}