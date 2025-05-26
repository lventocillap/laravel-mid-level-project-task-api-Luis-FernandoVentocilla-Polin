<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/projects",
     *     summary="Listar los projectos",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $name = $request->query('name');
        $projects = Project::with('task')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', $name);
            })->get();
        return new JsonResponse([
            'data' => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $project = Project::create($validated);
        return new JsonResponse([
            'data' => $project
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $project = Project::with(['task'])->find($id);
        if (!$project) {
            return new JsonResponse([
                'error' => 'Projecto no encontrado'
            ], 404);
        }
        return new JsonResponse([
            'data' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectProjectRequest $request, string $id)
    {
        $validated = $request->validated($request);
        $project = Project::find($id);
        if (!$project) {
            return new JsonResponse([
                'error' => 'Projecto no encontrado'
            ], 404);
        }
        $project->update($validated);
        return new JsonResponse([
            'data' => 'Se actualizo el projecto'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $project = Project::with(['task'])->find($id);
        if (!$project) {
            return new JsonResponse([
                'error' => 'Projecto no encontrado'
            ], 404);
        }
        $project->delete();
        return new JsonResponse([
            'data' => 'Se elimino el projecto'
        ]);
    }
}
