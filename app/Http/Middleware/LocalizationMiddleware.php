<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\System;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $default = System::where('param', 'default_language')->value('value');
        $data = Language::select('locale', 'time_format', 'date_format')
                        ->where('id', operator: $default)
                        ->first();

        $locale = Session::get('locale') ?? config('app.locale', $data->locale);
        Session::put('locale', $locale);
        $timeFormat = Session::get('time_format') ?? $data->time_format;
        $dateFormat = Session::get('date_format') ?? $data->date_format;
        Session::put('time_format', $timeFormat);
        Session::put('date_format', $dateFormat);
        App::setLocale($locale);
        return $next($request);
    }
}
