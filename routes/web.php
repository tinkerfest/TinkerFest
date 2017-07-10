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
Route::get('/', function() {
  return view('tinkerfest');
});
Route::get('/delhi', function() {
  return view('delhi_register');
});

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('root/initial', 'PostController@validateInitial');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/blog', 'RootController@index')->name('indexroot');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/log/view/{id}', 'RootController@showPost');

Route::get('/download', 'DocumentController@download')->name('download');
Route::get('/contributors', 'ContributorController@contributors')->name('contributors');

Route::group(['middleware' => 'auth'], function () {
  Route::get('/log/new', 'PostController@index')->name('createLog');
  Route::post('/document/upload', 'DocumentController@uploadDocuments')->name('uploadDocuments');
  Route::post('/document/delete/{document_id}', 'DocumentController@deleteDocuments')->name('deleteDocuments');
  Route::post('/video/upload', 'VideoController@uploadVideo')->name('uploadVideo');
  Route::post('/video/delete/{video_id}', 'VideoController@deleteVideo')->name('deleteVideo');
  Route::get('/log/edit/{id}', 'PostController@update')->name('editLog');
});



//-------------Api----------------------
Route::group(['prefix' => 'api','namespace'=>'api'], function () {
    Route::post('search','SearchController@index');
    Route::post('log/publish','PostController@create');
    Route::post('log/update','PostController@update');
    Route::post('log/delete','PostController@delete');
    Route::post('category','CategoryController@index');
    Route::post('category/add','CategoryController@create');
    Route::post('logs/{gusermail}','LogsController@index');

});

// ---------------------------------------------------

Route::get('/{gusermail}', 'RootController@userpage')->name('gusermail');
Route::get('/{gusermail}/profile', 'ProfileController@index')->name('getProfile');
Route::post('/{gusermail}/profile', 'ProfileController@store')->name('postProfile');

// Route::post('/{gusermail}/documents', 'DocumentController@uploadDocuments')->name('uploadDocuments');
Route::get('/{gusermail}/documents', 'DocumentController@documents')->name('documents');
Route::get('/{gusermail}/documents/view/{googledrive_id}', 'DocumentController@documentView')->name('documentView');
Route::get('/{gusermail}/documents/download/{document_id}', 'DocumentController@documentDownload')->name('documentDownload');

Route::get('/{gusermail}/video', 'VideoController@video')->name('video');

Route::get('/{gusermail}/{pid}/{slug}', 'PostController@individual')->name('individial');