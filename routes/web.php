<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { 
    return view('welcome');
});

Auth::routes();

Route::get('/student', [App\Http\Controllers\StudentController::class, 'index'])->name('home');
Route::post('student/register', ['as' => 'student.register', 'uses' => 'App\Http\Controllers\StudentController@store']);
Route::post('student/delete', ['as' => 'student.delete', 'uses' => 'App\Http\Controllers\StudentController@delete']);
Route::post('student/update', ['as' => 'student.update', 'uses' => 'App\Http\Controllers\StudentController@update']);
// Route::get('access', ['as' => 'patients.showLoginForm', 'uses' => 'LoginPatientController@showPacienteLoginForm']);
