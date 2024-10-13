<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $locale = $request->get('locale');
            DB::table('languages')->update(['default' => 0]);
            DB::table('languages')->where('locale', $locale)->update(values: ['default' => 1]);
            Session::put('message', __('messages.alert.successfully_updated'));

        }  else {

            return view('languages.index', [
                'languages' => Language::orderBy('id', 'asc')->paginate(15),
            ]);
        }
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
        return view('languages.edit', [
            'language' => $language,
            'languages' => Language::where('public', operator: true)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language): RedirectResponse
    {
        if (!$request->public && $request->default === $language->locale) {

            return redirect(route('language.edit', $language->id))->with('message', __('messages.alert.cannot_set_a_non-public_default_language'));

        } else {

            $validated = $request->validate([
                'priority' => 'required|numeric|max:255',
                'public' => 'required|numeric|max:1',
                'locale' => 'required|string|max:2',
                'locale_3' => 'required|string|max:3',
                'localname' => 'required|string|max:64',
                'decimal_point' => 'required|string|max:1',
                'thousand_separator' => 'required|string|max:6',
                'time_format' => 'required|string|max:2',
                'date_format' => 'required|string|max:5',
            ]);

            $language->update($validated);
            DB::table('languages')->update(['default' => 0]);
            DB::table('languages')->where('locale', $request->default)->update(['default' => 1]);
            return redirect(route('language.index'))->with('message', __('messages.alert.successfully_updated'));
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
