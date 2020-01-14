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

Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'user'], function() {
        Route::get('/profile', 'UserController@profile')->name('user.profile');
        Route::get('/changePassword', 'UserController@changePassword')->name('user.changePassword');
        Route::post('/storeNewPassword', 'UserController@storeNewPassword')->name('user.storeNewPassword');
        Route::post('/updateProfile', 'UserController@updateProfile')->name('user.updateProfile');
    });

    Route::group(['prefix' => 'projects'], function() {
        Route::get('/', 'ProjectsController@index')->name('projects.index');
        Route::get('/my', 'ProjectsController@myProjects')->name('projects.myProjects');
        Route::get('/create', 'ProjectsController@create')->name('projects.create');
        Route::post('/store', 'ProjectsController@store')->name('projects.store');
        Route::get('/edit/{id}', 'ProjectsController@edit')->name('projects.edit');
        Route::post('/update/{id}', 'ProjectsController@update')->name('projects.update');
        Route::get('/delete/{id}', 'ProjectsController@delete')->name('projects.delete');
        Route::get('/show/{id}', 'ProjectsController@show')->name('projects.show');
        Route::get('/active/{id}', 'ProjectsController@active')->name('projects.active');
        Route::get('/file/{path}', 'ProjectsController@deleteFile')->name('projects.deleteFile');
        Route::get('/pdf/{id}', 'ProjectsController@pdf')->name('projects.pdf');
    });

    Route::group(['prefix' => 'tags'], function() {
        Route::get('/', 'TagsController@index')->name('tags.index');
        Route::get('/myTags', 'TagsController@myTags')->name('tags.myTags');
        Route::get('/create', 'TagsController@create')->name('tags.create');
        Route::post('/store', 'TagsController@store')->name('tags.store');
        Route::get('/edit/{id}', 'TagsController@edit')->name('tags.edit');
        Route::post('/update/{id}', 'TagsController@update')->name('tags.update');
        Route::get('/delete/{id}', 'TagsController@delete')->name('tags.delete');
    });

    Route::group(['prefix' => 'courses'], function() {
        Route::get('/', 'CoursesController@index')->name('courses.index');
        Route::get('/create', 'CoursesController@create')->name('courses.create');
        Route::post('/store', 'CoursesController@store')->name('courses.store');
        Route::get('/edit/{id}', 'CoursesController@edit')->name('courses.edit');
        Route::post('/update/{id}', 'CoursesController@update')->name('courses.update');
        Route::get('/delete/{id}', 'CoursesController@delete')->name('courses.delete');
    });

    Route::get('/like/{id}', 'ProjectsController@like')->name('projects.like');
    
    Route::get('/students', 'UserController@students')->name('students.index');
    Route::get('/users/pdf/{action}', 'UserController@pdf')->name('students.pdf');
    Route::get('/students/delete/{id}', 'UserController@deleteStudent')->name('students.deleteStudents');
    Route::get('/students/profile/{id}', 'UserController@profileStudent')->name('students.profileStudents');
    Route::get('/students/approve', 'UserController@approveStudents')->name('students.approve');
    Route::get('/students/{id}/{what}', 'UserController@storeApproveStudents')->name('students.storeApprove');
    Route::get('/teachers/approve', 'UserController@approveTeacher')->name('teachers.approve');
    Route::get('/teachers/{id}/{what}', 'UserController@storeApproveTeachers')->name('teachers.storeApprove');
});

Route::group(["prefix" => "api/v1/"], function () {
	
	Route::group(["prefix" => "users"], function () {
	
		Route::get('/{name}/{password}','Api\UsersController@check');
		// Route::group(["prefix" => "create"], function () {
		Route::get('/{email}/{password}/{name}','Api\RegisterController@create');
	
	});

	Route::group(["prefix" => "projects"], function () {
		
		Route::get('/all', 'Api\ProjectsController@all');

		Route::get('/{id}', 'Api\ProjectsController@projects_user');

		Route::get('/user/{id}', 'Api\ProjectsController@projectsByUser');				
		Route::get('/search/{str}', 'Api\ProjectsController@searchProjects');				

	});

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
