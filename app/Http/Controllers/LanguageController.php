<?php

namespace App\Http\Controllers;

use App;
use App\Models\Language;
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
            'language' => $language,
            'languages' => Language::where('public', operator: true)->orderBy('name', 'asc')->get(),
            'translates' => $json,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        $data = [];
        foreach ($request->translate_key as $i => $key) {
            $val = $request->translate_val[$i];
            $data[$key] = $val;
        }
        file_put_contents(App::langPath() .'/'. $language->locale .'.json', json_encode($data));

        // Storage::disk('lang')->put($language->locale .'.json', json_encode($data));
        // if (!$request->public && $request->default === $language->locale) {

        //     return redirect(route('language.edit', $language->id))->with('message', __('messages.alert.cannot_set_a_non-public_default_language'));

        // } else {

        //     $validated = $request->validate([
        //         'priority' => 'required|numeric|max:255',
        //         'public' => 'required|numeric|max:1',
        //         'locale' => 'required|string|max:2',
        //         'locale_3' => 'required|string|max:3',
        //         'localname' => 'required|string|max:64',
        //         'decimal_point' => 'required|string|max:1',
        //         'thousand_separator' => 'required|string|max:6',
        //         'time_format' => 'required|string|max:2',
        //         'date_format' => 'required|string|max:5',
        //     ]);

        //     $language->update($validated);
        //     DB::table('languages')->update(['default' => 0]);
        //     DB::table('languages')->where('locale', '=', $request->default)->update(['default' => 1]);
            return redirect(route('language.index'))->with('message', __('messages.alert.successfully_updated'));
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        //
    }

    private function paginate($items, $perPage = 4, $page = null): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentPage = $page;
        $offset = ($currentPage * $perPage) - $perPage;
        $itemsToShow = array_slice($items, $offset, $perPage);
        return new LengthAwarePaginator($itemsToShow, $total, $perPage);
    }
}
