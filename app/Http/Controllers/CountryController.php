<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('countries.index', [
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
            'countries' => Country::where('public', '=', true)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country): RedirectResponse
    {
        $validated = $request->validate([
            'public'    => 'required|boolean',
            'default'   => 'required|numeric',
            'delivery'  => 'required|boolean',
            'code'      => 'required|string|max:3',
            'name'      => 'required|string|max:64',
            'localname' => 'required|string|max:64',
        ]);
        $country->update($validated);
        DB::table('countries')->update(['default' => 0]);
        DB::table('countries')->where('id', '=', $request->default)->update(['default' => 1]);
        return redirect(route('country.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
