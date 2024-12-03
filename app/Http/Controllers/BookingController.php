<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

class BookingController extends Controller
{
    protected $image;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (auth()->id()) {

            $categories = Db::table('bookings')
                            ->select('bookings.id', 'bookings.created_at')
                            ->orderBy('bookings.created_at', 'desc')->paginate(15);

        } else {

            $slots = DB::table('bookings_slots')
                        ->join('bookings_slots_locales', 'bookings_slots.id', '=', 'bookings_slots_locales.slot_id')
                        ->select('bookings_slots.priority', 'bookings_slots.open_days', 'bookings_slots.image', 'bookings_slots.opening_hours', 'bookings_slots_locales.title')
                        ->where('bookings_slots.active', true)
                        ->where('bookings_slots_locales.locale', app()->getLocale())
                        ->orderBy('bookings_slots.priority')
                        ->get();

            $activities = DB::table('bookings_activities')
                        ->join('bookings_activities_locales', 'bookings_activities.id', '=', 'bookings_activities_locales.activity_id')
                        ->select('bookings_activities.id', 'bookings_activities.processing_time', 'bookings_activities.interval_after', 'bookings_activities_locales.title')
                        ->where('bookings_activities.active', true)
                        ->where('bookings_activities_locales.locale', app()->getLocale())
                        ->orderBy('bookings_activities.priority')
                        ->get();

        }
        return view('bookings.index', [
            'activities' => $activities,
            'slots' => $slots,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
    
    public function indexSlot(): View
    {
        $bookings = Db::table('bookings_slots')
                        ->join('bookings_slots_locales', 'bookings_slots.id', '=', 'bookings_slots_locales.slot_id')
                        ->select('bookings_slots.id', 'bookings_slots.active', 'bookings_slots.priority', 'bookings_slots_locales.title')
                        ->where('bookings_slots_locales.locale', app()->getLocale())
                        ->orderBy('bookings_slots.created_at', 'desc')
                        ->paginate(15);
        return view('bookings.slot.index', [
            'bookings' => $bookings,
        ]);
    }

    public function createSlot(): View
    {
        $activities = DB::table('bookings_activities')
                        ->join('bookings_activities_locales', 'bookings_activities.id', '=', 'bookings_activities_locales.activity_id')
                        ->select('bookings_activities.id', 'bookings_activities_locales.title')
                        ->where('bookings_activities.active', true)
                        ->where('bookings_activities_locales.locale', app()->getLocale())
                        ->orderBy('bookings_activities_locales.title', 'asc')
                        ->get();

        return view('bookings.slot.create', [
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
            'activities' => $activities,
        ]);
    }

    public function storeSlot(Request $request): RedirectResponse
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
        return redirect(route('booking.slot.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    public function editSlot(Request $request, $bookingId): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('bookings_slots_locales')
                        ->select('title')
                        ->where('slot_id', '=', $bookingId)
                        ->where('locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        $booking = Db::table(table: 'bookings_slots')
                        ->select('id', 'active', 'priority', 'open_days', 'image', 'opening_hours')
                        ->where('id', $bookingId)
                        ->first();

        return view('bookings.slot.edit', [
            'booking' => $booking,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
            'activities' => [],
        ]);
    }

    public function updateSlot(Request $request): RedirectResponse
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
            $imageDb = DB::table('bookings_slots')->where('id', $request->id)->value('image');
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
            DB::table('bookings_slots')
                    ->where('id', '=', $request->id)
                    ->update([
                        'active' => $data['active'],
                        'priority' => $data['priority'],
                        'open_days' => $data['open_days'],
                        'image' => $data['image'],
                        'opening_hours' => $data['opening_hours'],
            ]);
        }

        DB::table('bookings_slots_locales')->where('slot_id', '=', $request->id)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if (isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = '';
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('bookings_slots_locales')->insert([
                    'slot_id' => $request->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
        }
        return redirect(route('booking.slot.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    public function destroySlot($bookingId): RedirectResponse
    {
        $image = DB::table('bookings_slots')->where('id', $bookingId)->value('image');
        if (Storage::exists('bookings/'. $image)) Storage::delete('bookings/'. $image);
        DB::table('bookings_slots_locales')->where('slot_id', $bookingId)->delete();
        DB::table('bookings_slots')->where('id', $bookingId)->delete();
        return redirect(route('booking.slot.index'))->with('message', __('messages.alert.removed'));
    }













    public function indexActivity(): View
    {
        $bookings = Db::table('bookings_activities')
                        ->join('bookings_activities_locales', 'bookings_activities.id', '=', 'bookings_activities_locales.activity_id')
                        ->select('bookings_activities.id', 'bookings_activities.active', 'bookings_activities.priority', 'bookings_activities_locales.title')
                        ->where('bookings_activities_locales.locale', app()->getLocale())
                        ->orderBy('bookings_activities.created_at', 'desc')
                        ->paginate(15);
        return view('bookings.activity.index', [
            'bookings' => $bookings,
        ]);
    }

    public function createActivity(): View
    {
        return view('bookings.activity.create', [
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    public function storeActivity(Request $request): RedirectResponse
    {
        $data = [];
        $data['active'] = $request->active;
        $data['priority'] = $request->priority;
        $data['processing_time'] = $request->processing_time;
        $data['interval_after'] = $request->interval_after;

        $validator = Validator::make($data, [
            'active' => 'required|boolean',
            'priority' => 'required|numeric',
            'processing_time' => 'required|numeric',
            'interval_after' => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            $id = DB::table('bookings_activities')->insertGetId([
                'active' => $data['active'],
                'priority' => $data['priority'],
                'processing_time' => $data['processing_time'],
                'interval_after' => $data['interval_after'],
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
                DB::table('bookings_activities_locales')->insert([
                    'activity_id' => $id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
        }
        return redirect(route('booking.activity.index'))->with('message', __('messages.alert.successfully_created'));
    }

    public function editActivity(Request $request, $bookingId): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('bookings_activities_locales')
                        ->select('title')
                        ->where('activity_id', '=', $bookingId)
                        ->where('locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        $booking = Db::table('bookings_activities')
                        ->select('id', 'active', 'processing_time', 'interval_after', 'priority')
                        ->where('id', $bookingId)
                        ->first();

        return view('bookings.activity.edit', [
            'booking' => $booking,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    public function updateActivity(Request $request): RedirectResponse
    {
        $data = [];
        $data['active'] = $request->active;
        $data['priority'] = $request->priority;
        $data['processing_time'] = $request->processing_time;
        $data['interval_after'] = $request->interval_after;

        $validator = Validator::make($data, [
            'active' => 'required|boolean',
            'priority' => 'required|numeric',
            'processing_time' => 'required|numeric',
            'interval_after' => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            DB::table('bookings_activities')
                    ->where('id', '=', $request->id)
                    ->update([
                        'active' => $data['active'],
                        'priority' => $data['priority'],
                        'processing_time' => $data['processing_time'],
                        'interval_after' => $data['interval_after'],
            ]);
        }

        DB::table('bookings_activities_locales')->where('activity_id', '=', $request->id)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if (isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = '';
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('bookings_activities_locales')->insert([
                    'activity_id' => $request->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
        }
        return redirect(route('booking.activity.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    public function destroyActivity($bookingId): RedirectResponse
    {
        DB::table('bookings_activities_locales')->where('activity_id', '=', $bookingId)->delete();
        DB::table('bookings_activities')->where('id', '=', $bookingId)->delete();
        return redirect(route('booking.activity.index'))->with('message', __('messages.alert.removed'));
    }
}
