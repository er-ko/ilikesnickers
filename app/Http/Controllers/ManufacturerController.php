<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManufacturerController extends Controller
{
    private $image = false;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (auth()->id()) {

            $manufacturers = Db::table('manufacturers')
                        ->join('manufacturers_locales', 'manufacturers.id', '=', 'manufacturers_locales.manufacturer_id')
                        ->join('languages', 'manufacturers_locales.locale', '=', 'languages.locale')
                        ->select('manufacturers.id', 'manufacturers.slug', 'manufacturers.name')
                        ->where('languages.default', '=', 1)
                        ->orderBy('manufacturers.created_at', 'desc')->paginate(15);

        } else {

            $manufacturers = Db::table('manufacturers')
                        ->join('manufacturers_locale', 'manufacturers.id', '=', 'manufacturers_locale.manufacturer_id')
                        ->select('manufacturers.id', 'manufacturers.image', 'manufacturers.slug', 'manufacturers_locales.title_h1')
                        ->where('manufacturers_locales.locale', '=', app()->getLocale())
                        ->orderBy('manufacturers.created_at', 'desc')->paginate(15);
                    }
        return view('manufacturers.index', [ 'manufacturers' => $manufacturers ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('manufacturers.create', [
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
        if (isset($request->image)) {

            $image = $request->file('image')->store('manufacturers');
            $this->image = Str::remove('manufacturers/', $image);
        }
        $validated['image'] = $this->image;
        $created = $request->user()->manufacturers()->create($validated);

        foreach ($request->locale as $key => $locale) {
            $data = [];
            $data['content'] = $request->content[$key];

            $validator = Validator::make($data, [
                'content' => 'string|nullable',
            ]);
            if (!$validator->fails()) {
                DB::table('manufacturers_locales')->insert([
                    'manufacturer_id' => $created->id,
                    'locale' => $locale,
                    'content' => $data['content'],
                ]);
            }
        }
        return redirect(route('manufacturer.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Manufacturer $manufacturer)
    {
        $output = Db::table('manufacturers')
                    ->join('manufacturers_locales', 'manufacturers.id', '=', 'manufacturers_locales.manufacturer_id')
                    ->select('manufacturers.id', 'manufacturers.image', 'manufacturers.name', 'manufacturers_locales.content')
                    ->where('manufacturers.slug', '=', $manufacturer->slug)
                    ->where('manufacturers_locales.locale', '=', app()->getLocale())
                    ->first();

        if (!$output) return redirect('404');
        return view('manufacturers.show', ['manufacturer' => $output]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Manufacturer $manufacturer): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('manufacturers_locales')
                        ->select('content')
                        ->where('manufacturer_id', '=', $manufacturer->id)
                        ->where('locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        return view('manufacturers.edit', [
            'manufacturer' => $manufacturer,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturer $manufacturer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
        if (isset($request->image)) {
            if (Storage::exists('manufacturers/'. $manufacturer->image)) Storage::delete('manufacturers/'. $manufacturer->image);
            $image = $request->file('image')->store('manufacturers');
            $this->image = Str::remove('manufacturers/', $image);
            $validated['image'] = $this->image;
        }
        $manufacturer->update($validated);
        DB::table('manufacturers_locales')->where('manufacturer_id', '=', $manufacturer->id)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            $data['content'] = $request->content[$key];

            $validator = Validator::make($data, [
                'content' => 'string|nullable',
            ]);
            if (!$validator->fails()) {
                DB::table('manufacturers_locales')->insert([
                    'manufacturer_id' => $manufacturer->id,
                    'locale' => $locale,
                    'content' => $data['content'],
                ]);
            }
        }
        return redirect(route('manufacturer.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer): RedirectResponse
    {
        if (Storage::exists('manufacturers/'. $manufacturer->image)) Storage::delete('manufacturers/'. $manufacturer->image);
        DB::table('manufacturers_locales')->where('manufacturer_id', '=', $manufacturer->id)->delete();
        DB::table('manufacturers')->where('id', '=', $manufacturer->id)->delete();
        return redirect(route('manufacturer.index'))->with('message', __('messages.alert.removed'));
    }
}