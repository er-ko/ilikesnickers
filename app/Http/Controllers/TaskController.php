<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    private $type = false;
    private $todo = null;
    private $status = null;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection|View|JsonResponse
    {
        if ($request->ajax()) {

            $this->type = $request->get('type');
            $this->todo = $request->get('todo');
            $this->status = $request->get('status');

            // insert todo
            if ($this->type === 'create' && $this->todo !== null) {
                
                $data = [ 'title' => $this->todo, 'status' => false ]; 
                $validator = Validator::make($data, [
                    'title' => 'required|string|max:255',
                    'status' => 'boolean',
                ]);
                
                if (!$validator->fails()) {
                    DB::table('tasks')->insert([
                        'user_id' => auth()->id(),
                        'title' => $data['title'],
                        'status' => $data['status'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

            // update todo
            } elseif ($this->type === 'update' && $this->status !== null) {
                DB::table('tasks')->where('id', $this->todo)->update(values: ['status' => $this->status]);
           
            // delete todo
            } elseif ($this->type === 'delete' && $this->todo !== null) {
            
                DB::table('tasks')->where('id', '=', $this->todo)->delete();
            }

            $output = Db::table('tasks')
                        ->select('id', 'title', 'status')
                        ->where('user_id', '=', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->limit(100)
                        ->get();
            return response()->json($output);
        }
        return view('tasks.index', [
            'todos' => Task::orderBy('created_at', 'desc')->paginate(15),
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

    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
