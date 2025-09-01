<?php

namespace App\Repositories;

use App\Models\Issue;

class IssueRepository
{
    public function getAllWithFilters(array $filters, int $perPage = 10)
    {
        $query = Issue::with(['project', 'tags']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['tag_id'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->where('tags.id', $filters['tag_id']);
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function search(string $term = null)
    {
        return Issue::with(['tags', 'project'])
            ->when($term, function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            })
            ->get();
    }

    public function create(array $data): Issue
    {
        return Issue::create($data);
    }

    public function update(Issue $issue, array $data): Issue
    {
        $issue->update($data);
        return $issue;
    }

    public function delete(Issue $issue): bool
    {
        return $issue->delete();
    }

    public function attachTag(Issue $issue, int $tagId)
    {
        $issue->tags()->syncWithoutDetaching([$tagId]);
        return $issue->tags()->get();
    }

    public function detachTag(Issue $issue, int $tagId)
    {
        $issue->tags()->detach($tagId);
        return $issue->tags()->get();
    }
}
