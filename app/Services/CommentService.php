<?php

namespace App\Services;

use App\Models\Issue;
use App\Repositories\CommentRepository;

class CommentService
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getByIssue(Issue $issue, int $perPage = 5)
    {
        return $this->commentRepository->getByIssue($issue, $perPage);
    }

    public function createForIssue(Issue $issue, array $data)
    {
        return $this->commentRepository->createForIssue($issue, $data);
    }
}
