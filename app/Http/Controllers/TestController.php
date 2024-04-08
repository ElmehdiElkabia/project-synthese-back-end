<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestController extends Controller
{
    public function index(Course $course)
    {
        $tests = $course->tests;

        return response()->json($tests, Response::HTTP_OK);
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'answers' => 'required|array',
        ]);

        $questions = $validated['questions'];
        $answers = $validated['answers'];

        // Ensure that the number of questions and answers match
        if (count($questions) !== count($answers)) {
            return response()->json(['error' => 'The number of questions and answers must match'], Response::HTTP_BAD_REQUEST);
        }

        // Associate each question with its corresponding answer
        $questionAnswers = array_combine($questions, $answers);

        $test = $course->tests()->create([
            'questions' => json_encode($questions),
            'answers' => json_encode($questionAnswers),
        ]);

        return response()->json($test, Response::HTTP_CREATED);
    }

    public function show(Test $test)
    {
        return response()->json($test, Response::HTTP_OK);
    }

    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'questions' => 'sometimes|required|array',
            'answers' => 'sometimes|required|array',
        ]);

        if (isset($validated['questions'])) {
            $questions = $validated['questions'];
            $answers = $validated['answers'];

            // Ensure that the number of questions and answers match
            if (count($questions) !== count($answers)) {
                return response()->json(['error' => 'The number of questions and answers must match'], Response::HTTP_BAD_REQUEST);
            }

            // Associate each question with its corresponding answer
            $questionAnswers = array_combine($questions, $answers);

            $test->update([
                'questions' => json_encode($questions),
                'answers' => json_encode($questionAnswers),
            ]);
        }

        if (isset($validated['title'])) {
            $test->update([
                'title' => $validated['title'],
            ]);
        }

        return response()->json($test, Response::HTTP_OK);
    }

    public function destroy(Test $test)
    {
        $test->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}