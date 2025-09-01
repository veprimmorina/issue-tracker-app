<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\TagRepository;

class TagService
{
    protected TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAll()
    {
        return $this->tagRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->tagRepository->create($data);
    }

    public function update(Tag $tag, array $data)
    {
        return $this->tagRepository->update($tag, $data);
    }

    public function delete(Tag $tag)
    {
        return $this->tagRepository->delete($tag);
    }
}
