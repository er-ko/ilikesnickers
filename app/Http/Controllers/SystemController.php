<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
            'system'    => System::with('user')->where('user_id', auth()->id())->first(),
            'countries' => Country::orderBy('name', 'asc')->get(),
            'languages' => Language::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, System $system): RedirectResponse
    {
        $validated = $request->validate([
            'app_name'      => 'required|string|max:64',
            'meta_suffix'   => 'string|max:64',
            'country_id'    => 'required|numeric',
            'language_id'   => 'required|numeric',
        ]);
        $request->user()->systems()->update($validated);
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
