<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function edit($id)
    {
        return view('admin.users.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Уақытша
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        // Уақытша
        return redirect()->route('admin.users.index');
    }
}