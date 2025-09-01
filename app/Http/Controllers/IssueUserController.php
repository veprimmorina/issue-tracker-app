<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachUserRequest;
use App\Models\Issue;
use App\Models\User;
use App\Services\IssueUserService;

class IssueUserController extends Controller
{
    protected IssueUserService $service;

    public function __construct(IssueUserService $service)
    {
        $this->service = $service;
    }

    public function attach(AttachUserRequest $request, Issue $issue)
    {
        $users = $this->service->attachUser($issue, $request->user_id);

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }

    public function detach(Issue $issue, User $user)
    {
        $users = $this->service->detachUser($issue, $user->id);

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }
}
