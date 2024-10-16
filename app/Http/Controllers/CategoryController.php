<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

class CategoryController extends Controller
{
    private $title = '';
    private $image = false;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (auth()->id()) {

            $categories = Db::table('categories')
                        ->join('categories_locales', 'categories.id', '=', 'categories_locales.category_id')
                        ->join('languages', 'categories_locales.locale', '=', 'languages.locale')
                        ->select('categories.id', 'categories.public', 'categories.slug', 'categories_locales.title')
                        ->where('languages.default', '=', 1)
                        ->orderBy('categories.created_at', 'desc')->paginate(15);

        } else {

            $categories = Db::table('categories')
                        ->join('categories_locales', 'categories.id', '=', 'categories_locales.category_id')
                        ->select('categories.id', 'categories.public', 'categories.image', 'categories.slug', 'categories.created_at', 'categories_locales.locale',
                                'categories_locales.title', 'categories_locales.title_h1', 'categories_locales.content', 'categories_locales.meta_title', 'categories_locales.meta_description')
                        ->where('categories_locales.locale', '=', app()->getLocale())
                        ->orderBy('categories.created_at', 'desc')->paginate(15);
                    }
        return view('categories.index', [ 'categories' => $categories ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create', [
            'required' => false,
            'languages' => Language::orderBy('default', 'desc')
                                    ->orderBy('priority', 'asc')
                                    ->get(),
            'parents' => Db::table('categories')
                            ->join('categories_locales', 'categories.id', '=', 'categories_locales.category_id')
                            ->select('categories.id', 'categories_locales.title')
                            ->where('categories.public', true)
                            ->where('categories_locales.locale', app()->getLocale())
                            ->orderBy('categories_locales.title', 'asc')
                            ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'parent_id' => 'required|numeric',
            'slug' => 'required|string|max:255',
        ]);
        if (isset($request->image)) {

            $image = $request->file('image')->store('categories');
            $this->image = Str::remove('categories/', $image);
        }
        $validated['image'] = $this->image;
        $created = $request->user()->categories()->create($validated);

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
                DB::table('posts_locales')->insert([
                    'post_id' => $created->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }
        return redirect(route('category.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Category $category): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('categories')
                        ->join('categories_locales', 'categories.id', '=', 'categories_locales.category_id')
                        ->select('categories_locales.title', 'categories_locales.title_h1', 'categories_locales.content', 'categories_locales.meta_title', 'categories_locales.meta_description')
                        ->where('categories.id', '=', $category->id)
                        ->where('categories_locales.locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        $title = Db::table('categories_locales')
                    ->join('languages', 'categories_locales.locale', '=', 'languages.locale')
                    ->select('categories_locales.title')
                    ->where('categories_locales.category_id', '=', $category->id)
                    ->where('languages.default', '=', 1)
                    ->first();

        return view('categories.edit', [
            'category' => $category,
            'title' => $title->title,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
            'parents' => Db::table('categories')
                            ->join('categories_locales', 'categories.id', '=', 'categories_locales.category_id')
                            ->select('categories.id', 'categories_locales.title')
                            ->where('categories.public', true)
                            ->where('categories.id', '!=', $category->id)
                            ->where('categories_locales.locale', app()->getLocale())
                            ->orderBy('categories_locales.title', 'asc')
                            ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'parent_id' => 'required|numeric',
            'slug' => 'required|string|max:255',
        ]);
        if (isset($request->image)) {
            if (Storage::exists('categories/'. $category->image)) Storage::delete('categories/'. $category->image);
            $image = $request->file('image')->store('categories');
            $this->image = Str::remove('categories/', $image);
            $validated['image'] = $this->image;
        }
        $category->update($validated);
        DB::table('categories_locales')->where('category_id', '=', $category->id)->delete();
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
                DB::table('categories_locales')->insert([
                    'category_id' => $category->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }
        return redirect(route('category.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if (Storage::exists('categories/'. $category->image)) Storage::delete('categories/'. $category->image);
        DB::table('categories_locales')->where('category_id', '=', $category->id)->delete();
        DB::table('categories')->where('id', '=', $category->id)->delete();
        return redirect(route('category.index'))->with('message', __('messages.alert.removed'));
    }
}
