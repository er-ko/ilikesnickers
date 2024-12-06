<?php

namespace App\Http\Controllers;

use App\Models\Welcome;
use App\Models\System;
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

class WelcomeController extends Controller
{
    private $image;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('welcome.index', [
            'slider_status' => DB::table('systems')->where('param', '=', 'welcome_slider_status')->value('value'),
            'slider_priority' => DB::table('systems')->where('param', '=', 'welcome_slider_priority')->value('value'),
            'content_status' => DB::table('systems')->where('param', '=', 'welcome_content_status')->value('value'),
            'content_priority' => DB::table('systems')->where('param', '=', 'welcome_content_priority')->value('value'),
            'data' => DB::table('welcomes_locales')->where('locale', '=', app()->getLocale())->first(),
            'sliders' => DB::table('welcomes_sliders')->where('locale', '=', app()->getLocale())->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Welcome $welcome): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            if ($request->get('type') == 'data') {
                $data = Db::table('welcomes_locales')
                        ->select('title', 'content', 'meta_title', 'meta_description')
                        ->where('locale', '=', $locale)
                        ->get();
            } elseif ($request->get('type') == 'slider') {
                $data = Db::table('welcomes_sliders')
                        ->select('file', 'title', 'priority')
                        ->where('locale', '=', $locale)
                        ->orderBy('priority', 'asc')
                        ->get();
            }
            return response()->json($data);
        }
        return view('welcome.edit', [
            'slider_status' => DB::table('systems')->where('param', '=', 'welcome_slider_status')->value('value'),
            'slider_priority' => DB::table('systems')->where('param', '=', 'welcome_slider_priority')->value('value'),
            'content_status' => DB::table('systems')->where('param', '=', 'welcome_content_status')->value('value'),
            'content_priority' => DB::table('systems')->where('param', '=', 'welcome_content_priority')->value('value'),
            'default' => System::where('param', 'default_language')->value('value'),
            'languages' => Language::orderBy('name', 'asc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        if (isset($request->slider_status)) $sliderStatus = 1; else $sliderStatus = 0;
        DB::table('systems')->where('param', '=', 'welcome_slider_status')->update(['value' => $sliderStatus]);
        if (isset($request->slider_priority)) $sliderPriority = $request->slider_priority; else $sliderPriority = 0;
        DB::table('systems')->where('param', '=', 'welcome_slider_priority')->update(['value' => $sliderPriority]);        
        if (isset($request->content_status)) $contentStatus = 1; else $contentStatus = 0;
        DB::table('systems')->where('param', '=', 'welcome_content_status')->update(['value' => $contentStatus]);
        if (isset($request->content_priority)) $contentPriority = $request->content_priority; else $contentPriority = 0;
        DB::table('systems')->where('param', '=', 'welcome_content_priority')->update(['value' => $contentPriority]);

        DB::table('welcomes_locales')->delete();
        foreach ($request->locale as $key => $locale) {
            if ($request->title[$key] || $request->content[$key] || $request->meta_title[$key] || $request->meta_desc[$key]) {
                $data = [
                    'title' => $request->title[$key],
                    'content' => $request->content[$key],
                    'meta_title' => $request->meta_title[$key],
                    'meta_description' => $request->meta_desc[$key],
                ];
                $validator = Validator::make($data, [
                    'title' => 'string|max:255|nullable',
                    'content' => 'string|nullable',
                    'meta_title' => 'string|max:255|nullable',
                    'meta_description' => 'string|max:255|nullable',
                ]);
                if (!$validator->fails()) {
                    DB::table('welcomes_locales')->insert([
                        'locale' => $locale,
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'meta_title' => $data['meta_title'],
                        'meta_description' => $data['meta_description'],
                    ]);
                }
            }
        }
        foreach ($request->locale as $key => $locale) {
            $data           = [];
            $dataUpl        = [];
            $imgDbArr       = [];
            $imgFileUpl     = [];

            $imageFileUpl       = 'image_file_upl_'. $locale;
            $imageTitleUpl      = 'image_title_upl_'. $locale;
            $imagePriorityUpl   = 'image_priority_upl_'. $locale;

            $imgDb = DB::table('welcomes_sliders')->where('locale', '=', $locale)->pluck('file');
            if (isset($imgDb[0])) {
                foreach($imgDb as $file) {
                    array_push($imgDbArr, $file);
                }
            }

            DB::table('welcomes_sliders')->where('locale', '=', $locale)->delete();
            if (isset($request->$imageFileUpl)) {
                foreach ($request->$imageFileUpl as $key2 => $imageUpl) {
                    if ($imageUpl) {
                        array_push($imgFileUpl, $imageUpl);

                        $dataUpl = [
                            'file' => $imageUpl,
                            'title' => $request->$imageTitleUpl[$key2],
                            'priority' => $request->$imagePriorityUpl[$key2],
                        ];
                        $validator = Validator::make($dataUpl, [
                            'file' => 'required|string|max:255',
                            'title' => 'string|max:255|nullable',
                            'priority' => 'numeric',
                        ]);
                        if (!$validator->fails()) {
                            DB::table('welcomes_sliders')->insert([
                                'locale' => $locale,
                                'file' => $dataUpl['file'],
                                'title' => $dataUpl['title'],
                                'priority' => $dataUpl['priority'],
                            ]);
                        }
                    }
                }
            }

            $imgDelArr = array_diff($imgDbArr, $imgFileUpl);
            if ($imgDelArr) {
                foreach ($imgDelArr as $imgDel) {
                    if (Storage::exists('welcomes/'. $imgDel)) Storage::delete('welcomes/'. $imgDel);
                    DB::table('welcomes_sliders')->where('file', '=', $imgDel)->delete();
                }
            }

            $imageFile      = 'image_file_'. $locale;
            $imageTitle     = 'image_title_'. $locale;
            $imagePriority  = 'image_priority_'. $locale;
            if (isset($request->$imageFile[$key])) {
                foreach ($request->$imageFile as $key2 => $imageItem) {
                    $image = $request->file($imageFile)[$key2]->store('welcomes');
                    $this->image = Str::remove('welcomes/', $image);

                    $data = [
                        'file' => $this->image,
                        'title' => $request->$imageTitle[$key2],
                        'priority' => $request->$imagePriority[$key2],
                    ];
                    $validator = Validator::make($data, [
                        'file' => 'required|string|max:255',
                        'title' => 'string|max:255|nullable',
                        'priority' => 'numeric',
                    ]);
                    if (!$validator->fails()) {
                        DB::table('welcomes_sliders')->insert([
                            'locale' => $locale,
                            'file' => $data['file'],
                            'title' => $data['title'],
                            'priority' => $data['priority'],
                        ]);
                    }
                }
            }
        }
        return redirect(route('welcome.edit'))->with('message', __('messages.alert.successfully_updated'));
    }
}
