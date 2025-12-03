@extends('layouts.marketplace')

@section('title', 'Чаттар - Marketplace')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="page-header text-center mb-4">
                <h1 class="page-title">
                    <i class="fas fa-comment-dots me-2"></i>
                    Сөйлесулер
                </h1>
                <p class="page-subtitle">
                    Marketplace арқылы сатып алушылар мен сатушылармен байланысыңыз
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if(count($chatList) > 0)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="chat-sidebar">
                                <div class="sidebar-header p-3 border-bottom">
                                    <h3 class="sidebar-title mb-0">
                                        <i class="fas fa-comment-dots"></i>
                                        Сөйлесулер
                                    </h3>
                                </div>
                                
                                <div class="chat-list">
                                    @foreach($chatList as $chat)
                                    @php
                                        // last_message_time-ны Carbon объектісіне түрлендіру
                                        $lastMessageTime = $chat['last_message_time'] 
                                            ? \Carbon\Carbon::parse($chat['last_message_time'])
                                            : null;
                                    @endphp
                                    <a href="{{ route('marketplace.chat', $chat['user']->id) }}" 
                                       class="chat-item d-block p-3 text-decoration-none border-bottom 
                                              {{ request()->route('userId') == $chat['user']->id ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar" style="width: 50px; height: 50px;">
                                                <img src="{{ $chat['user']->avatar_url }}" 
                                                     alt="{{ $chat['user']->name }}"
                                                     class="rounded-circle w-100 h-100">
                                            </div>
                                            <div class="user-details flex-grow-1">
                                                <div class="user-name fw-semibold text-dark">
                                                    {{ $chat['user']->name }}
                                                    @if($chat['unread_count'] > 0)
                                                    <span class="badge bg-primary ms-2">{{ $chat['unread_count'] }}</span>
                                                    @endif
                                                </div>
                                                @if($chat['last_message'])
                                                <div class="last-message text-muted small mt-1">
                                                    {{ Str::limit($chat['last_message']->message, 40) }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="chat-meta text-end">
                                                @if($lastMessageTime)
                                                <div class="message-time small text-muted">
                                                    {{ $lastMessageTime->format('H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="chat-main h-100 d-flex flex-column">
                                <div class="no-chat-selected d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center">
                                        <div class="no-chat-icon mb-3">
                                            <i class="fas fa-comments fa-4x text-primary opacity-50"></i>
                                        </div>
                                        <h4 class="mb-2">Сөйлесу таңдаңыз</h4>
                                        <p class="text-muted mb-0">Сол жақтан сөйлесуді таңдаңыз</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-comment-slash fa-4x text-muted mb-3"></i>
                        <h4 class="mb-2">Чаттар жоқ</h4>
                        <p class="text-muted mb-4">Әлі ешкіммен сөйлесе қойған жоқсыз</p>
                        <a href="{{ route('marketplace.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>
                            Marketplace-ке өту
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        text-align: center;
        margin-bottom: 20px;
        padding: 30px 0 10px;
    }
    
    .page-title {
        font-size: 2.3rem;
        font-weight: 700;
        color: #1e3c72;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    
    .page-subtitle {
        font-size: 1.1rem;
        color: #2a5298;
        opacity: 0.8;
    }
    
    .chat-sidebar {
        border-right: 1px solid #e3f2fd;
        height: 600px;
        overflow-y: auto;
        background: white;
    }
    
    .chat-main {
        height: 600px;
        background: #f0f2f5;
        border-radius: 10px;
    }
    
    .sidebar-header {
        background: white;
    }
    
    .sidebar-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e3c72;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chat-item {
        transition: all 0.3s ease;
        background: white;
    }
    
    .chat-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }
    
    .chat-item.active {
        background: #e3f2fd;
        border-left: 4px solid #3498db;
    }
    
    .user-avatar img {
        object-fit: cover;
    }
    
    .no-chat-selected {
        color: #666;
    }
</style>

@endsection