<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductGroupController extends Controller
{

    private $title = '';
    private $value = '';
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('product-groups.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('product-groups.create', [
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'priority' => 'required|numeric',
        ]);

        $created        = $request->user()->productGroups()->create($validated);
        $defaultTitle   = $request->title[0];
        $localesValues  = array_chunk($request->value, $request->count_value);
        $defaultValues  = $localesValues[0];

        foreach ($request->locale as $key => $locale) {
            if (isset($request->title[$key])) $this->title = $request->title[$key]; else $this->title = $defaultTitle;
            $data = [];
            $data['title'] = $this->title;
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('product_groups_locales')->insert([
                    'group_id' => $created->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }

            foreach (array_chunk($request->value, $request->count_value)[$key] as $key2 => $value) {
                $dataValue = [];
                if (isset($value)) $this->value = $value; else $this->value = $defaultValues[$key2];
                $dataValue['value'] = $this->value;
                $validator = Validator::make($dataValue, [
                    'value' => 'required|string|max:255',
                ]);
                if (!$validator->fails()) {
                    DB::table('product_groups_values')->insert([
                        'group_id' => $created->id,
                        'locale' => $locale,
                        'value' => $dataValue['value'],
                    ]);
                }
            }
        }
        return redirect(route('category.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGroup $productGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductGroup $productGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        //
    }
}
