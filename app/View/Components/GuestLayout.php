<?php

namespace App\View\Components;

use App\Models\Language;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest', [
            'languages' => Language::where('public', operator: true)->orderBy('priority', 'asc')->get(),
        ]);
    }
}
