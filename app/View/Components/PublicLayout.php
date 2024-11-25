<?php

namespace App\View\Components;

use App\Models\Language;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class PublicLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $pages = DB::table('pages')
                    ->join('pages_locales', 'pages.id', '=', 'pages_locales.page_id')
                    ->select('pages.slug', 'pages_locales.title')
                    ->where('pages.public', true)
                    ->where('pages_locales.locale', app()->getLocale())
                    ->orderBy('pages.priority', 'asc')
                    ->get();

        return view('layouts.public', [
            'app_name' => DB::table('systems')->where('param', 'app_name')->value('value'),
            'languages' => Language::where('public', operator: true)->orderBy('priority', 'asc')->get(),
            'pages' => $pages,
        ]);
    }
}
