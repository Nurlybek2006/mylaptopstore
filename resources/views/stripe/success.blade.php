@extends('layouts.app')

@section('title', 'Төлем сәтті - Laptop.KZ')

@section('styles')
<style>
    .success-container {
        text-align: center;
        padding: 50px 20px;
        max-width: 700px;
        margin: 50px auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .success-icon {
        font-size: 80px;
        color: #28a745;
        margin-bottom: 20px;
    }
    .order-info {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 15px;
        margin: 25px 0;
        text-align: left;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 15px;
    }
</style>
@endsection

@section('content')
<div class="success-container">
    <div class="success-icon">✅</div>
    <h1 style="color: #28a745; margin-bottom: 20px;">Төлем сәтті аяқталды!</h1>
    
    @if(isset($order))
    <div class="order-info">
        <h4><i class="fas fa-receipt me-2"></i>Тапсырыс ақпараты:</h4>
        
        @foreach($order->items as $item)
        <div class="d-flex align-items-center mb-3">
            @if($item->product->image_url)
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="product-image">
            @endif
            <div>
                <h5 class="mb-1">{{ $item->product->name }}</h5>
                <p class="mb-0 text-muted">Саны: {{ $item->quantity }} дана</p>
                <p class="mb-0 text-muted">Бірлік бағасы: {{ number_format($item->price, 0, ',', ' ') }} ₸</p>
            </div>
        </div>
        @endforeach
        
        <div class="row">
            <div class="col-md-6">
                <p><strong>Тапсырыс ID:</strong> #{{ $order->id }}</p>
                <p><strong>Төлем ID:</strong> {{ $order->stripe_payment_id ?? '-' }}</p>
                <p><strong>Статус:</strong> <span style="color: #28a745; font-weight: bold;">{{ $order->status }}</span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Жалпы сома:</strong> {{ number_format($order->total_amount, 0, ',', ' ') }} ₸</p>
                <p><strong>Электрондық пошта:</strong> {{ $order->customer_email }}</p>
                <p><strong>Клиент:</strong> {{ $order->customer_name }}</p>
            </div>
        </div>
    </div>
    @endif
    
    <p style="color: #64748b; margin-bottom: 30px;">
        <i class="fas fa-envelope me-2"></i>
        Төлем растықтау хаты сіздің электрондық поштаңызға жіберіледі.
    </p>
    
    <div class="action-buttons">
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="background: #2563eb; border: none; padding: 12px 30px; border-radius: 10px; margin: 5px; text-decoration: none; display: inline-block; color: white;">
            <i class="fas fa-laptop me-2"></i>Тауарларға оралу
        </a>
        <a href="{{ route('home') }}" class="btn btn-primary" style="background: #64748b; border: none; padding: 12px 30px; border-radius: 10px; margin: 5px; text-decoration: none; display: inline-block; color: white;">
            <i class="fas fa-home me-2"></i>Басты бетке оралу
        </a>
        @auth
            <a href="{{ route('profile.index') }}" class="btn btn-primary" style="background: #059669; border: none; padding: 12px 30px; border-radius: 10px; margin: 5px; text-decoration: none; display: inline-block; color: white;">
                <i class="fas fa-list-alt me-2"></i>Тапсырыстарым
            </a>
        @endauth
    </div>
</div>
@endsection