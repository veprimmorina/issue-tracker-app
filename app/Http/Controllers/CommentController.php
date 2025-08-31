<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Issue $issue)
    {
        $comments = $issue->comments()->latest()->paginate(5);
        return view('comments.list', compact('comments'));
    }

    public function store(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $comment = $issue->comments()->create($validated);

        return response()->json(['success' => true, 'comment' => $comment]);
    }
}
