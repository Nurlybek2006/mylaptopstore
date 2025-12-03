// Marketplace чат функциялары
class MarketplaceChat {
    constructor() {
        this.authUserId = document.querySelector('meta[name="user-id"]')?.getAttribute('content') || window.authUserId;
        this.chatUserId = document.querySelector('meta[name="chat-user-id"]')?.getAttribute('content') || window.chatUserId;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        this.initializeEventListeners();
        this.setupAutoRefresh();
    }
    
    initializeEventListeners() {
        // Хабарлама жіберу
        const chatForm = document.getElementById('chatForm');
        if (chatForm) {
            chatForm.addEventListener('submit', (e) => this.handleMessageSubmit(e));
        }
        
        // Enter басылғанда
        const messageInput = document.getElementById('messageInput');
        if (messageInput) {
            messageInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm?.dispatchEvent(new Event('submit'));
                }
            });
            
            messageInput.addEventListener('input', () => {
                this.adjustTextareaHeight(messageInput);
            });
        }
    }
    
    adjustTextareaHeight(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
    }
    
    async handleMessageSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const messageInput = form.querySelector('textarea[name="message"]');
        const receiverInput = form.querySelector('input[name="receiver_id"]');
        const message = messageInput.value.trim();
        
        if (!message) {
            alert('Хабарлама жазыңыз!');
            return;
        }
        
        try {
            // FormData қолдану
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.appendMessage(result.message);
                messageInput.value = '';
                messageInput.style.height = 'auto';
                this.scrollToBottom();
                
                // Форманы тазарту
                form.reset();
                
                // 1 секундтан кейін бетті жаңарту
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert('Қате: ' + (result.message || 'Хабарлама жіберілмеді'));
            }
        } catch (error) {
            console.error('Қате орын алды:', error);
            alert('Серверге қосылу мүмкін емес');
        }
    }
    
    appendMessage(message) {
        const chatMessages = document.getElementById('chatMessages');
        const isSent = message.sender_id == this.authUserId;
        
        const messageElement = document.createElement('div');
        messageElement.className = `message mb-3 ${isSent ? 'sent' : 'received'}`;
        
        const messageDate = new Date(message.created_at);
        const formattedDate = messageDate.toLocaleDateString('kk-KZ') + ' ' + 
                             messageDate.toLocaleTimeString('kk-KZ', { 
                                 hour: '2-digit', 
                                 minute: '2-digit' 
                             });
        
        // Product info
        let productInfoHtml = '';
        if (message.product_id) {
            const productTitle = message.product?.title || 'Тауар жоқ';
            const productStyle = isSent ? 
                'background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);' : 
                'background: #e3f2fd; border: 1px solid rgba(52,152,219,0.2);';
            
            productInfoHtml = `
                <div class="product-info mb-2 p-2 rounded" style="${productStyle}">
                    <i class="fas fa-tag me-1"></i>
                    Тауар: ${productTitle}
                </div>
            `;
        }
        
        // Background стильдері
        const backgroundStyle = isSent ? 
            'background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; margin-left: auto;' : 
            'background: white; margin-right: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.08);';
        
        // Message time стильдері
        const messageTimeStyle = isSent ? 
            'text-align: right; opacity: 0.8;' : 
            'text-align: left; opacity: 0.8;';
        
        messageElement.innerHTML = `
            <div class="message-wrapper p-3 rounded-3" 
                 style="max-width: 70%; ${backgroundStyle}">
                ${productInfoHtml}
                <div class="message-text">${this.escapeHtml(message.message)}</div>
                <div class="message-time small mt-2" 
                     style="${messageTimeStyle}">
                    ${formattedDate}
                </div>
            </div>
        `;
        
        chatMessages.appendChild(messageElement);
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    setupAutoRefresh() {
        // Чат бетінде болса, авто-жаңартуды қосу
        if (window.location.pathname.includes('/marketplace/chat/')) {
            setInterval(() => {
                this.refreshMessages();
            }, 30000); // 30 секунд сайын
        }
    }
    
    refreshMessages() {
        if (!this.chatUserId) return;
        
        fetch(`/marketplace/chat/${this.chatUserId}/messages`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Хабарламаларды жаңарту
                    const currentMessages = document.querySelectorAll('#chatMessages .message');
                    if (data.messages.length > currentMessages.length) {
                        location.reload(); // Жаңа хабарлама болса, бетті жаңарту
                    }
                }
            })
            .catch(error => console.error('Қате орын алды:', error));
    }
}

// Документ дайын болғанда инициализациялау
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.chat-container')) {
        window.marketplaceChat = new MarketplaceChat();
    }
});