@extends('layouts.app')

@section('title', 'Төлем тоқтатылды - Laptop.KZ')

@section('content')
<div style="text-align: center; padding: 100px 20px; max-width: 500px; margin: 0 auto;">
    <div style="font-size: 80px; color: #dc3545; margin-bottom: 20px;">❌</div>
    <h1 style="color: #dc3545; margin-bottom: 20px;">Төлем тоқтатылды</h1>
    <p style="color: #64748b; margin-bottom: 30px; font-size: 1.1rem;">
        Сіз төлемді тоқтаттыңыз. Егер бұл қате болса, төлемді қайталап көріңіз.
    </p>
    
    @if (isset($order) && $order)
    <div style="background: #fef2f2; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
        <p class="mb-1"><strong>Тапсырыс ID:</strong> #{{ $order->id }}</p>
        <p class="mb-0"><small>Тапсырыс статусы: Тоқтатылды</small></p>
    </div>
    @endif
    
    <div style="margin-top: 30px;">
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="background: #2563eb; border: none; padding: 12px 30px; border-radius: 10px; margin: 5px; text-decoration: none; display: inline-block; color: white;">
            <i class="fas fa-laptop me-2"></i>Тауарларға оралу
        </a>
        <a href="{{ route('home') }}" class="btn btn-secondary" style="background: #64748b; border: none; padding: 12px 30px; border-radius: 10px; margin: 5px; text-decoration: none; display: inline-block; color: white;">
            <i class="fas fa-home me-2"></i>Басты бетке оралу
        </a>
    </div>
</div>
@endsection