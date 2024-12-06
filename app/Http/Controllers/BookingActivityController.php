<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
		$bookings = Db::table('bookings_activities')
                        ->join('bookings_activities_locales', 'bookings_activities.id', '=', 'bookings_activities_locales.activity_id')
                        ->select('bookings_activities.id', 'bookings_activities.active', 'bookings_activities.priority', 'bookings_activities_locales.title')
                        ->where('bookings_activities_locales.locale', app()->getLocale())
                        ->orderBy('bookings_activities.created_at', 'desc')
                        ->paginate(15);
        return view('bookings-activities.index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('bookings-activities.create', [
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
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
    public function edit(Request $request, $activityId): Collection|View|JsonResponse
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            $data = Db::table('bookings_activities_locales')
                        ->select('title')
                        ->where('activity_id', '=', $activityId)
                        ->where('locale', '=', $locale)
                        ->get();
            return response()->json($data);
        }
        $booking = Db::table('bookings_activities')
                        ->select('id', 'active', 'processing_time', 'interval_after', 'priority')
                        ->where('id', $activityId)
                        ->first();

        return view('bookings-activities.edit', [
            'booking' => $booking,
            'languages' => Language::orderBy('default', 'desc')->orderBy('priority', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $activityId): RedirectResponse
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
                    ->where('id', '=', $activityId)
                    ->update([
                        'active' => $data['active'],
                        'priority' => $data['priority'],
                        'processing_time' => $data['processing_time'],
                        'interval_after' => $data['interval_after'],
            ]);
        }

        DB::table('bookings_activities_locales')->where('activity_id', '=', $activityId)->delete();
        foreach ($request->locale as $key => $locale) {
            $data = [];
            if (isset($request->title[$key])) $data['title'] = $request->title[$key]; else $data['title'] = '';
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
            ]);
            if (!$validator->fails()) {
                DB::table('bookings_activities_locales')->insert([
                    'activity_id' => $activityId,
                    'locale' => $locale,
                    'title' => $data['title'],
                ]);
            }
        }
        return redirect(route('booking.activity.index'))->with('message', __('messages.alert.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($activityId): RedirectResponse
    {
        DB::table('bookings_activities_locales')->where('activity_id', '=', $activityId)->delete();
        DB::table('bookings_activities')->where('id', '=', $activityId)->delete();
        return redirect(route('booking.activity.index'))->with('message', __('messages.alert.removed'));
	}
}
