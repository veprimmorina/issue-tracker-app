<?php

namespace App\Services;

use App\Models\Issue;
use App\Repositories\IssueUserRepository;

class IssueUserService
{
    protected IssueUserRepository $repository;

    public function __construct(IssueUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function attachUser(Issue $issue, int $userId)
    {
        return $this->repository->attachUser($issue, $userId);
    }

    public function detachUser(Issue $issue, int $userId)
    {
        return $this->repository->detachUser($issue, $userId);
    }
}
