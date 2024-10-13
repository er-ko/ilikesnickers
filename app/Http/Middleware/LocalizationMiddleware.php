<?php

namespace App\Http\Middleware;

use Closure;
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
        $default = Language::select('locale')
                        ->where('default', operator: true)
                        ->first();

        $locale = Session::get('locale') ?? config('app.locale', $default);
        Session::put('locale', $locale);
        App::setLocale($locale);
        return $next($request);
    }
}
