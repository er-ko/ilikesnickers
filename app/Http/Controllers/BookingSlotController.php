<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookingSlotController extends Controller
{
	private $image;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
		$bookings = Db::table('bookings_slots')
                        ->join('bookings_slots_locales', 'bookings_slots.id', '=', 'bookings_slots_locales.slot_id')
                        ->select('bookings_slots.id', 'bookings_slots.active', 'bookings_slots.priority', 'bookings_slots_locales.title')
                        ->where('bookings_slots_locales.locale', app()->getLocale())
                        ->orderBy('bookings_slots.created_at', 'desc')
                        ->paginate(15);
        return view('bookings-slots.index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $activities = DB::table('bookings_activities')
                        ->join('bookings_activities_locales', 'bookings_activities.id', '=', 'bookings_activities_locales.activity_id')
                        ->select('bookings_activities.id', 'bookings_activities_locales.title')
                        ->where('bookings_activities.active', true)
                        ->where('bookings_activities_locales.locale', app()->getLocale())
                        ->orderBy('bookings_activities_locales.title', 'asc')
                        ->get();

        return view('bookings-slots.create', [
            'default' => System::where('param', 'language_default')->value('value'),
            'languages' => Language::orderBy('name', 'asc')->orderBy('priority', 'asc')->get(),
            'activities' => $activities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
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
        isset($request->opening_hours_saturday[0]) ? $saturday[0] = str_replace(' ', '', $request->opening_hours_saturday[0]) : $saturday[0] = '';
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

        $data = [];
        $data['active'] = $request->active;
        $data['priority'] = $request->priority;
        $data['open_days'] = $request->open_days;
        $data['opening_hours'] = json_encode($openingHours);

        if (isset($request->image)) {

            $image = $request->file('image')->store('bookings');
            $this->image = Str::remove('bookings/', $image);
        }
        $data['image'] = $this->image;
        
        $validator = Validator::make($data, [
            'active' => 'required|boolean',
            'priority' => 'required|numeric',
            'open_days' => 'required|numeric',
            'opening_hours' => 'string|max:255|nullable',
        ]);
        if (!$validator->fails()) {
            $id = DB::table('bookings_slots')->insertGetId([
                'active' => $data['active'],
                'priority' => $data['priority'],
                'open_days' => $data['open_days'],
                'image' => $data['image'],
                'opening_hours' => $data['opening_hours'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($request->locale as $key => $locale) {
            $data = [];
            if (isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = '';
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('bookings_slots_locales')->insert([
                    'slot_id' => $id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
        }
        return redirect(route('booking.slot.index'))->with('message', __('successfully_updated'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $slotId): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('bookings_slots_locales')
                        ->select('title')
                        ->where('slot_id', '=', $slotId)
                        ->where('locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        $booking = Db::table(table: 'bookings_slots')
                        ->select('id', 'active', 'priority', 'open_days', 'image', 'opening_hours')
                        ->where('id', $slotId)
                        ->first();

        return view('bookings-slots.edit', [
            'booking' => $booking,
            'default' => System::where('param', 'language_default')->value('value'),
            'languages' => Language::orderBy('name', 'asc')->orderBy('priority', 'asc')->get(),
            'activities' => [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slotId): RedirectResponse
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
        isset($request->opening_hours_saturday[0]) ? $saturday[0] = str_replace(' ', '', $request->opening_hours_saturday[0]) : $saturday[0] = '';
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

        $data = [];
        $data['active'] = $request->active;
        $data['priority'] = $request->priority;
        $data['open_days'] = $request->open_days;
        $data['opening_hours'] = json_encode($openingHours);

        if (isset($request->image)) {
            $imageDb = DB::table('bookings_slots')->where('id', $slotId)->value('image');
            if (Storage::exists('bookings/'. $imageDb)) Storage::delete('bookings/'. $imageDb);
            $image = $request->file('image')->store('bookings');
            $this->image = Str::remove('bookings/', $image);
        }
        $data['image'] = $this->image;

        $validator = Validator::make($data, [
            'active' => 'required|boolean',
            'priority' => 'required|numeric',
            'open_days' => 'required|numeric',
            'image' => 'string|max:255|nullable',
            'opening_hours' => 'string|max:255|nullable',
        ]);
        if (!$validator->fails()) {
            if (isset($request->image)) {
                DB::table('bookings_slots')
                        ->where('id', '=', $slotId)
                        ->update([
                            'active' => $data['active'],
                            'priority' => $data['priority'],
                            'open_days' => $data['open_days'],
                            'image' => $data['image'],
                            'opening_hours' => $data['opening_hours'],
                ]);
            } else {
                DB::table('bookings_slots')
                        ->where('id', '=', $slotId)
                        ->update([
                            'active' => $data['active'],
                            'priority' => $data['priority'],
                            'open_days' => $data['open_days'],
                            'opening_hours' => $data['opening_hours'],
                ]);
            }
        }

        DB::table('bookings_slots_locales')->where('slot_id', '=', $slotId)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if (isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = '';
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('bookings_slots_locales')->insert([
                    'slot_id' => $slotId,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
        }
        return redirect(route('booking.slot.index'))->with('message', __('successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slotId): RedirectResponse
    {
        $image = DB::table('bookings_slots')->where('id', $slotId)->value('image');
        if (Storage::exists('bookings/'. $image)) Storage::delete('bookings/'. $image);
        DB::table('bookings_slots_locales')->where('slot_id', $slotId)->delete();
        DB::table('bookings_slots')->where('id', $slotId)->delete();
        return redirect(route('booking.slot.index'))->with('message', __('removed'));
	}
}
