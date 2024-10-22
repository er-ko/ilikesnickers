<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerGroupController extends Controller
{
    private $title = '';
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('customer-groups.index', [
            'groups' => DB::table('customer_groups')
                            ->join('customer_groups_locales', 'customer_groups.id', '=', 'customer_groups_locales.group_id')
                            ->select('customer_groups.id', 'customer_groups.public', 'customer_groups_locales.title')
                            ->where('customer_groups_locales.locale', '=', app()->getLocale())
                            ->orderBy('customer_groups.id', 'asc')
                            ->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customer-groups.create', [
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|boolean',
        ]);
        $created = CustomerGroup::create($validated);

        $count = 0;
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if ($count == 0) { $this->title = $request->title[$key]; }
            if(isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = $this->title;

            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('customer_groups_locales')->insert([
                    'group_id' => $created->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
            $count++;
        }
        return redirect(route('customer-group.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerGroup $customerGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CustomerGroup $customerGroup): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('customer_groups_locales')
                        ->select('title')
                        ->where('group_id', '=', $customerGroup->id)
                        ->where('locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        return view('customer-groups.edit', [
            'customerGroup' => $customerGroup,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerGroup $customerGroup)
    {
        $validated = $request->validate([
            'public' => 'required|boolean',
        ]);
        $customerGroup->update($validated);

        $count = 0;
        DB::table('customer_groups_locales')->where('group_id', '=', $customerGroup->id)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if ($count == 0) { $this->title = $request->title[$key]; }
            if(isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = $this->title;

            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('customer_groups_locales')->insert([
                    'group_id' => $customerGroup->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
            $count++;
        }
        return redirect(route('customer-group.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerGroup $customerGroup): RedirectResponse
    {
        DB::table('customer_groups_locales')->where('group_id', '=', $customerGroup->id)->delete();
        DB::table('customer_groups')->where('id', '=', $customerGroup->id)->delete();
        return redirect(route('customer-group.index'))->with('message', __('messages.alert.removed'));
    }
}
