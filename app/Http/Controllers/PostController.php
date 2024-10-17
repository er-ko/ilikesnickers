<?php

namespace App\Http\Controllers;

use App\Models\Post;
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

class PostController extends Controller
{
    private $title = '';
    private $image = false;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (auth()->id()) {

            $posts = Db::table('posts')
                        ->join('posts_locales', 'posts.id', '=', 'posts_locales.post_id')
                        ->join('languages', 'posts_locales.locale', '=', 'languages.locale')
                        ->select('posts.id', 'posts.public', 'posts.image', 'posts.slug', 'posts.created_at', 'posts_locales.locale',
                                'posts_locales.title', 'posts_locales.title_h1', 'posts_locales.content', 'posts_locales.meta_title', 'posts_locales.meta_description')
                        ->where('languages.default', '=', 1)
                        ->orderBy('posts.created_at', 'desc')->paginate(15);

        } else {

            $posts = Db::table('posts')
                        ->join('posts_locales', 'posts.id', '=', 'posts_locales.post_id')
                        ->select('posts.id', 'posts.public', 'posts.image', 'posts.slug', 'posts.created_at', 'posts_locales.locale',
                                'posts_locales.title', 'posts_locales.title_h1', 'posts_locales.content', 'posts_locales.meta_title', 'posts_locales.meta_description')
                        ->where('posts_locales.locale', '=', app()->getLocale())
                        ->orderBy('posts.created_at', 'desc')->paginate(15);
        }
        return view('posts.index', [ 'posts' => $posts ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('posts.create', [
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
        if (isset($request->image)) {

            $image = $request->file('image')->store('posts');
            $this->image = Str::remove('posts/', $image);
        }
        $validated['image'] = $this->image;
        $posted = $request->user()->posts()->create($validated);

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
                    'post_id' => $posted->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }
        return redirect(route('post.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View|RedirectResponse
    {
        if (auth()->id()) {
            $output = Db::table('posts')
                        ->join('posts_locales', 'posts.id', '=', 'posts_locales.post_id')
                        ->select('posts.id', 'posts.image', 'posts.created_at', 'posts_locales.title_h1', 'posts_locales.content', 'posts_locales.meta_title', 'posts_locales.meta_description')
                        ->where('posts.slug', '=', $post->slug)
                        ->where('posts_locales.locale', '=', app()->getLocale())
                        ->first();

            if (!$output) return redirect('404');
            return view('posts.show', ['post' => $output]);
        } else {
            if ($post->public) {
                $output = Db::table('posts')
                        ->join('posts_locales', 'posts.id', '=', 'posts_locales.post_id')
                        ->select('posts.id', 'posts.image', 'posts.created_at', 'posts_locales.title_h1', 'posts_locales.content', 'posts_locales.meta_title', 'posts_locales.meta_description')
                        ->where('posts.slug', '=', $post->slug)
                        ->where('posts_locales.locale', '=', app()->getLocale())
                        ->first();
                
                if (!$output) return redirect('404');
                return view('posts.show', ['post' => $output]);
            }
            else return redirect('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Post $post): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('posts')
                        ->join('posts_locales', 'posts.id', '=', 'posts_locales.post_id')
                        ->select('posts_locales.title', 'posts_locales.title_h1', 'posts_locales.content', 'posts_locales.meta_title', 'posts_locales.meta_description')
                        ->where('posts.id', '=', $post->id)
                        ->where('posts_locales.locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        return view('posts.edit', [
            'post' => $post,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'public' => 'required|numeric|max:1',
            'slug' => 'required|string|max:255',
        ]);
        if (isset($request->image)) {
            if (Storage::exists('posts/'. $post->image)) Storage::delete('posts/'. $post->image);
            $image = $request->file('image')->store('posts');
            $this->image = Str::remove('posts/', $image);
            $validated['image'] = $this->image;
        }
        $post->update($validated);
        DB::table('posts_locales')->where('post_id', '=', $post->id)->delete();
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
                    'post_id' => $post->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'title_h1' => $data['title_h1'],
                    'content' => $data['content'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_desc'],
                ]);
            }
        }
        return redirect(route('post.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if (Storage::exists('posts/'. $post->image)) Storage::delete('posts/'. $post->image);
        DB::table('posts_locales')->where('post_id', '=', $post->id)->delete();
        DB::table('posts')->where('id', '=', $post->id)->delete();
        return redirect(route('post.index'))->with('message', __('messages.alert.removed'));
    }
}
