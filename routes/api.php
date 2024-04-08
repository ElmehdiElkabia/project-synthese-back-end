<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post("login", [AuthController::class, "login"]);
Route::post("register", [AuthController::class, "register"]);


Route::middleware('auth:api')->group(function () {
    // User Profile Route
    Route::get("profile", [AuthController::class, "profile"]);

    // Token Refresh Route
    Route::get("refresh", [AuthController::class, "refreshToken"]);

    // Logout Route
    Route::get("logout", [AuthController::class, "logout"]);

    // Courses and Lessons Routes
    Route::resource('courses', CourseController::class)->only(['index', 'show']);
    Route::resource('courses.lessons', LessonController::class)->only(['index', 'show']);

    // User Enrollment Routes
    Route::post('courses/{course}/enroll', [EnrollmentController::class, 'enroll']);

    // CRUD Routes for User Tests
    Route::resource('user-tests', UserTestController::class)->only(['index', 'show', 'store']);

    // Certificate Routes
    Route::resource('certificates', CertificateController::class)->only(['index', 'show', 'store']);

    // Admin Routes
    Route::middleware('admin')->group(function () {
        // CRUD Routes for Courses and Lessons
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::resource('courses.lessons', LessonController::class)->except(['index', 'show']);

        // CRUD Routes for Tests
        Route::resource('courses.tests', TestController::class);
    });
});
