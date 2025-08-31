<?php

namespace App\Repositories;

use App\Models\Issue;

class IssueRepository
{
    public function list($perPage = 12, $filters = [])
    {
        $q = Issue::with(['project','tags']);

        if (!empty($filters['status'])) $q->where('status', $filters['status']);
        if (!empty($filters['priority'])) $q->where('priority', $filters['priority']);
        if (!empty($filters['tag'])) $q->whereHas('tags', fn($qb) => $qb->where('tags.id', $filters['tag']));
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $q->where(fn($qb) => $qb->where('title','like',"%{$s}%")->orWhere('description','like',"%{$s}%"));
        }

        return $q->latest()->paginate($perPage)->withQueryString();
    }

    public function find(int $id): ?Issue
    {
        return Issue::with(['project','tags'])->find($id);
    }

    public function create(array $data): Issue
    {
        return Issue::create($data);
    }

    public function update(Issue $issue, array $data): bool
    {
        return $issue->update($data);
    }

    public function delete(Issue $issue): bool
    {
        return $issue->delete();
    }
}
