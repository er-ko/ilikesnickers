<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\System;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('countries.index', [
            'default'   => System::where('param', 'default_country')->value('value'),
            'countries' => Country::orderBy('id', 'asc')->paginate(15),
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
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country): View
    {
        return view('countries.edit', [
            'country' => $country,
            'default' => System::where('param', 'default_country')->value('value'),
            'countries' => Country::where('public', '=', true)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country): RedirectResponse
    {
        if ($request->default == $country->id && !$request->public) {

            return redirect(route('country.edit', $country->id))->with('message', __('this_country_must_be_public_because_its_default'));

        } else {

            $validated = $request->validate([
                'public'    => 'required|boolean',
                'delivery'  => 'required|boolean',
                'code'      => 'required|string|max:3',
                'name'      => 'required|string|max:64',
                'localname' => 'required|string|max:64',
            ]);

            $country->update($validated);
            return redirect(route('country.index'))->with('message', __('successfully_updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
