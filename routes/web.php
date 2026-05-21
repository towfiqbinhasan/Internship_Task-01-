<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello, This is Md. Towfiq Bin Hasan';
});

// Student CRUD Routes Group
Route::prefix('student')->controller(StudentController::class)->group(function () {
    Route::get('/', 'index')->name('student.index');
    Route::get('/create', 'create')->name('student.create'); 
    Route::post('/', 'store')->name('student.store');
    Route::get('/{id}/edit', 'edit')->name('student.edit'); 
    Route::put('/{id}', 'update')->name('student.update');
    Route::delete('/{id}', 'destroy')->name('student.destroy');
    Route::put('/{id}/quick-update', 'quickUpdate')->name('student.quickUpdate'); 
});
//  Route::get('about-us', function () {
//$name = "Tester";
//$email='tester@example.com';
  //   return view('about')->with('name', $name)->with('email', $email);
//});

//Route::view('contactus', 'contactus');
//Route::controller(StudentController::class)->group(function () {
  //  Route::get('students', 'index');
    //Route::get('aboutus', 'aboutus');
//});




//Route::get('students', [StudentController::class, 'index']);
//Route::get('aboutus', [StudentController::class, 'aboutus']);



//Route::get('teachers', function () {
  //  return Teacher::all();
//});


/*Route::get('teacher', [TeachersController::class, 'index']);
Route::get('add-teacher', [TeachersController::class, 'add']);
Route::get('show-teacher/{id}',[TeachersController::class, 'show']);
Route::get('update-teacher/{id}',[TeachersController::class, 'update']);
Route::get('delete-teacher/{id}',[TeachersController::class, 'delete']);
*/
//Route::get('add-data', [StudentController::class, 'adddata']);
//Route::get('get-data', [StudentController::class, 'getData']);

//Route::get('where-condition', [StudentController::class, 'whereCondition']);
//Route::get('whereBetween', [StudentController::class, 'whereBetween']);