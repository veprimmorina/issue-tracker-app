<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Services\IssueService;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    protected IssueService $service;

    public function __construct(IssueService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $query = Issue::with(['project', 'tags']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        $issues = $query->latest()->paginate(10);
        $tags = Tag::all();

        return view('issues.index', compact('issues', 'tags'));
    }


    public function create()
    {
        $projects = Project::all();
        $tags = Tag::all();
        return view('issues.create', compact('projects', 'tags'));
    }


    public function store(StoreIssueRequest $request)
    {
        $this->service->createIssue($request->validated());
        return redirect()->route('issues.index')->with('success','Issue created.');
    }

    public function show(Issue $issue)
    {
        $tags = Tag::all();
        return view('issues.show', compact('issue', 'tags'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::all();
        $tags = Tag::all();
        return view('issues.edit', compact('issue', 'projects', 'tags'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $this->service->updateIssue($issue, $request->validated());
        return redirect()->route('issues.show', $issue)->with('success','Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $this->service->deleteIssue($issue);
        return redirect()->route('issues.index')->with('success','Issue deleted.');
    }

    public function attachTag(Request $request, Issue $issue)
    {
        $request->validate(['tag_id' => 'required|exists:tags,id']);
        $issue->tags()->syncWithoutDetaching([$request->tag_id]);
        return response()->json(['ok'=>true,'tags'=>$issue->tags()->get()]);
    }

    public function detachTag(Request $request, Issue $issue)
    {
        $request->validate(['tag_id' => 'required|exists:tags,id']);
        $issue->tags()->detach($request->tag_id);
        return response()->json(['ok'=>true,'tags'=>$issue->tags()->get()]);
    }
}
