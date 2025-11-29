<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\LaptopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // Таб параметрін алу (әдепкі 'orders')
        $tab = $request->get('tab', 'orders');

        // Тапсырыстарды алу
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ноутбук сұраныстарын алу
        $laptop_requests = LaptopRequest::orderBy('created_at', 'desc')->get();

        // Статистика
        $stats = [
            'total_orders' => $orders->count(),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'completed_orders' => $orders->where('status', 'completed')->count(),
            'total_requests' => $laptop_requests->count(),
            'new_requests' => $laptop_requests->where('status', 'new')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'laptop_requests', 'stats', 'tab'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Тапсырыс статусы сәтті жаңартылды!');
    }

    public function updateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed'
        ]);

        $laptopRequest = LaptopRequest::findOrFail($id);
        $laptopRequest->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index', ['tab' => 'requests'])
            ->with('success', 'Сұраныс статусы сәтті жаңартылды!');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $order = Order::findOrFail($id);
            
            // Тапсырыс элементтерін өшіру
            OrderItem::where('order_id', $id)->delete();
            
            // Тапсырысты өшіру
            $order->delete();
        });

        return redirect()->route('admin.orders.index')
            ->with('success', 'Тапсырыс сәтті өшірілді!');
    }

    public function destroyRequest($id)
    {
        $laptopRequest = LaptopRequest::findOrFail($id);
        $laptopRequest->delete();

        return redirect()->route('admin.orders.index', ['tab' => 'requests'])
            ->with('success', 'Сұраныс сәтті өшірілді!');
    }
}