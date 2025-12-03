<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Тілді тексереміз
        if (!in_array($locale, ['kaz', 'rus', 'en'])) {
            $locale = 'kaz';
        }
        
        // Сессияға сақтаймыз
        Session::put('locale', $locale);
        
        // Тілді орнатамыз
        App::setLocale($locale);
        
        // Алдыңғы бетке қайтамыз
        return back();
    }
}