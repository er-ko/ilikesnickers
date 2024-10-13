<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        return view('dashboard.index', [
            'tasks_total'   => $tasksTotal,
            'tasks_opened'  => $tasksOpened,
            'tasks_closed'  => $tasksClosed,
            'progress'      => $progress,
            'color'         => $color,
        ]);
    }
}
