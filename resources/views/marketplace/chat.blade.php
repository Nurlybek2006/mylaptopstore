@extends('layouts.marketplace')

@section('title', $otherUser->name . ' - Чат')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="page-header text-center mb-4">
                <h1 class="page-title">
                    <i class="fas fa-comments me-2"></i>
                    Чат
                </h1>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="chat-container d-flex" style="height: 75vh;">
                        <!-- Чаттар тізімі -->
                        <div class="chat-sidebar" style="width: 350px;">
                            <div class="sidebar-header p-3 border-bottom">
                                <h3 class="sidebar-title mb-0">
                                    <i class="fas fa-comment-dots"></i>
                                    Сөйлесулер
                                </h3>
                            </div>

                            <div class="chat-list" style="overflow-y: auto; height: calc(75vh - 73px);">
                                @php
                                $chatList = auth()->user()->getMarketplaceChats();
                                @endphp

                                @foreach($chatList as $chat)
                                @php
                                // last_message_time-ны Carbon объектісіне түрлендіру
                                $lastMessageTime = $chat['last_message_time']
                                ? \Carbon\Carbon::parse($chat['last_message_time'])
                                : null;
                                @endphp
                                <a href="{{ route('marketplace.chat', $chat['user']->id) }}"
                                    class="chat-item d-block p-3 text-decoration-none border-bottom 
                                          {{ $otherUser->id == $chat['user']->id ? 'active' : '' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar" style="width: 45px; height: 45px;">
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
                                                {{ Str::limit($chat['last_message']->message, 35) }}
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

                        <!-- Негізгі чат -->
                        <div class="chat-main flex-grow-1 d-flex flex-column">
                            <div class="chat-header p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar" style="width: 50px; height: 50px;">
                                        <img src="{{ $otherUser->avatar_url }}"
                                            alt="{{ $otherUser->name }}"
                                            class="rounded-circle w-100 h-100">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $otherUser->name }}</h5>
                                        <small class="text-muted">
                                            @php
                                            $isOnline = Cache::has('user-is-online-' . $otherUser->id);
                                            @endphp
                                            @if($isOnline)
                                            <span class="text-success">🟢 Белсенді</span>
                                            @else
                                            <span class="text-muted">⚫ Онлайн емес</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="chat-actions">
                                    <button class="btn btn-outline-primary btn-sm" onclick="refreshChat()">
                                        <i class="fas fa-sync-alt"></i>
                                        Жаңарту
                                    </button>
                                </div>
                            </div>

                            <div class="chat-messages flex-grow-1 p-3"
                                style="overflow-y: auto; background: #f0f2f5;"
                                id="chatMessages">
                                @foreach($messages as $message)
                                <div class="message mb-3 {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                    <div class="message-wrapper p-3 rounded-3"
                                        style="max-width: 70%; {{ $message->sender_id == auth()->id() ? 'background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; margin-left: auto;' : 'background: white; margin-right: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.08);' }}">
                                        @if($message->product_id)
                                        <div class="product-info mb-2 p-2 rounded"
                                            style="{{ $message->sender_id == auth()->id() ? 'background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);' : 'background: #e3f2fd; border: 1px solid rgba(52,152,219,0.2);' }}">
                                            <i class="fas fa-tag me-1"></i>
                                            Тауар: {{ $message->product->title ?? 'Тауар жоқ' }}
                                        </div>
                                        @endif
                                        <div class="message-text">{{ $message->message }}</div>
                                        <div class="message-time small mt-2"
                                            style="{{ $message->sender_id == auth()->id() ? 'text-align: right; opacity: 0.8;' : 'text-align: left; opacity: 0.8;' }}">
                                            {{ $message->created_at->format('d.m.Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- ФОРМА - ЕҢ ҚАРАПАЙЫМ НҰСҚА -->
                            <div class="chat-input p-3 border-top bg-white">
                                <form method="POST" action="{{ route('marketplace.sendMessage') }}" id="chatForm">
                                    @csrf
                                    <div class="input-group">
                                        <textarea name="message"
                                            class="form-control message-input"
                                            placeholder="Хабарлама жазыңыз..."
                                            required
                                            id="messageInput"
                                            rows="1"
                                            style="border-radius: 12px; border: 2px solid #e3f2fd; resize: none;"></textarea>
                                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                                        <button type="submit" class="btn btn-primary send-btn"
                                            style="border-radius: 12px; margin-left: 10px;">
                                            <i class="fas fa-paper-plane"></i>
                                            Жіберу
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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

    .chat-sidebar {
        border-right: 1px solid #e3f2fd;
        background: white;
    }

    .chat-main {
        background: #f0f2f5;
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

    .message.received .message-wrapper {
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 18px;
    }

    .message.sent .message-wrapper {
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 6px;
    }

    .message-input:focus {
        border-color: #3498db !important;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1) !important;
    }

    .send-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        transition: all 0.3s ease;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log('Chat page loaded');
    
    // Автоматты биіктік реттеу
    $('#messageInput').on('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    
    // Чатты төменгі жағына скроллдау
    function scrollToBottom() {
        const chatMessages = $('#chatMessages');
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
    
    scrollToBottom();
    
    // Enter басылғанда жіберу (Shift+Enter - жаңа жол)
    $('#messageInput').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#chatForm').submit();
        }
    });
    
    // Форма жіберілген кезде күту мәлімдемесі
    $('#chatForm').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i> Жіберілуде...');
    });
    
    // Дебаг ақпараты
    console.log('Chat debug info:');
    console.log('Current User ID:', {{ auth()->id() }});
    console.log('Other User ID:', {{ $otherUser->id }});
    console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
    console.log('Form action:', $('#chatForm').attr('action'));
});

// Чатты жаңарту функциясы
function refreshChat() {
    console.log('Refreshing chat...');
    location.reload();
}

// Автоматты жаңарту (тек чат бетінде)
if (window.location.pathname.includes('/marketplace/chat/')) {
    setInterval(function() {
        refreshChat();
    }, 30000); // 30 секунд сайын
}
</script>

@endsection