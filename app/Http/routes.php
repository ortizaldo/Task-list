<?php
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');
    Route::get('/tasks', 'TaskController@index');
    Route::get('/tasks/buscarTasks', 'TaskController@buscarTasks');
    Route::get('/tasks/{user}', 'TaskController@getTasks');
    Route::get('/tasks/tasksTodoAll/{user}', 'TaskController@getTasksCurrent');
    Route::get('/tasks/tasksTodo/{user}/{task}', 'TaskController@getTasksToDo');
    Route::post('/task', 'TaskController@store');
    Route::post('/tasks/buscarTasks', 'TaskController@buscarTareas');
    Route::put('/task/{task}', 'TaskController@update');
    Route::put('/task/pausarTiempo/{task}', 'TaskController@updateTime');
    Route::delete('/task/{task}', 'TaskController@destroy');
    //Route::update('/task/{task}/{duracion}', 'TaskController@updateDuration');
    Route::get('refresh-csrf', function(){
        return csrf_token();
    });
    Route::auth();
});