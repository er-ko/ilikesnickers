<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tasksTotal     = Task::with('user')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->count();
        $tasksOpened    = Task::with('user')->where('user_id', auth()->id())->where('status', 0)->orderBy('created_at', 'desc')->count();
        $tasksClosed    = $tasksTotal - $tasksOpened;
        $progress       = $tasksTotal > 0 ? $tasksClosed / $tasksTotal * 100 : 0;
        $color          = $tasksTotal == 0 ? 'bg-gray-800 dark:bg-white' : ($progress < 25 ? 'bg-pink-600' : ($progress < 50 ? 'bg-orange-500' : ($progress < 75 ? 'bg-blue-500' : 'bg-teal-500')));
        $languages      = Language::orderBy('locale', 'asc')->get();

        $translates     = [];
        foreach ($languages as $language) {
            $contents = File::get(base_path('lang/'. $language->locale .'.json'));
            $json = json_decode(json: $contents, associative: true);
            $emptyVal = 0;
            foreach($json as $val) {
                if (!$val) $emptyVal++;
            }
            $translates[] = [
                'locale' => $language->locale,
                'name' => $language->name,
                'flag' => $language->flag,
                'all' => count($json),
                'empty' => $emptyVal,
            ];
        }

        return view('dashboard.index', [
            'username'      => Auth::user()->name,
            'tasks_total'   => $tasksTotal,
            'tasks_opened'  => $tasksOpened,
            'tasks_closed'  => $tasksClosed,
            'progress'      => $progress,
            'color'         => $color,
            'translates'    => $translates,
        ]);
    }
}
