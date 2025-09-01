<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public function getAll()
    {
        return Tag::all();
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update(Tag $tag, array $data)
    {
        return $tag->update($data);
    }

    public function delete(Tag $tag)
    {
        return $tag->delete();
    }
}
