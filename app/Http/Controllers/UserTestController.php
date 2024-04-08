<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\User;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserTestController extends Controller
{
    public function index()
    {
        $userTests = UserTest::with('user', 'test')->get();

        return response()->json($userTests, Response::HTTP_OK);
    }

    public function store(Request $request, User $user, Test $test)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:100',
        ]);

        $userTest = $user->userTests()->create([
            'test_id' => $test->id,
            'score' => $validated['score'],
        ]);

        return response()->json($userTest, Response::HTTP_CREATED);
    }

    public function show(UserTest $userTest)
    {
        return response()->json($userTest, Response::HTTP_OK);
    }

    public function update(Request $request, UserTest $userTest)
    {
        $validated = $request->validate([
            'score' => 'sometimes|required|integer|min:0|max:100',
        ]);

        if (isset($validated['score'])) {
            $userTest->update([
                'score' => $validated['score'],
            ]);
        }

        return response()->json($userTest, Response::HTTP_OK);
    }

    public function destroy(UserTest $userTest)
    {
        $userTest->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}