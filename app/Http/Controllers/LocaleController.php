<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($lang)
    {
        $languages = Language::select('locale', 'time_format', 'date_format')
                            ->where('public', operator: true)
                            ->orderBy('id', 'asc')
                            ->get();

        foreach ($languages as $language) {
            if ($language->locale === $lang) {
                App::setLocale($lang);
                Session::put('locale', $lang);
                Session::put('time_format', $language->time_format);
                Session::put('date_format', $language->date_format);
                return back();
            }
        }
    }
}
