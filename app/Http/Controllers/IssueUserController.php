<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;

class IssueUserController extends Controller
{
    public function attach(Request $request, Issue $issue)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $issue->users()->syncWithoutDetaching([$request->user_id]);

        return response()->json(['success' => true, 'users' => $issue->users]);
    }

    public function detach(Issue $issue, User $user)
    {
        $issue->users()->detach($user->id);

        return response()->json(['success' => true, 'users' => $issue->users]);
    }
}
