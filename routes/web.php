<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StudentmanageController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\ShowRecordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RecordteacherController;
use App\Http\Controllers\PdfController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TeacherMiddleware;
use App\Http\Middleware\StudentMiddleware;


// หน้า login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('first');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('/create-courses-for-users', [UsersController::class, 'createCoursesForUsersWithoutCourses'])->name('create.courses.for.users');


// หน้า dashboard
Route::middleware([AdminMiddleware::class])->group(function () {
    
    Route::get('/index',[UsersController::class,'index'])->name('adminindex');


    //นักเรียน
    Route::get('/add/student',[UsersController::class,'create'])->name('addstudent');
    Route::get('/edit/student/{id}',[UsersController::class,'edit'])->name('editstudent');
    Route::post('/add/student/store', [UsersController::class,'store'])->name('student.store');
    Route::delete('delete/student/{id}', [UsersController::class,'destroy'])->name('student.destroy');
    Route::get('/student/mange',[StudentmanageController::class,'index'])->name('studentmange');
    Route::get('/student/show/{id}',[StudentmanageController::class,'show'])->name('studentshow');
    Route::put('/update/student/{id}', [UsersController::class,'update'])->name('student.update');


    //ครู
    Route::get('/teacher/mange',[TeacherController::class,'index'])->name('teachermanage');
    Route::get('/teacher/show/{id}',[TeacherController::class,'show'])->name('teachershow');
    Route::get('/add/teacher',[TeacherController::class,'create'])->name('addteacher');
    Route::post('/add/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('/edit/teacher/{id}',[TeacherController::class,'edit'])->name('editteacher');
    Route::put('/update/teacher/{id}', [TeacherController::class, 'update'])->name('teacher.update');
    Route::delete('delete/teacher/{id}', [TeacherController::class,'destroy'])->name('teacher.destroy');


    //การสอน
    Route::get('/add/record',[RecordController::class,'index'])->name('addrecord');
    Route::post('/record/store',[RecordController::class,'store'])->name('record.store');
    Route::get('/show/record',[ShowRecordController::class,'index'])->name('showrecord');
    Route::delete('delete/record/{id}', [ShowRecordController::class,'destroy'])->name('record.destroy');

    //export
    Route::get('/pdf/student/{id}', [PdfController::class, 'generateStudentPdf'])->name('pdf.student');

    //ต่อคอร์ส
    Route::get('/add/course',[CourseController::class,'index'])->name('addcourse');
    Route::post('/course/store',[CourseController::class,'store'])->name('course.store');
    Route::get('course/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('course/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('delete/course/{id}', [CourseController::class,'destroy'])->name('course.destroy');

});


Route::middleware([TeacherMiddleware::class])->group(function () {

    Route::get('teacher/main', function () {
        return view('teachermain');
    })->name('teacher.dashboard');
    
    Route::get('/add/recordteacher',[RecordteacherController::class,'index'])->name('recordteacher');
    Route::post('/recordteacher/store',[RecordteacherController::class,'store'])->name('recordteacher.store');

});



Route::middleware([StudentMiddleware::class])->group(function () {
    
    Route::get('student/main', function () {
        return view('studentmain');
    })->name('student.dashboard');
 
});


Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/phpinfo.php', function () {
    return view('phpinfo');
})->name('phpinfo');