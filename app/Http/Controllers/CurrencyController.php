<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('currencies.index', [
            'default' => System::where('param', 'default_currency')->value('value'),
            'currencies' => Currency::orderBy('id', 'asc')->paginate(15),
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
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency): View
    {
        return view('currencies.edit', [
            'currency' => $currency,
            'default' => System::where('param', 'default_currency')->value('value'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency): RedirectResponse
    {
        if ($request->default == $currency->id && !$request->public) {

            return redirect(route('currency.edit', $currency->id))->with('message', __('this_currency_must_be_public_because_its_default'));

        } else {

            $validated = $request->validate([
                'priority'      => 'required|numeric',
                'public'        => 'required|boolean',
                'code'          => 'required|string|max:3',
                'symbol'        => 'string|max:3',
                'symbol_place'  => 'string|max:6',
                'name'          => 'required|string|max:64',
                'localname'     => 'required|string|max:64',
            ]);

            $currency->update($validated);
            return redirect(route('currency.index'))->with('message', __('successfully_updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
