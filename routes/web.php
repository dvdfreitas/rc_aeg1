<?php

use App\Models\SchoolClass;
use App\Models\SchoolClassTeacher;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teachers', function () {
    $teachers = Teacher::all();
    return view('teachers.index', compact('teachers'));
});

Route::get('/students', function () {
    $students = Student::all();
    return view('students.index', compact('students'));
});

Route::get('/school_classes', function () {
    $school_classes = SchoolClass::all();
    return view('school_classes.index', compact('school_classes'));
});


Route::get('/school_class_teacher', function () {
    $school_class_teachers = SchoolClassTeacher::all();
    return view('school_class_teacher.index', compact('school_class_teachers'));
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
