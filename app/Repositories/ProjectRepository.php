<?php

namespace App\Repositories;

use App\Models\Project;
use \Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    public function getAllPaginated($perPage = 10)
    {
        return Project::latest()->paginate($perPage);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function getAll(): Collection
    {
        return Project::all();
    }

    public function update(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }

    public function findWithRelations($id, array $relations = [])
    {
        return Project::with($relations)->findOrFail($id);
    }
}
