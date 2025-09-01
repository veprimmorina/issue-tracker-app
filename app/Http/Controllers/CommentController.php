<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Services\CommentService;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Issue $issue)
    {
        $comments = $this->commentService->getByIssue($issue);
        return view('comments.list', compact('comments'));
    }

    public function store(StoreCommentRequest $request, Issue $issue)
    {
        $comment = $this->commentService->createForIssue($issue, $request->validated());
        return response()->json(['success' => true, 'comment' => $comment]);
    }
}
