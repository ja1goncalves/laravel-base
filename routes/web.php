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

// Route Data List
Route::resource('/data-list-view','DataListController');
Route::resource('/data-thumb-view', 'DataThumbController');

// Route Pages
Route::get('/page-user-profile', 'PagesController@user_profile');
Route::get('/page-faq', 'PagesController@faq');
Route::get('/page-knowledge-base', 'PagesController@knowledge_base');
Route::get('/page-kb-category', 'PagesController@kb_category');
Route::get('/page-kb-question', 'PagesController@kb_question');
Route::get('/page-search', 'PagesController@search');
Route::get('/page-invoice', 'PagesController@invoice');
Route::get('/page-account-settings', 'PagesController@account_settings');
Route::get('/pricing', 'PagesController@pricing');

// Route Authentication Pages
Route::get('/auth-login', 'AuthenticationController@login');
Route::get('/auth-register', 'AuthenticationController@register');
Route::get('/auth-forgot-password', 'AuthenticationController@forgot_password');
Route::get('/auth-reset-password', 'AuthenticationController@reset_password');
Route::get('/auth-lock-screen', 'AuthenticationController@lock_screen');

// Route Miscellaneous Pages
Route::get('/page-coming-soon', 'MiscellaneousController@coming_soon');
Route::get('/error-404', 'MiscellaneousController@error_404');
Route::get('/error-500', 'MiscellaneousController@error_500');
Route::get('/page-not-authorized', 'MiscellaneousController@not_authorized');
Route::get('/page-maintenance', 'MiscellaneousController@maintenance');

// access controller
Route::get('/access-control', 'AccessController@index');
Route::get('/access-control/{roles}', 'AccessController@roles');
Route::get('/modern-admin', 'AccessController@home')->middleware('role:Admin');

// Auth::routes();

Route::post('/login/validate', 'Auth\LoginController@validate_api');

// locale Route
Route::get('lang/{locale}',[LanguageController::class,'swap']);
