<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\TagService;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = $this->tagService->getAll();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $this->tagService->create($request->validated());
        return redirect()->route('tags.index')->with('success', 'Tag created successfully!');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->tagService->update($tag, $request->validated());
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        $this->tagService->delete($tag);
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully!');
    }
}
