<?php

namespace App\Services;

use App\Models\Issue;
use App\Repositories\IssueRepository;

class IssueService
{
    protected IssueRepository $repo;

    public function __construct(IssueRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listIssues(array $filters = [], int $perPage = 12)
    {
        return $this->repo->list($perPage, $filters);
    }

    public function getIssue(int $id): ?Issue
    {
        return $this->repo->find($id);
    }

    public function createIssue(array $data): Issue
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $issue = $this->repo->create($data);

        if ($tags) {
            $issue->tags()->sync($tags);
        }

        return $issue;
    }

    public function updateIssue(Issue $issue, array $data): Issue
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $this->repo->update($issue, $data);

        $issue->tags()->sync($tags);

        return $issue;
    }

    public function deleteIssue(Issue $issue): bool
    {
        return $this->repo->delete($issue);
    }
}
