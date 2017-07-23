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

// Manage roles blade
Route::get('/roles', function () { return redirect('/admin/home'); });

// Here we redirect users to the 'Welcome' page
Route::get('/','PostsController@index')->name('home');

// Here we redirect users to the create new post
Route::get('/posts','PostsController@create');

// Here we redirect to the page where we store post data
Route::post('/posts','PostsController@store');

// Here we redirect to the page where we store announcement data
Route::post('/announcements','AnnouncementsController@store');

// Here we redirect to the controller that would store our comments
Route::post('/posts/{post}/comments', 'CommentsController@store');

// This route uses controller to redirect to the 'About Workshop' page
Route::get('/aboutWorkshop','AboutWorkshopController@index');

// Shows the list of workshop members
Route::get('/members/index','StaffController@index');

// This route uses controller to redirect to a personal page of every member
Route::get('/members/{member}','StaffController@show');

// This route uses controller to redirect to a personal page to update the personal record of selected member
Route::get('/members/edit/{member}','StaffController@edit');

// This route uses controller to update a personal page of selected member
Route::post('/members/edit/{member}','StaffController@update');

// This route uses controller to delete a personal page of selected member
Route::get('/members/delete/{member}','StaffController@destroy');

// Here we redirect users to the add new member post page
Route::get('/aboutWorkshop/create','StaffController@create');

// Here we redirect to the page where we store a new member
Route::post('/aboutWorkshop','StaffController@store');

// Here we redirect to the page containing general printer info using controller
Route::get('/printers/index','PrintersController@index');

// Here we redirect users to the add new printer post page
Route::get('/printers/create','PrintersController@create');

// Here we redirect to the page where we store a new printer
Route::post('/printers','PrintersController@store');

// Redirect to the view where one can manage issues

Route::get('/issues/index','IssuesController@index');

// Redirect to a form where demonstrator rise the issue and can update the printer status

Route::get('/issues/select', 'IssuesController@select');

// Select printer for updating status
Route::post('/issues/select','IssuesController@selectPrinter');

// The route for the raising the issue
Route::post('/issues/create','IssuesController@create');

//Route to update the issue
Route::get('/issues/update/{id}','IssuesController@edit');

//Form updating the issue
Route::post('/issues/update','IssuesController@update');

// Route to show the issue to be resolved
Route::get('issues/resolve/{id}','IssuesController@showResolve');

// Route to update database entry for a resolved issue
Route::post('issues/resolve','IssuesController@resolve');

// Route view resolved issue for each printer
Route::get('issues/show/{id}','IssuesController@show');

// Show a list of jobs waiting for approval

Route::get('/printingData/index','PrintingDataController@index');

// Show a list of approved jobs

Route::get('/printingData/approved','PrintingDataController@approved');

// Open a form to request a job
Route::get('/printingData/create','PrintingDataController@create');

// Save the job to a database and send to a demonstrator for approval
Route::post('/printingData','PrintingDataController@store');

// Show each job requested ina separate blade
Route::get('/printingData/{id}','PrintingDataController@show');

// Update the requested record and approve/reject a job
Route::post('/printingData/{id}','PrintingDataController@update');

// Reporting that current job is unsuccessful
Route::get('/printingData/abort/{id}','PrintingDataController@abort');

// Reporting that current job is successful
Route::get('/printingData/success/{id}','PrintingDataController@success');

// Reject current job and delete it from the database
Route::get('/printingData/delete/{id}','PrintingDataController@destroy');

// Here we redirect users to 'News' page
Route::get('news', 'NewsController@index');

// Here the users are redirected to the page where they can rent a printer
Route::get('loan', 'LoanController@index');

// Redirection to a page with generic information and possibly some lessons
Route::get('/learn', 'LearnController@index');

// Order online blade with the link to 3dhubs and the instruction how to use it
Route::get('/orderOnline','OrderOnlineController@index');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
$this->post('register', 'Auth\RegisterController@create')->name('auth.register');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

});
