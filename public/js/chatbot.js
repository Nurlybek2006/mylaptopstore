// Бот тек қажетті беттерде болсын
const allowedPages = [
    '/',
    '/products',
    '/about'
];

// Өнім детальды беттерін тексеру (/products/1, /products/2, т.б.)
const currentPath = window.location.pathname;
const isProductDetailPage = /^\/products\/\d+$/.test(currentPath);

// Ағымдағы бет ботқа рұқсат етілген бе?
const isAllowedPage = allowedPages.includes(currentPath) || isProductDetailPage;

// DOM жүктелгеннен кейін
document.addEventListener('DOMContentLoaded', function() {
    if (!isAllowedPage) {
        // Егер бет рұқсат етілмеген болса, ботты толығымен жою
        const chatbot = document.querySelector('.chat-toggle-button, .chat-overlay, .chat-modal');
        if (chatbot) {
            chatbot.remove();
        }
        return;
    }

    // Ботты бастау
    initChatbot();
});

function initChatbot() {
    console.log('Бот іске қосылды!');
    
    // Ағымдағы уақытты жаңарту
    updateTime();
    setInterval(updateTime, 1000);

    // Enter пернесін басу
    const chatInput = document.getElementById('chat-input');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    }

    // Email формасын өңдеу
    const emailForm = document.getElementById('email-form');
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const messageDiv = document.getElementById('form-message');
            
            submitButton.classList.add('loading');
            submitButton.textContent = 'Жіберілуде...';
            messageDiv.innerHTML = '';
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = `<div class="success-message">${data.message}</div>`;
                    this.reset();
                } else {
                    messageDiv.innerHTML = `<div class="error-message">${data.message}</div>`;
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<div class="error-message">Жіберу кезінде қате пайда болды</div>';
            })
            .finally(() => {
                submitButton.classList.remove('loading');
                submitButton.textContent = '📧 Хабарлама жіберу';
            });
        });
    }
}

// Ағымдағы уақытты жаңарту
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('kk-KZ', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: false 
    });
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Чатты ашу
function openChat() {
    document.getElementById('chatModal').style.display = 'flex';
    document.getElementById('chatOverlay').style.display = 'block';
    const chatInput = document.getElementById('chat-input');
    if (chatInput) {
        chatInput.focus();
    }
}

// Чатты жабу
function closeChat() {
    document.getElementById('chatModal').style.display = 'none';
    document.getElementById('chatOverlay').style.display = 'none';
}

// Табтарды ауыстыру
function switchTab(tabName) {
    // Барлық табтарды жасыру
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Барлық таб баттамаларын жасыру
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Белгіленген табты көрсету
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

// Хабарлама жіберу
async function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    if (message === '') return;
    
    addMessage(message, 'user');
    input.value = '';
    
    // Бот жауабын көрсету
    showTypingIndicator();
    
    try {
        const botResponse = await getChatGPTResponse(message);
        hideTypingIndicator();
        addMessage(botResponse, 'bot');
    } catch (error) {
        hideTypingIndicator();
        addMessage('Кешіріңіз, қате пайда болды. Қайталап көріңіз.', 'bot');
        console.error('ChatGPT қатесі:', error);
    }
}

// ChatGPT API арқылы жауап алу
async function getChatGPTResponse(userMessage) {
    const response = await fetch('/chatbot/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            message: userMessage
        })
    });

    if (!response.ok) {
        throw new Error('API қатесі');
    }

    const data = await response.json();
    
    if (data.error) {
        throw new Error(data.error);
    }

    return data.choices[0].message.content;
}

// Хабарламаны қосу
function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const now = new Date();
    const timeString = now.toLocaleTimeString('kk-KZ', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: false 
    });
    
    messageDiv.innerHTML = `
        <div class="message-text">${text}</div>
        <div class="message-time">${timeString}</div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Енгізу индикаторын көрсету
function showTypingIndicator() {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) {
        indicator.classList.add('show');
    }
}

// Енгізу индикаторын жасыру
function hideTypingIndicator() {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) {
        indicator.classList.remove('show');
    }
}