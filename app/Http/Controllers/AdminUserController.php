<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Пайдаланушылар тізімін алу
        $users = User::withCount(['orders', 'products'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Статистика
        $stats = [
            'total_users' => $users->count(),
            'admin_count' => $users->where('role', 'admin')->count(),
            'user_count' => $users->where('role', 'user')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user,moderator'
        ]);

        $user = User::findOrFail($id);

        // Өзінің рөлін өзгерте алмау
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Өз рөліңізді өзгерте алмайсыз');
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Пайдаланушы ақпараты сәтті жаңартылды!');
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user,moderator'
        ]);

        $user = User::findOrFail($id);

        // Өзінің рөлін өзгерте алмау
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Өз рөліңізді өзгерте алмайсыз');
        }

        $user->update([
            'role' => $request->role
        ]);

        $roleName = $user->role_name;
        return redirect()->route('admin.users.index')
            ->with('success', "Пайдаланушы рөлі '$roleName' дегенге сәтті өзгертілді!");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Өзінің есебін өшіре алмау
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Өз есебіңізді өшіре алмайсыз');
        }

        DB::transaction(function () use ($user) {
            // Пайдаланушының себетін тазалау
            $user->cartItems()->delete();
            
            // Пайдаланушыны өшіру
            $user->delete();
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Пайдаланушы сәтті өшірілді!');
    }
}