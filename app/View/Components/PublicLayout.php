<?php

namespace App\View\Components;

use App\Models\Language;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PublicLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.public', [
            'languages' => Language::where('public', operator: true)->orderBy('priority', 'asc')->get(),
        ]);
    }
}
