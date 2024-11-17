<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    private $title = '';
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.index', [
            'pages' => Db::table('pages')
                        ->join('pages_locales', 'pages.id', '=', 'pages_locales.page_id')
                        ->join('languages', 'pages_locales.locale', '=', 'languages.locale')
                        ->select('pages.id', 'pages.public', 'pages.slug', 'pages_locales.title')
                        ->where('languages.default', '=', 1)
                        ->orderBy('pages.id', 'asc')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.create', [
            'required' => false,
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
            'slug' => 'required|string|max:255',
        ]);
        $created = $request->user()->pages()->create($validated);

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
                DB::table('pages_locales')->insert([
                    'page_id' => $created->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }
        return redirect(route('page.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page): View|RedirectResponse
    {
        if ($page->public) {
            $output = Db::table('pages')
                        ->join('pages_locales', 'pages.id', '=', 'pages_locales.page_id')
                        ->select('pages.id', 'pages_locales.title_h1', 'pages_locales.content', 'pages_locales.meta_title', 'pages_locales.meta_description')
                        ->where('pages.slug', '=', $page->slug)
                        ->where('pages_locales.locale', '=', app()->getLocale())
                        ->first();
            
            if (!$output) return redirect('404');
            return view('pages.show', ['page' => $output]);
        }
        else return redirect('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Page $page): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('pages')
                        ->join('pages_locales', 'pages.id', '=', 'pages_locales.page_id')
                        ->select('pages_locales.title', 'pages_locales.title_h1', 'pages_locales.content', 'pages_locales.meta_title', 'pages_locales.meta_description')
                        ->where('pages.id', '=', $page->id)
                        ->where('pages_locales.locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        return view('pages.edit', [
            'page' => $page,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'slug' => 'required|string|max:255',
        ]);
        $page->update($validated);
        DB::table('pages_locales')->where('page_id', '=', $page->id)->delete();
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
                DB::table('pages_locales')->insert([
                    'page_id' => $page->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }
        return redirect(route('page.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        DB::table('pages_locales')->where('page_id', '=', $page->id)->delete();
        DB::table('pages')->where('id', '=', $page->id)->delete();
        return redirect(route('page.index'))->with('message', __('messages.alert.removed'));
    }
}
