<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Country;
use App\Models\Language;
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
            'system'    => System::first(),
            'countries' => Country::orderBy('name', 'asc')->get(),
            'languages' => Language::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, System $system): RedirectResponse
    {
        $data = [
            'app_name'      => $request->app_name,
            'meta_suffix'   => $request->meta_suffix,
            'country_id'    => $request->country_id,
            'language_id'   => $request->language_id,
        ];
        $validator = Validator::make($data, [
            'app_name'      => 'required|string|max:64',
            'meta_suffix'   => 'string|max:64',
            'country_id'    => 'required|numeric',
            'language_id'   => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            DB::table('systems')->update(values: [
                'app_name'      => $data['app_name'],
                'meta_suffix'   => $data['meta_suffix'],
                'country_id'    => $data['country_id'],
                'language_id'   => $data['language_id'],
            ]);
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
