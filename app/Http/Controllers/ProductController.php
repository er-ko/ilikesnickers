<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\System;
use App\Models\Language;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $title = '';
    private $image = '';
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('products.index', [
            'products' => Db::table('products')
                        ->join('products_locales', 'products.id', '=', 'products_locales.product_id')
                        ->join('languages', 'products_locales.locale', '=', 'languages.locale')
                        ->select('products.id', 'products.public', 'products.virtual', 'products.code', 'products.sku', 'products.slug', 'products_locales.title')
                        ->where('languages.default', '=', 1)
                        ->orderBy('products.id', 'asc')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create', [
            'required' => false,
            'languages' => Language::orderBy('default', 'desc')
                                    ->orderBy('priority', 'asc')
                                    ->get(),
            'cart_mode' => System::where('param', 'cart_mode')->value('value'),
            'vat_payer' => System::where('param', 'vat_payer')->value('value'),
            'manufacturers' => Manufacturer::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'virtual' => 'required|numeric|max:1',
            'manufacturer_id' => 'required|numeric',
            'code' => 'required|string|max:6',
            'sku' => 'string|max:8|nullable',
            'slug' => 'required|string|max:255',
        ]);
        $created = $request->user()->products()->create($validated);
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if (isset($request->title[$key])) $this->title = $request->title[$key]; else $this->title = '';
            if (isset($request->title_h1[$key])) $data['title_h1'] = $request->title_h1[$key]; else $data['title_h1'] = $this->title;
            if (isset($request->meta_title[$key])) $data['meta_title'] = $request->meta_title[$key]; else $data['meta_title'] = $this->title;
            $data['title'] = $this->title;
            $data['content'] = $request->content[$key];
            $data['meta_desc'] = $request->meta_desc[$key];

            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
                'title_h1' => 'string|max:255',
                'content' => 'string|nullable',
                'meta_title' => 'string|max:255',
                'meta_desc' => 'string|max:255|nullable',
            ]);
            if (!$validator->fails()) {
                DB::table('products_locales')->insert([
                    'product_id' => $created->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }

        foreach ($request->locale as $key => $locale) {
            $data           = [];
            $imageFile      = 'image_file_'. $locale;
            $imageTitle     = 'image_title_'. $locale;
            $imageDefault   = 'image_default_'. $locale;
            $imagePriority  = 'image_priority_'. $locale;

            if (isset($request->$imageFile[$key])) {
                foreach ($request->$imageFile as $key2 => $imageItem) {

                    $image = $request->file($imageFile)[$key2]->store('products/'. $created->id);
                    $this->image = Str::remove('products/'. $created->id .'/', $image);

                    $data = [
                        'file' => $this->image,
                        'title' => $request->$imageTitle[$key2],
                        'default' => $request->$imageDefault[$key2],
                        'priority' => $request->$imagePriority[$key2],
                    ];
                    $validator = Validator::make($data, [
                        'file' => 'required|string|max:255',
                        'title' => 'string|max:255|nullable',
                        'default' => 'numeric|max:1',
                        'priority' => 'numeric|max:3',
                    ]);
                    if (!$validator->fails()) {
                        DB::table('products_images')->insert([
                            'product_id' => $created->id,
                            'locale' => $locale,
                            'file' => $data['file'],
                            'title' => $data['title'],
                            'default' => $data['default'],
                            'priority' => $data['priority'],
                        ]);
                    }

                }
            }
        }

        $data = [
            'vat' => $request->vat,
            'regular_price_without_vat' => $request->regular_price_without_vat,
            'regular_price_with_vat' => $request->regular_price_with_vat,
            'promotion_type' => $request->promotion_price_type,
            'promotion_discount' => $request->promotion_discount,
            'promotion_price_without_vat' => $request->promotion_price_without_vat,
            'promotion_price_with_vat' => $request->promotion_price_with_vat,
        ];
        $validator = Validator::make($data, [
            'vat' => 'required|numeric',
            'regular_price_without_vat' => 'required|numeric',
            'regular_price_with_vat' => 'required|numeric',
            'promotion_type' => 'required|string|max:5',
            'promotion_discount' => 'numeric|nullable',
            'promotion_price_without_vat' => 'numeric|nullable',
            'promotion_price_with_vat' => 'numeric|nullable',
        ]);
        if (!$validator->fails()) {
            DB::table('products_prices')->insert([
                'product_id' => $created->id,
                'vat' => $data['vat'],
                'regular_price_without_vat' => $data['regular_price_without_vat'],
                'regular_price_with_vat' => $data['regular_price_with_vat'],
                'promotion_type' => $data['promotion_type'],
                'promotion_discount' => $data['promotion_discount'],
                'promotion_price_without_vat' => $data['promotion_price_without_vat'],
                'promotion_price_with_vat' => $data['promotion_price_with_vat'],
            ]);
        }
        return redirect(route('product.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $data = Db::table('products')
                    ->join('products_locales', 'products.id', '=', 'products_locales.product_id')
                    ->join('products_images', 'products.id', '=', 'products_images.product_id')
                    ->join('products_prices', 'products.id', '=', 'products_prices.product_id')
                    ->join('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
                    ->select('products.id', 'products.code', 'products.slug', 'products_locales.title_h1', 'products_locales.content', 'products_locales.meta_title',
                            'products_locales.meta_description', 'products_images.file', 'products_prices.regular_price_with_vat', 'products_prices.regular_price_without_vat',
                            'promotion_type', 'promotion_discount', 'promotion_price_without_vat', 'promotion_price_with_vat', 'manufacturers.name as manufacturer', 'manufacturers.slug as manufacturer_slug')
                    ->where('products_locales.locale', '=', app()->getLocale())
                    ->where('products_images.default', '=', 1)
                    ->orderBy('products_locales.title', 'asc')
                    ->first();
        $images = Db::table('products_images')
                    ->select('file', 'title')
                    ->where('locale', '=', app()->getLocale())
                    ->where('default', '!=', 1)
                    ->orderBy('priority', 'asc')
                    ->get();
        return view('products.show', [
            'product' => $data,
            'images' => $images,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
