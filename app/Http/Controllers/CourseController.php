<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return response()->json($courses, Response::HTTP_OK);
    }

    public function show(Course $course)
    {
        return response()->json($course, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'domain' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $course = Course::create($validated);

        return response()->json($course, Response::HTTP_CREATED);
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'domain' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $course->update($validated);

        return response()->json($course, Response::HTTP_OK);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}