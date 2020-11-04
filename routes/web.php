<?php
use App\Http\Controllers\LanguageController;
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
Route::get('lang/{locale}',[LanguageController::class,'swap']);

// Route Miscellaneous Pages
Route::get('/page-coming-soon', 'MiscellaneousController@coming_soon');
Route::get('/error-404', 'MiscellaneousController@error_404');
Route::get('/error-500', 'MiscellaneousController@error_500');
Route::get('/page-not-authorized', 'MiscellaneousController@not_authorized');
Route::get('/page-maintenance', 'MiscellaneousController@maintenance');

Route::group(['middleware' => ['auth', 'acl']], function() {
  // Route url
  Route::get('/', 'DashboardController@dashboardAnalytics');

  // Route Dashboards
  Route::get('/dashboard-analytics', 'DashboardController@dashboardAnalytics');

  // Route Apps
  Route::get('/app-calender', 'CalenderAppController@calenderApp');

  // Users Pages
  Route::get('/app-user-list', 'UserPagesController@user_list');
  Route::get('/app-user-view', 'UserPagesController@user_view');
  Route::get('/app-user-edit', 'UserPagesController@user_edit');
  Route::get('/user-register', 'AuthenticationController@register');

  // Route Data List
  Route::resource('/data-list-view','DataListController');
  Route::resource('/data-thumb-view', 'DataThumbController');

  // access controller
  Route::get('/access-control', 'AccessController@index');
  Route::get('/access-control/{roles}', 'AccessController@roles');
  Route::get('/modern-admin', 'AccessController@home')->middleware('role:Admin');
});
