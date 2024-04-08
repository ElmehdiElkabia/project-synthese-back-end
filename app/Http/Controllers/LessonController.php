<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons;

        return response()->json($lessons, Response::HTTP_OK);
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
        ]);

        $lesson = $course->lessons()->create($validated);

        return response()->json($lesson, Response::HTTP_CREATED);
    }

    public function show(Lesson $lesson)
    {
        return response()->json($lesson, Response::HTTP_OK);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'content' => 'sometimes|nullable|string',
        ]);

        $lesson->update($validated);

        return response()->json($lesson, Response::HTTP_OK);
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}