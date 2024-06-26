<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Response;


class ProjectController extends Controller
{

    private $sortField, $sortDirection;

    public function __construct()
    {
        $this->sortField = request("sort_field", 'created_at');
        $this->sortDirection = request("sort_direction", 'desc');
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     *
     * @return Response
     */
    public function index(Project $project): Response
    {
        $query = Project::query();

        $sortField = $this->sortField;
        $sortDirection = $this->sortDirection;

        if (request("name")) {
            $query->where("name", "like", "%" . request("name") . "%");
        }
        if (request("status")) {
            $query->where("status", request("status"));
        }

        $projects = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return inertia("Project/Index", [
            "projects" => ProjectResource::collection($projects),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Project $project
     *
     * @return Response
     */
    public function show(Project $project)
    {
        $query = $project->tasks();

        $sortField = $this->sortField;
        $sortDirection = $this->sortDirection;

        if (request("name")) {
            $query->where("name", "like", "%" . request("name") . "%");
        }
        if (request("status")) {
            $query->where("status", request("status"));
        }

        $tasks = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return inertia('Project/Show', [
            'project' => new ProjectResource($project),
            "tasks" => TaskResource::collection($tasks),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     */
    public function edit(Project $project): Response
    {

        return inertia('Project/Edit', [
            'project' => new ProjectResource($project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateProjectRequest $request
     * @param Project $project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $data = $request->validated();
        $image = $data['image'] ?? null;
        $data['updated_by'] = Auth::id();
        if ($image) {
            if ($project->image_path) {
                Storage::disk('public')->deleteDirectory(dirname($project->image_path));
            }
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }
        $project->update($data);

        return to_route('projects.index')
            ->with('success', "Project \"$project->name\" was updated");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        /** @var $image UploadedFile */
        $image = $data['image'] ?? null;
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        if ($image) {
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }
        Project::create($data);

        return to_route('projects.index')
            ->with('success', 'Project was created');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia("Project/Create");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $name = $project->name;
        $project->delete();
        if ($project->image_path) {
            Storage::disk('public')->deleteDirectory(dirname($project->image_path));
        }
        return to_route('projects.index')
            ->with('success', "Project \"$name\" was deleted");
    }
}
