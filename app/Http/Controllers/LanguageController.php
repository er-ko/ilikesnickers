<?php

namespace App\Http\Controllers;

use App;
use App\Models\Language;
use App\Models\System;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('languages.index', [
            'default' => System::where('param', 'default_language')->value('value'),
            'languages' => Language::orderBy('id', 'asc')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language): View
    {
        $contents = File::get(base_path('lang/'. $language->locale .'.json'));
        $json = json_decode(json: $contents, associative: true);
        ksort($json);
        return view('languages.edit', [
            'default' => System::where('param', 'default_language')->value('value'),
            'language' => $language,
            'languages' => Language::where('public', operator: true)->orderBy('name', 'asc')->get(),
            'translates' => $json,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language): RedirectResponse
    {
        $data = [];
        foreach ($request->translate_key as $i => $key) {
            $val = $request->translate_val[$i];
            $data[$key] = $val;
        }
        file_put_contents(App::langPath() .'/'. $language->locale .'.json', json_encode($data));

        if ($request->default == $language->id && !$request->public) {

            return redirect(route('language.edit', $language->id))->with('message', __('this_language_must_be_public_because_its_default'));

        } else {

            $validated = $request->validate([
                'priority' => 'required|numeric',
                'public' => 'required|boolean',
                'locale' => 'required|string|max:2',
                'locale_3' => 'required|string|max:3',
                'localname' => 'required|string|max:64',
                'decimal_point' => 'required|string|max:1',
                'thousand_separator' => 'required|string|max:6',
                'time_format' => 'required|string|max:2',
                'date_format' => 'required|string|max:5',
            ]);

            $language->update($validated);
            return redirect(route('language.index'))->with('message', __('successfully_updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        //
    }
}
