<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Бот-консультанттан хабарлама</title>
</head>
<body>
    <h2>Жаңа хабарлама бот-консультанттан</h2>
    
    <p><strong>Аты:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Хабарлама:</strong></p>
    <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 10px 0;">
        {{ $userMessage }}
    </div>
    
    <hr>
    <p style="color: #666; font-size: 12px;">
        Бұл хабарлама сайттың бот-консультанты арқылы жіберілді.
    </p>
</body>
</html>