<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('user', 'course')->get();

        return response()->json($enrollments, Response::HTTP_OK);
    }

    public function store(Request $request, User $user, Course $course)
    {
        $user->enrollments()->create([
            'course_id' => $course->id,
        ]);

        return response()->json(null, Response::HTTP_CREATED);
    }

    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment, Response::HTTP_OK);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        // Enrollments are typically read-only, so we won't implement an update method
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}