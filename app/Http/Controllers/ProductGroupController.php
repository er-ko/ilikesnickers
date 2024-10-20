<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
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
        return view('product-groups.index', [
            'groups' => Db::table('product_groups')
                            ->join('product_groups_locales', 'product_groups.id', '=', 'product_groups_locales.group_id')
                            ->join('languages', 'product_groups_locales.locale', '=', 'languages.locale')
                            ->select('product_groups.id', 'product_groups.public', 'product_groups.priority', 'product_groups_locales.title')
                            ->where('languages.default', '=', 1)
                            ->orderBy('product_groups.created_at', 'desc')->paginate(15),
        ]);
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
        $localesValues  = array_chunk($request->value, count($request->value) / count($request->locale));
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

            foreach ($localesValues[$key] as $key2 => $value) {
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
        return redirect(route('product-group.index'))->with('message', __('messages.alert.successfully_created'));
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
    public function edit(Request $request, ProductGroup $productGroup): Collection|View|JsonResponse
    {
        if ($request->ajax()) {

            $locale = $request->get('locale');
            if ($request->get('type') === 'title') {

                $data = Db::table('product_groups')
                            ->join('product_groups_locales', 'product_groups.id', '=', 'product_groups_locales.group_id')
                            ->select('product_groups_locales.title')
                            ->where('product_groups.id', '=', $productGroup->id)
                            ->where('product_groups_locales.locale', '=', $locale)
                            ->get();

            } elseif ($request->get('type') === 'values') {

                $data = Db::table('product_groups')
                            ->join('product_groups_values', 'product_groups.id', '=', 'product_groups_values.group_id')
                            ->select('product_groups_values.locale', 'product_groups_values.value')
                            ->where('product_groups.id', '=', $productGroup->id)
                            ->where('product_groups_values.locale', '=', $locale)
                            ->orderBy('product_groups_values.id', 'asc')
                            ->get();
            }
            
            return response()->json($data);
        }

        return view('product-groups.edit', [
            'productGroup' => $productGroup,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductGroup $productGroup): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'priority' => 'required|numeric',
        ]);

        $productGroup->update(attributes: $validated);
        $defaultTitle   = $request->title[0];
        $localesValues  = array_chunk($request->value, count($request->value) / count($request->locale));
        $defaultValues  = $localesValues[0];

        DB::table('product_groups_locales')->where('group_id', '=', $productGroup->id)->delete();
        foreach ($request->locale as $key => $locale) {
            if (isset($request->title[$key])) $this->title = $request->title[$key]; else $this->title = $defaultTitle;
            $data = [];
            $data['title'] = $this->title;
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('product_groups_locales')->insert([
                    'group_id' => $productGroup->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }

            DB::table('product_groups_values')->where('group_id', '=', $productGroup->id)->where('locale', '=', $locale)->delete();
            foreach ($localesValues[$key] as $key2 => $value) {
                $dataValue = [];
                if (isset($value)) $this->value = $value; else $this->value = $defaultValues[$key2];
                $dataValue['value'] = $this->value;
                $validator = Validator::make($dataValue, [
                    'value' => 'required|string|max:255',
                ]);
                if (!$validator->fails()) {
                    DB::table('product_groups_values')->insert([
                        'group_id' => $productGroup->id,
                        'locale' => $locale,
                        'value' => $dataValue['value'],
                    ]);
                }
            }
        }
        return redirect(route('product-group.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        DB::table('product_groups_values')->where('group_id', '=', $productGroup->id)->delete();
        DB::table('product_groups_locales')->where('group_id', '=', $productGroup->id)->delete();
        DB::table('product_groups')->where('id', '=', $productGroup->id)->delete();
        return redirect(route('product-group.index'))->with('message', __('messages.alert.removed'));
    }
}
