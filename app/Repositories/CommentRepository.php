<?php

namespace App\Repositories;

use App\Models\Issue;
use App\Models\Comment;

class CommentRepository
{
    public function getByIssue(Issue $issue, int $perPage = 5)
    {
        return $issue->comments()->latest()->paginate($perPage);
    }

    public function createForIssue(Issue $issue, array $data): Comment
    {
        return $issue->comments()->create($data);
    }
}
