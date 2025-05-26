<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskProjectRequest;
use App\Http\Requests\UpdateTaskProjectRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $priority = $request->query('prioriry');
        $due_date = $request->query('due_date');
        $project_id = $request->query('project_id');

        $tasks = Task::when($status, function($query) use($status){
            $query->where('status', $status);
        })
        ->when($priority, function($query) use($priority){
            $query->where('priority', $priority);
        })
        ->when($due_date, function($query) use($due_date){
            $query->where('due_date',$due_date);
        })
        ->when($project_id, function($query) use($project_id){
            $query->where('project_id',$project_id);
        })->get();

        return new JsonResponse([
            'data' => $tasks
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $task = Task::create($validated);
        return new JsonResponse([
            'data' => $task
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if(!$task){
            return new JsonResponse([
                'error' => 'No se encuentra la tarea'
            ]);
        }
        return new JsonResponse([
            'data' => $task
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskProjectRequest $request, int $id)
    {
        $validated = $request->validated();
        $task = Task::find($id);
        if(!$task){
            return new JsonResponse([
                'error' => 'No se encuentra la tarea'
            ]);
        }
        $task->update($validated);
        return new JsonResponse([
            'data' => 'Se actualizo la tarea'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::find($id);
        if(!$task){
            return new JsonResponse([
                'error' => 'No se encuentra la tarea'
            ]);
        }
        $task->delete();
        return new JsonResponse([
            'data' => 'Se elmino la tarea'
        ]);
    }
}
