<?php

namespace App\Repositories;

use App\Models\Issue;

class IssueUserRepository
{
    public function attachUser(Issue $issue, int $userId)
    {
        $issue->users()->syncWithoutDetaching([$userId]);
        return $issue->users()->get();
    }

    public function detachUser(Issue $issue, int $userId)
    {
        $issue->users()->detach($userId);
        return $issue->users()->get();
    }
}
