<?php

namespace App\Services;

use App\Models\Issue;
use App\Repositories\IssueRepository;

class IssueService
{
    protected IssueRepository $repository;

    public function __construct(IssueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getIssues(array $filters = [])
    {
        return $this->repository->getAllWithFilters($filters);
    }

    public function searchIssues(string $term = null)
    {
        return $this->repository->search($term);
    }

    public function createIssue(array $data): Issue
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $issue = $this->repository->create($data);

        if (!empty($tags)) {
            $issue->tags()->sync($tags);
        }

        return $issue;
    }

    public function updateIssue(Issue $issue, array $data): Issue
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $issue = $this->repository->update($issue, $data);

        $issue->tags()->sync($tags);

        return $issue;    }

    public function deleteIssue(Issue $issue): bool
    {
        return $this->repository->delete($issue);
    }

    public function attachTag(Issue $issue, int $tagId)
    {
        return $this->repository->attachTag($issue, $tagId);
    }

    public function detachTag(Issue $issue, int $tagId)
    {
        return $this->repository->detachTag($issue, $tagId);
    }
}
