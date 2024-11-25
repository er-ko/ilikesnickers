<?php

namespace App\Http\Controllers;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'company_name' => DB::table('systems')->where('param', 'contact_company_name')->value('value'),
            'address' => DB::table('systems')->where('param', 'contact_address')->value('value'),
            'opening_hours' => DB::table('systems')->where('param', 'contact_opening_hours')->value('value'),
            'phone' => DB::table('systems')->where('param', 'contact_phone')->value('value'),
            'email' => DB::table('systems')->where('param', 'contact_email')->value('value'),
            'web' => DB::table('systems')->where('param', 'contact_web')->value('value'),
            'map' => DB::table('systems')->where('param', 'contact_map')->value('value'),
            'whatsapp' => DB::table('systems')->where('param', 'contact_whatsapp')->value('value'),
            'facebook' => DB::table('systems')->where('param', 'contact_facebook')->value('value'),
            'instagram' => DB::table('systems')->where('param', 'contact_instagram')->value('value'),
            'tiktok' => DB::table('systems')->where('param', 'contact_tiktok')->value('value'),
            'google' => DB::table('systems')->where('param', 'contact_google')->value('value'),
        ];
        return view('contact.index', [
            'contact' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, System $system): View
    {
        return view('contact.edit', [
            'contact' => System::first(),
        ]);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, System $system): RedirectResponse
    {
        isset($request->opening_hours_monday[0]) ? $monday[0] = str_replace(' ', '', $request->opening_hours_monday[0]) : $monday[0] = '';
        isset($request->opening_hours_monday[1]) ? $monday[1] = str_replace(' ', '', $request->opening_hours_monday[1]) : $monday[1] = '';
        isset($request->opening_hours_tuesday[0]) ? $tuesday[0] = str_replace(' ', '', $request->opening_hours_tuesday[0]) : $tuesday[0] = '';
        isset($request->opening_hours_tuesday[1]) ? $tuesday[1] = str_replace(' ', '', $request->opening_hours_tuesday[1]) : $tuesday[1] = '';
        isset($request->opening_hours_wednesday[0]) ? $wednesday[0] = str_replace(' ', '', $request->opening_hours_wednesday[0]) : $wednesday[0] = '';
        isset($request->opening_hours_wednesday[1]) ? $wednesday[1] = str_replace(' ', '', $request->opening_hours_wednesday[1]) : $wednesday[1] = '';
        isset($request->opening_hours_thursday[0]) ? $thursday[0] = str_replace(' ', '', $request->opening_hours_thursday[0]) : $thursday[0] = '';
        isset($request->opening_hours_thursday[1]) ? $thursday[1] = str_replace(' ', '', $request->opening_hours_thursday[1]) : $thursday[1] = '';
        isset($request->opening_hours_friday[0]) ? $friday[0] = str_replace(' ', '', $request->opening_hours_friday[0]) : $friday[0] = '';
        isset($request->opening_hours_friday[1]) ? $friday[1] = str_replace(' ', '', $request->opening_hours_friday[1]) : $friday[1] = '';
        isset($request->opening_hours_saturday[0]) ? $saturday[0] = str_replace(' ', '', $request->opening_hours_saturday[0]) : $saturdayp[0] = '';
        isset($request->opening_hours_saturday[1]) ? $saturday[1] = str_replace(' ', '', $request->opening_hours_saturday[1]) : $saturday[1] = '';
        isset($request->opening_hours_sunday[0]) ? $sunday[0] = str_replace(' ', '', $request->opening_hours_sunday[0]) : $sunday[0] = '';
        isset($request->opening_hours_sunday[1]) ? $sunday[1] = str_replace(' ', '', $request->opening_hours_sunday[1]) : $sunday[1] = '';

        $openingHours = [
            'monday' => $monday[0] .'|'. $monday[1],
            'tuesday' => $tuesday[0] .'|'. $tuesday[1],
            'wednesday' => $wednesday[0] .'|'. $wednesday[1],
            'thursday' => $thursday[0] .'|'. $thursday[1],
            'friday' => $friday[0] .'|'. $friday[1],
            'saturday' => $saturday[0] .'|'. $saturday[1],
            'sunday' => $sunday[0] .'|'. $sunday[1],
        ];
        $data = [
            'contact_company_name'  => $request->contact_company_name,
            'contact_address'       => $request->contact_address,
            'contact_opening_hours' => json_encode($openingHours),
            'contact_phone'         => $request->contact_phone,
            'contact_email'         => $request->contact_email,
            'contact_web'           => $request->contact_web,
            'contact_map'           => $request->contact_map,
            'contact_whatsapp'      => $request->contact_whatsapp,
            'contact_facebook'      => $request->contact_facebook,
            'contact_instagram'     => $request->contact_instagram,
            'contact_tiktok'        => $request->contact_tiktok,
            'contact_google'        => $request->contact_google,
        ];
        $validator = Validator::make($data, [
            'contact_company_name'  => 'nullable|string|max:255',
            'contact_address'       => 'nullable|string|max:255',
            'contact_phone'         => 'nullable|string|max:16',
            'contact_email'         => 'nullable|string|max:255',
            'contact_web'           => 'nullable|string|max:255',
            'contact_map'           => 'nullable|string|max:255',
            'contact_whatsapp'      => 'nullable|string|max:16',
            'contact_facebook'      => 'nullable|string|max:255',
            'contact_instagram'     => 'nullable|string|max:255',
            'contact_tiktok'        => 'nullable|string|max:255',
            'contact_google'        => 'nullable|string|max:255',
        ]);
        if (!$validator->fails()) {
            DB::table('systems')->update(values: [
                'contact_company_name'  => $data['contact_company_name'],
                'contact_address'       => $data['contact_address'],
                'contact_opening_hours' => $data['contact_opening_hours'],
                'contact_phone'         => $data['contact_phone'],
                'contact_email'         => $data['contact_email'],
                'contact_web'           => $data['contact_web'],
                'contact_map'           => $data['contact_map'],
                'contact_whatsapp'      => $data['contact_whatsapp'],
                'contact_facebook'      => $data['contact_facebook'],
                'contact_instagram'     => $data['contact_instagram'],
                'contact_tiktok'        => $data['contact_tiktok'],
                'contact_google'        => $data['contact_google'],
            ]);
        }
        return redirect(route('contact.edit'))->with('message', __('messages.alert.successfully_updated'));
    }

}
