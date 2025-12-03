<!-- Чатты ашу батырмасы -->
<div class="chat-toggle-button" onclick="openChat()">
    <span>💬</span>
</div>

<!-- Overlay -->
<div class="chat-overlay" id="chatOverlay" onclick="closeChat()"></div>

<!-- Чат модальды терезесі -->
<div class="chat-modal" id="chatModal">
    <div class="chat-container">
        <!-- Чат тақырыбы -->
        <div class="chat-header">
            <h3>
                <span>🤖</span>
                Бот-Консультант
            </h3>
            <button class="close-chat" onclick="closeChat()">×</button>
        </div>

        <!-- Табтар -->
        <div class="chat-tabs">
            <button class="tab-button active" onclick="switchTab('chat-tab')">Чат</button>
            <button class="tab-button" onclick="switchTab('email-tab')">Email</button>
        </div>

        <!-- Чат бөлімі -->
        <div id="chat-tab" class="tab-content active">
            <div class="chat-messages-container">
                <div class="chat-messages" id="chat-messages">
                    <div class="welcome-message">
                        Біз сізге дұрыс ноутбук таңдауға көмектесеміз
                    </div>
                    <div class="message bot-message">
                        <div class="message-text">Сәлеметсіз бе! Мен бот-консультантпын. Сізге қандай салада көмек керек?</div>
                        <div class="message-time" id="current-time">23:42</div>
                    </div>
                </div>
                
                <!-- Енгізу индикаторы -->
                <div class="typing-indicator" id="typing-indicator">
                    Енгізу...
                </div>
            </div>

            <!-- Хабарлама енгізу аймағы -->
            <div class="chat-input-container">
                <input type="text" id="chat-input" placeholder="Мәселеңізді сипаттаңыз...">
                <button id="send-message" onclick="sendMessage()">Жіберу</button>
            </div>
        </div>

        <!-- Email бөлімі -->
        <div id="email-tab" class="tab-content">
            <div class="email-form">
                <form id="email-form" method="POST" action="{{ route('chatbot.email') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Атыңыз" required>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <textarea name="message" placeholder="Хабарлама" required></textarea>
                    </div>

                    <button type="submit">📧 Хабарлама жіберу</button>

                    <div id="form-message"></div>
                </form>
            </div>
        </div>
    </div>



</div>