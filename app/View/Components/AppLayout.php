<?php

namespace App\View\Components;

use App\Models\Language;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app2', [
            'languages' => Language::where('public', operator: true)->orderBy('id', 'asc')->get(),
        ]);
    }
}
