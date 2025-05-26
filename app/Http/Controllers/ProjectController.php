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
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Obtener un listado de projectos",
     *     description="Devuelve un listado de projectos con sus tareas relacionadas",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="Projectos encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="proyecto nuevo"),
     *                 @OA\Property(property="description", type="string", example="proyecto nuevo"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Testimonio no encontrado"
     *     )
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
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Registrar un projecto",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "status"},
     *             @OA\Property(property="name", type="string", example="Projecto nuevo"),
     *             @OA\Property(property="description", type="string", example="Descripcion del proyecto"),
     *             @OA\Property(property="status", type="string", example="active"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Projecto registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonio registrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"name_customer": {"El nombre del cliente es obligatorio"}}
     *             )
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Obtener un projecto por id",
     *     description="Devuelve un prjecto de projectos con sus tareas relacionadas",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="Projecto encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="proyecto nuevo"),
     *                 @OA\Property(property="description", type="string", example="proyecto nuevo"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Testimonio no encontrado"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Actualizar un projecto",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "status"},
     *             @OA\Property(property="name", type="string", example="Projecto nuevo"),
     *             @OA\Property(property="description", type="string", example="Descripcion del proyecto"),
     *             @OA\Property(property="status", type="string", example="active"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Projecto registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonio registrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projecto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projecto no encontrado")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Eliminar un projecto",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         required=true,
     *         description="ID deL projecto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projecto eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projecto eliminado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projecto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projecto no encontrado")
     *         )
     *     )
     * )
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
