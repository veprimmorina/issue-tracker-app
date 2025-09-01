<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Services\IssueService;
use App\Services\TagService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use App\Http\Requests\AttachTagRequest;
use App\Http\Requests\DetachTagRequest;

class IssueController extends Controller
{
    protected IssueService $issueService;
    protected TagService $tagService;
    protected ProjectService $projectService;

    public function __construct(IssueService $issueService, TagService $tagService, ProjectService $projectService)
    {
        $this->issueService   = $issueService;
        $this->tagService     = $tagService;
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $issues = $this->issueService->getIssues($request->only(['status', 'priority', 'tag_id']));
        $tags   = $this->tagService->getAll();

        return view('issues.index', compact('issues', 'tags'));
    }

    public function search(Request $request)
    {
        $issues = $this->issueService->searchIssues($request->input('q'));
        return view('issues.partials.list', compact('issues'));
    }

    public function create()
    {
        $projects = $this->projectService->getAll();
        $tags     = $this->tagService->getAll();

        return view('issues.create', compact('projects', 'tags'));
    }

    public function store(StoreIssueRequest $request)
    {
        $this->issueService->createIssue($request->validated());
        return redirect()->route('issues.index')->with('success', 'Issue created.');
    }

    public function show(Issue $issue)
    {
        $tags = $this->tagService->getAll();
        return view('issues.show', compact('issue', 'tags'));
    }

    public function edit(Issue $issue)
    {
        $projects = $this->projectService->getAll();
        $tags     = $this->tagService->getAll();

        return view('issues.edit', compact('issue', 'projects', 'tags'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $this->issueService->updateIssue($issue, $request->validated());
        return redirect()->route('issues.show', $issue)->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $this->issueService->deleteIssue($issue);
        return redirect()->route('issues.index')->with('success', 'Issue deleted.');
    }

    public function attachTag(AttachTagRequest $request, Issue $issue)
    {
        $tags = $this->issueService->attachTag($issue, $request->tag_id);

        return response()->json([
            'ok'   => true,
            'tags' => $tags
        ]);
    }

    public function detachTag(DetachTagRequest $request, Issue $issue)
    {
        $tags = $this->issueService->detachTag($issue, $request->tag_id);

        return response()->json([
            'ok'   => true,
            'tags' => $tags
        ]);
    }
}
