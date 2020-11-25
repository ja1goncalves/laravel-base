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
  if(Auth::guest()){
    return Redirect::to('/login');
  }else{
    return Redirect::to('/home');
  }
});

Auth::routes();

// locale Route
Route::get('lang/{locale}','LanguageController@swap')->name('lang.index');

// Route Miscellaneous Pages
Route::get('/page-coming-soon', 'MiscellaneousController@coming_soon');
Route::get('/error-404', 'MiscellaneousController@error_404');
Route::get('/error-500', 'MiscellaneousController@error_500');
Route::get('/page-not-authorized', 'MiscellaneousController@not_authorized');
Route::get('/page-maintenance', 'MiscellaneousController@maintenance');

Route::group(['middleware' => ['auth', 'acl']], function() {
  // Route url
  Route::get('/', 'DashboardController@dashboardAnalytics')->name('dashboard.index');

  // Route Dashboards
  Route::get('/dashboard-analytics', 'DashboardController@dashboardAnalytics')->name('dashboard.index');

  // Route Apps
  Route::get('/app-calender', 'CalenderAppController@calenderApp')->name('calendar.index');

  Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UsersController@index')->name('user.index');
    Route::get('/view/{id}', 'UsersController@show')->name('user.show');
    Route::get('/edit/{id}', 'UsersController@edit')->name('user.update');
    Route::post('/edit/{id}', 'UsersController@update')->name('user.update');
    Route::get('/add', 'UsersController@add')->name('user.store');
    Route::post('/add', 'UsersController@store')->name('user.store');
    Route::delete('/del/{id}', 'UsersController@destroy')->name('user.delete');
    Route::get('/permission/{id}', 'UsersController@updateUserModule')->name('users_modules.update');
    Route::get('/permission-action/{id}', 'UsersController@updateUserModuleAction')->name('users_modules_actions.update');
  });

  Route::group(['prefix' => 'modules'], function() {
    Route::get('/', 'UsersController@index')->name('modules.index');
    Route::get('/view/{id}', 'UsersController@show')->name('modules.show');
    Route::get('/edit/{id}', 'UsersController@edit')->name('modules.update');
    Route::post('/edit/{id}', 'UsersController@update')->name('modules.update');
    Route::get('/add', 'UsersController@add')->name('modules.store');
    Route::post('/add', 'UsersController@store')->name('modules.store');
    Route::delete('/del/{id}', 'UsersController@destroy')->name('modules.delete');
  });

  // access controller
  Route::get('/access-control', 'AccessController@index')->name('access.index');
  Route::get('/access-control/{roles}', 'AccessController@roles')->name('access.index');
  Route::get('/modern-admin', 'AccessController@home')->middleware('role:Admin');
});
