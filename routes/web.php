<?php

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/crear-video', array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));

Route::post('/guardar-video', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));


Route::get('/miniatura/{filename}', array(
    'as' => 'imageVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@getImage'
));

Route::get('/video/{video_id}', array(
    'as' => 'detailVideo',
    'uses' => 'VideoController@getVideoDetail'
));

Route::get('/videoFile/{filename}', array(
    'as' => 'fileVideo',
    'uses' => 'VideoController@getVideo'
));

Route::get('/delete-video/{video_id}', array(
    'as' => 'videoDelete',
    'middleware' => 'auth',
    'uses' => 'VideoController@delete'
));

Route::get('/editar-video/{video_id}', array(
    'as' => 'editVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@edit'
));

Route::post('/actualizar-video/{video_id}', array(
    'as' => 'updateVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@update'
));


Route::post('/comment', [
    'as' => 'comment',
    'middleware' => 'auth',
    'uses' => 'CommentsController@store'
]);

Route::get('/delete-comment/{comment_id}', array(
    'as' => 'commentDelete',
    'middleware' => 'auth',
    'uses' => 'CommentsController@delete'
));


Route::get('/buscar/{search?}', array(
    'as' => 'videoSearch',
    'uses' => 'VideoController@search'
));

Route::get('/clear-cache', function () {
    $code = Artisan::call('cache:clear');
    return redirect()->route('home');
});
