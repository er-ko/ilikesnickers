<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Country;
use App\Models\Language;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(System $system)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(System $system): View
    {
        return view('system.edit', [
            'app_name'          => System::where('param', 'app_name')->value('value'),
            'meta_suffix'       => System::where('param', 'meta_suffix')->value('value'),
            'default_country'   => System::where('param', 'default_country')->value('value'),
            'default_language'  => System::where('param', 'default_language')->value('value'),
            'default_currency'  => System::where('param', 'default_currency')->value('value'),
            'countries'         => Country::where('public', true)->orderBy('name', 'asc')->get(),
            'languages'         => Language::where('public', true)->orderBy('name', 'asc')->get(),
            'currencies'        => Currency::where('public', true)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = [
            'app_name'          => $request->app_name,
            'meta_suffix'       => $request->meta_suffix,
            'default_country'   => $request->country_id,
            'default_language'  => $request->language_id,
            'default_currency'  => $request->currency_id,
        ];
        $validator = Validator::make($data, [
            'app_name'          => 'required|string|max:64',
            'meta_suffix'       => 'string|max:64',
            'default_country'   => 'required|numeric',
            'default_language'  => 'required|numeric',
            'default_currency'  => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            foreach ($data as $key => $value) {
                DB::table('systems')->where('param', $key)->update(['value' => $value]);
            }
        }
        return redirect(route('system.edit'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(System $system)
    {
        //
    }
}