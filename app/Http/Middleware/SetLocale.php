<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // URL арқылы: ?lang=kaz
        if ($request->has('lang')) {
            $lang = $request->query('lang');
            $availableLocales = ['kaz', 'rus', 'en'];

            if (in_array($lang, $availableLocales)) {
                Session::put('locale', $lang);
                App::setLocale($lang);
            }
        }
        // Сессияда болса — соны қолданамыз
        elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        // Ештеңе болмаса — config(app.locale)
        else {
            App::setLocale(config('app.locale', 'kaz'));
        }

        return $next($request);
    }
}
