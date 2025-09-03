<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectService
{
    protected ProjectRepository $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listProjects(int $perPage = 10)
    {
        return $this->repository->getAllPaginated($perPage);
    }

    public function createProject(array $data): Project
    {
        $data['user_id'] = auth()->id();
        return $this->repository->create($data);
    }

    public function updateProject(Project $project, array $data): bool
    {
        return $this->repository->update($project, $data);
    }

    public function deleteProject(Project $project): bool
    {
        return $this->repository->delete($project);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getProjectWithIssues($id)
    {
        return $this->repository->findWithRelations($id, ['issues.tags']);
    }
}
