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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('/');
Route::get('/home', 'HomeController@index')->name('home');

/*User management roles------ENTRUST*/
Route::resource('role', 'RoleController');
Route::resource('permission', 'PermissionController');
Route::post('/permission/add', 'PermissionController@add')->name('permission.add');
Route::post('/permission/addmenu', 'PermissionController@displayNameStore')->name('permission.addmenu');
Route::resource('user', 'UserController');
Route::resource('assignrole', 'AssignRoleController');

/*New Menu*/
Route::get('menu', 'MenuController@index')->name('menu-index');
Route::post('menu/store', 'MenuController@store')->name('menu-store');
Route::post('menu/buildMenu', 'MenuController@buildMenu')->name('menu-build-menu');
Route::post('menu/delete', 'MenuController@destroy')->name('menu-delete');
Route::get('menu/search', 'MenuController@search')->name('menu-search');
Route::post('menu/displayNameStore', 'MenuController@displayNameStore')->name('display-name-store');


//meroadhikar
Route::get('/contactcategory', 'Backend\ContactCategoryController@index')->name('backend.contactcategory.index');
Route::get('/contactcategory/create', 'Backend\ContactCategoryController@create')->name('backend.contactcategory.create');
Route::post('/contactcategory/store', 'Backend\ContactCategoryController@store')->name('backend.contactcategory.store');
Route::get('/contactcategory/show/{id}', 'Backend\ContactCategoryController@show')->name('backend.contactcategory.show');
Route::get('/contactcategory/edit/{id}', 'Backend\ContactCategoryController@edit')->name('backend.contactcategory.edit');
Route::patch('/contactcategory/update/{id}', 'Backend\ContactCategoryController@update')->name('backend.contactcategory.update');
Route::get('/contactcategory/destroy/{id}', 'Backend\ContactCategoryController@destroy')->name('backend.contactcategory.destroy');

Route::get('/contact', 'Backend\ContactController@index')->name('backend.contact.index');
Route::get('/contact/create', 'Backend\ContactController@create')->name('backend.contact.create');
Route::post('/contact/store', 'Backend\ContactController@store')->name('backend.contact.store');
Route::get('/contact/show/{id}', 'Backend\ContactController@show')->name('backend.contact.show');
Route::get('/contact/destroy/{id}', 'Backend\ContactController@destroy')->name('backend.contact.destroy');
Route::get('/contact/edit/{id}', 'Backend\ContactController@edit')->name('backend.contact.edit');
Route::patch('/contact/update/{id}', 'Backend\ContactController@update')->name('backend.contact.update');

Route::get('check-district-names','DistrictController@create')->name('district.create');
Route::post('check-district-names/result','DistrictController@result')->name('district.result');
Route::post('check-mun-names/result','DistrictController@munResult')->name('mun.result');
Route::any('check-match-names/result','DistrictController@matchResult')->name('match.result');
Route::any('munNPToEN','DistrictController@munNPToEN')->name('munNPToEN');






Route::get('form-index', function () {
    return view('form.index');
});

Route::get('form-create', function () {
    return view('form.create');
});

Route::get('form-show', function () {
    return view('form.show');
});
Route::get('chalani-index', function () {
    return view('chalani.index');
});

Route::get('chalani-create', function () {
    return view('chalani.create');
});

Route::get('chalani-show', function () {
    return view('chalani.show');
});