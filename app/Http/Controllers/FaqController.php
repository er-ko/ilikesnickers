<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\System;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    private $question = '';
    private $answer = '';
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $faqs = DB::table('faqs')
                    ->join('faqs_locales', 'faqs.id', '=', 'faqs_locales.faq_id')
                    ->select('faqs.id', 'faqs.priority', 'faqs_locales.question', 'faqs_locales.answer')
                    ->where('faqs_locales.locale', app()->getLocale())
                    ->orderBy('faqs.priority', 'asc')
                    ->paginate(15);
        
        return view('faq.index', [
            'faqs' => $faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('faq.create', [
            'default' => System::where('param', 'default_language')->value('value'),
            'languages' => Language::orderBy('name', 'asc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'priority' => 'required|numeric',
        ]);
        $created = $request->user()->faqs()->create($validated);

        $count = 0;
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if ($count == 0) {
                $this->question = $request->question[$key];
                $this->answer   = $request->answer[$key];
            }
            if (isset($request->question[$key])) $data['question'] = $request->question[$key]; else $data['question'] = $this->question;
            if (isset($request->answer[$key])) $data['answer'] = $request->answer[$key]; else $data['answer'] = $this->answer;

            $validator = Validator::make($data, [
                'question' => 'required|string|max:255',
                'answer' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('faqs_locales')->insert([
                    'faq_id' => $created->id,
                    'locale' => $locale,
                    'question' => $data['question'],
                    'answer' => $data['answer'],
                ]);
            }
            $count++;
        }
        return redirect(route('faq.index'))->with('message', __('successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Faq $faq): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('faqs')
                        ->join('faqs_locales', 'faqs.id', '=', 'faqs_locales.faq_id')
                        ->select('faqs_locales.question', 'faqs_locales.answer')
                        ->where('faqs.id', '=', $faq->id)
                        ->where('faqs_locales.locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        return view('faq.edit', [
            'faq' => $faq,
            'default' => System::where('param', 'default_language')->value('value'),
            'languages' => Language::orderBy('name', 'asc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'priority' => 'required|numeric',
        ]);
        $faq->update($validated);

        $count = 0;
        DB::table('faqs_locales')->where('faq_id', '=', $faq->id)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if ($count == 0) {
                $this->question = $request->question[$key];
                $this->answer   = $request->answer[$key];
            }
            if (isset($request->question[$key])) $data['question'] = $request->question[$key]; else $data['question'] = $this->question;
            if (isset($request->answer[$key])) $data['answer'] = $request->answer[$key]; else $data['answer'] = $this->answer;

            $validator = Validator::make($data, [
                'question' => 'required|string|max:255',
                'answer' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('faqs_locales')->insert([
                    'faq_id' => $faq->id,
                    'locale' => $locale,
                    'question' => $data['question'],
                    'answer' => $data['answer'],
                ]);
            }
            $count++;
        }
        return redirect(route('faq.index'))->with('message', __('successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        DB::table('faqs_locales')->where('faq_id', '=', $faq->id)->delete();
        DB::table('faqs')->where('id', '=', $faq->id)->delete();
        return redirect(route('faq.index'))->with('message', __('removed'));
    }
}
