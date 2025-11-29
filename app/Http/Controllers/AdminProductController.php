<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // Уақытша
        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        return view('admin.products.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Уақытша
        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        // Уақытша
        return redirect()->route('admin.products.index');
    }
}