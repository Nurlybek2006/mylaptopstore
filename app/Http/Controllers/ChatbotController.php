<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactEmail;

class ChatbotController extends Controller
{
    // ChatGPT API сұранысы
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $userMessage = $request->input('message');

        $apiKey = config('services.openai.api_key');
        
        if (empty($apiKey)) {
            return response()->json([
                'error' => 'API кілті жоқ'
            ], 500);
        }

        $data = [
            "model" => "gpt-4o-mini",
            "messages" => [
                [
                    "role" => "system", 
                    "content" => "Сіз Laptop-store интернет-дүкенінің ақылды AI көмекшісісіз. Бірінші «Сәлеметсіз бе!» деп амандасып, содан кейін қысқа, түсінікті және мейірімді жауап беріңіз. Сайттың мүмкіндіктері төмендегідей:
                    Ноутбуктер мен аксессуарларды көру, бағасын және сипаттамасын оқу
                    Өнімді себетке қосу, себеттен өшіру, тапсырыс жасау
                    Пайдаланушы тіркелуі, кіру/шығу, профиль көру
                    Тапсырыстар дерекқорға сақталады
                    Байланыс формасы арқылы хабарласу (email), WhatsApp/телефон батырмалары
                    Интерактивті карта (Leaflet) арқылы дүкеннің мекенжайын көру
                    Іздеу және категориялар бойынша фильтр
                    Сіз осы мүмкіндіктерге сүйене отырып, қолданушыға көмектесуіңіз керек.
                    
                    **САЙТТЫҢ НЕ ІСТЕЙ АЛАМЫН:**
                    
                    🏠 **БАСТЫ БЕТ** (жоғарғы менюдегі бірінші сілтеме)
                    • Сайтқа кіргенде көрсетілетін негізгі бет
                    • Таңдаулы ноутбуктер мен аксессуарларды көру
                    • Статистика және ең сатылатын өнімдер
                    • Өнімдерді көру үшін «Сатып алуға өту» батырмасы
                    
                    🛒 **ӨНІМДЕРДІ КӨРУ ЖӘНЕ ІЗДЕУ** (жоғарғы менюде «Өнімдер»)
                    • Барлық ноутбуктер мен аксессуарлардың тізімі
                    • Категория бойынша сүзу (тек ноутбуктер, тек аксессуарлар т.б.)
                    • Өнімдерді атауы бойынша іздеу
                    • Әрбір өнім карточкасына басып, толық ақпаратты көру
                    
                    📱 **ӨНІМ ТОЛЫҚ СИПАТТАМАСЫ** (өнім карточкасынан «Көру» батырмасы)
                    • Нақты бір өнімнің барлық суреттері мен сипаттамалары
                    • Бағасын көру
                    • Қалаған санын таңдап, себетке қосу
                    • «Себетке қосу» батырмасы арқылы сатып алуды бастау
                    
                    🛍️ **СЕБЕТ ЖӘНЕ ТАПСЫРЫС** (жоғарғы менюде «Себет»)
                    • Себетке қосқан барлық өнімдерді көру
                    • Өнім санын өзгерту немесе жою
                    • Жалпы соманы есептеу
                    • «Тапсырыс беру» батырмасы арқылы сатып алуды аяқтау
                    
                    👨‍💼 **ТІРКЕЛУ ЖӘНЕ ПРОФИЛЬ** (жоғарғы меню оң жағы)
                    • Жаңа пайдаланушы ретінде тіркелу
                    • Жүйеге кіру/шығу
                    • Өз профилін көру және тапсырыстар тарихы
                    • Құпия сөзді өзгерту
                    
                    📞 **БАЙЛАНЫС ЖӘНЕ КӨМЕК**
                    • **Біз туралы** бетінде: компания ақпараты, карта, телефон, WhatsApp батырмалары
                    • **Байланыс** бетінде: электрондық пошта арқылы хабарласу формасы
                    • **Көмек сұрау** батырмасы: кез келген беттің төменгі оң жағында
                    
                    🗺️ **ДҮКЕНДІ ТАБУ**
                    • «Біз туралы» бетінде интерактивті карта
                    • Дүкеннің нақты мекенжайы
                    • Google Maps арқылы бағыт алу мүмкіндігі
                    Мекенжай
                    Алматы қаласы,
                    Шұғыла мкр,
                    Береке 2/13.
                    
                    **ЖҮЙЕГЕ КІРУ ЕРЕЖЕЛЕРІ:**
                    1. бір рет қана «Сәлеметсіз бе!» деп амандасыңыз одан кейін амандаспаңыз
                    2. Қысқа, түсінікті және мейірімді болыңыз  
                    3. Қолданушыға нақты қадамдарды көрсетіңіз (мысалы: «Жоғарғы менюдегі Өнімдерді басып, сүзгіні қолданыңыз»)
                    4. Барлық жауаптарды қазақ тілінде беріңіз орысша жазса орысша жауап беріңіз
                    5. Қолданушының қандай мәселесі болса, оған сәйкес бетті ұсыныңыз
                    Бұл сайт ноутбуктер мен аксессуарларды сатуға арналған интернет-дүкен болып табылады. Қолданушыға осы сайттың мүмкіндіктері туралы ақпарат беріңіз және қажетті көмекті көрсетіңіз, Басқа тақырыптарға ауытқымай, тек осы сайттың мүмкіндіктері шеңберінде жауап беріңіз."
                ],
                [
                    "role" => "user", 
                    "content" => $userMessage
                ]
            ],
            "max_tokens" => 1500,
            "temperature" => 0.7,
            "top_p" => 0.9,
            "frequency_penalty" => 0.1,
            "presence_penalty" => 0.1
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $apiKey
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'ChatGPT-PHP-Client/1.0'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::error('ChatGPT cURL қатесі: ' . $curlError);
            return response()->json([
                'error' => 'Қосылым қатесі'
            ], 500);
        }

        if ($httpCode !== 200) {
            Log::error('ChatGPT API қатесі: ' . $httpCode . ' - ' . $response);
            return response()->json([
                'error' => 'API қатесі'
            ], $httpCode);
        }

        $responseData = json_decode($response, true);
        
        if (!isset($responseData['choices'][0]['message']['content'])) {
            return response()->json([
                'error' => 'Жауап форматы жарамсыз'
            ], 500);
        }

        return response()->json($responseData);
    }

    // Email жіберу
    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000'
        ]);

        try {
            // Админге email жіберу
            Mail::to(config('mail.admin_email'))
                ->send(new ContactEmail(
                    $request->name,
                    $request->email,
                    $request->message
                ));

            return response()->json([
                'success' => true,
                'message' => 'Хабарламаңыз сәтті жіберілді!'
            ]);
        } catch (\Exception $e) {
            Log::error('Email жіберу қатесі: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Хабарлама жіберу кезінде қате пайда болды. Қайталап көріңіз.'
            ], 500);
        }
    }
}