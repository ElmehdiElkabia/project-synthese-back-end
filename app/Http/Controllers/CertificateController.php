<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('user', 'course')->get();

        return response()->json($certificates, Response::HTTP_OK);
    }

    public function store(Request $request, User $user, Course $course)
    {
        $validated = $request->validate([
            'obtained_at' => 'required|date',
        ]);

        $certificate = $user->certificates()->create([
            'course_id' => $course->id,
            'obtained_at' => $validated['obtained_at'],
        ]);

        return response()->json($certificate, Response::HTTP_CREATED);
    }

    public function show(Certificate $certificate)
    {
        return response()->json($certificate, Response::HTTP_OK);
    }

    public function update(Request $request, Certificate $certificate)
    {
        // Certificates are typically read-only, so we won't implement an update method
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}