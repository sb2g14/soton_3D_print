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

// This route uses controller to redirect to a personal page of every member
Route::get('/myprints/','CustomerController@showprints');

// Manage roles blade
Route::get('/roles', 'RolesManageController@index');

// Here we redirect users to the 'Welcome' page
Route::get('/','PostsController@index')->name('home');

// Here we redirect users to the create new post
Route::get('/posts','PostsController@create');

// Here we redirect to the page where we store post data
Route::post('/posts','PostsController@store');

// Here we redirect to the page where we store announcement data
Route::post('/announcements','AnnouncementsController@store');

// Delete announcements

Route::get('/announcement/delete/{id}','AnnouncementsController@destroy');

// Here we redirect to the controller that would store our comments
Route::post('/posts/{post}/comments', 'CommentsController@store');

// Delete comments
Route::get('/comments/delete/{id}', 'CommentsController@destroy');

// This route uses controller to redirect to the 'About Workshop' page
Route::get('/aboutWorkshop','AboutWorkshopController@index');

// This route uses controller to redirect to the 'Photolibrary' page
Route::get('/photolibrary','PhotolibraryController@index');

// Shows the list of workshop members
Route::get('/members/index','StaffController@index');

// This route uses controller to redirect to a personal page of every member
Route::get('/members/{id}','StaffController@show');

// This route uses controller to redirect to a personal page to update the personal record of selected member
Route::get('/members/edit/{id}','StaffController@edit');

// This route uses controller to update a personal page of selected member
Route::post('/members/edit/{id}','StaffController@update');

// This route uses controller to delete a personal page of selected member
Route::get('/members/delete/{id}','StaffController@destroy');

// This route uses controller to access former member blade
Route::get('/members/former/show','StaffController@former');

// Here we redirect to the page containing general printer info using controller
Route::get('/printers/index','PrintersController@index');

// display of charts
Route::get('/charts/{name}/{color}/{height}', 'ChartsController@show')->name('chart');

// Group of routes available only to roles administrator, Lead Demonstrator, Demonstrator
/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Demonstrator|Coordinator|Technician|NewDemonstrator']], function () {

    // Resolve issues in posts
    Route::get('/posts/resolve/{id}', 'PostsController@resolve');

    // Remove posts

    Route::get('/post/delete/{id}', 'PostsController@destroy');

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

    // Route to export issues to CSV

    Route::get('issues/export',
        [
            'as' => 'issues.export',
            'uses' => 'IssuesController@printersIssuesExport'
        ]);

    // Delete issue if it has been created by accident

    Route::get('/issues/delete/{id}','IssuesController@destroy');

    // Delete issue update
    Route::get('/issues/delete_update/{id}', 'IssuesController@deleteupdate');

    // Show a list of jobs waiting for approval

    Route::get('/printingData/index','PrintingDataController@index');

    // Route to export jobs to CSV

    Route::get('printingData/export',
        [
            'as' => 'printingData.export',
            'uses' => 'PrintingDataController@printingDataExport'
        ]);

    // Show a list of approved jobs

    Route::get('/printingData/approved','PrintingDataController@approved');

    // Show a list of finished jobs

    Route::get('/printingData/finished','PrintingDataController@finished');

    // Show a blade to edit the job
    Route::get('/printingData/edit/{id}','PrintingDataController@edit');

    // Show a blade to save edit the job
    Route::post('/printingData/edit/{id}','PrintingDataController@review');

    // Show each job requested in a separate blade
    Route::get('/printingData/show/{id}','PrintingDataController@show');

    // Update the requested record and approve/reject a job
    Route::post('/printingData/show/{id}','PrintingDataController@update');

    // Reporting that current job is unsuccessful
    Route::get('/printingData/abort/{id}','PrintingDataController@abort');

    // Reporting that current job is successful
    Route::get('/printingData/success/{id}','PrintingDataController@success');

    // Reject current job and delete it from the database
    Route::get('/printingData/delete/{id}','PrintingDataController@destroy');

    // Route to restart a failed job
    Route::get('/printingData/restart/{id}','PrintingDataController@restart');

});

// Group of routes available only to roles administrator, Lead Demonstrator
/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Coordinator|Technician']], function () {
    
    //consider using
    //Route::resource('printers', 'PrintersController');
    //to replace
    //Route::get('/printers','PrintersController@index');
    //Route::get('/printers/create','PrintersController@create');
    //Route::post('/printers','PrintersController@store');
    //Route::get('/printers/{id}','PrintersController@show);
    //Route::get('/printers/{id}/edit','PrintersController@edit');
    //Route::put('/printers/{id}','PrintersController@update');
    //Route::delete('/printers/{id}','PrintersController@destroy');
    //see https://laravel.com/docs/5.1/controllers#restful-resource-controllers for more info on how to control the behaviour
            
    // Here we redirect users to the add new printer post page
    Route::get('/printers/create','PrintersController@create');

    // Here we redirect to the page where we store a new printer
    Route::post('/printers','PrintersController@store');

    // Here we redirect to the view where one can update a printer
    Route::get('/printers/update/{id}','PrintersController@edit');

    // Here we update printer information
    Route::post('/printers/update/{id}','PrintersController@update');

    // Here we redirect users to the add new member post page
    Route::get('/members','StaffController@create');

    // Here we redirect to the page where we store a new member
    Route::post('/members','StaffController@store');

    // Here we redirect to the view where all cost codes are shown
    Route::get('/costCodes/index','CostCodesController@index');

    // Here old cost codes are displayed
    Route::get('/costCodes/expired','CostCodesController@indexInactive');

    // Here we redirect to the view where a cost codes can be created
    Route::get('/costCodes/create','CostCodesController@create');

    // Post update cost code information
    Route::post('/costCodes/create', 'CostCodesController@store');

    // Here we redirect to the view where all cost codes can be updated
    Route::get('/costCodes/update/{id}','CostCodesController@edit');

    // Post update cost code information
    Route::post('/costCodes/update/{id}', 'CostCodesController@update');

    // Delete cost code
    Route::get('/costCodes/delete/{id}', 'CostCodesController@destroy');

    // Find blade that shows print by id
    Route::get('/print/{id}','PrintsController@show');
    
    // Find blade that shows job by id
    Route::get('/job/{id}','JobsController@show');

});



// Group of routes available to online jobs manager only
/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['role:OnlineJobsManager|administrator|Demonstrator']], function () {

    // List pending online requests
    Route::get('/OnlineJobs/index', 'OrderOnlineController@index');

    // Review each pending online request
    Route::get('/OnlineJobs/checkrequest/{id}', 'OrderOnlineController@checkrequest');

    // Assign print preview to each online job request
    Route::post('/OnlineJobs/checkrequest/{id}', 'OrderOnlineController@assignPrintPreview');

    // Delete print preview from the job request
    Route::get('/OnlineJobs/DeletePrintPreview/{id}', 'OrderOnlineController@deletePrintPreview');

    // Job rejected by online jobs manager
    Route::post('/OnlineJobs/delete/{id}', 'OrderOnlineController@rejectJobManager');

    // Route to approve Job
    Route::get('/OnlineJobs/approveRequest/{id}', 'OrderOnlineController@approveRequest');

    // Job approved by online jobs manager
    Route::get('/OnlineJobs/approved', 'OrderOnlineController@approved');

    // View approved job info
    Route::get('/OnlineJobs/manageApproved/{id}', 'OrderOnlineController@manageApproved');

    // Job has been approved by customer
    Route::get('/OnlineJobs/customerApproved/{id}', 'OrderOnlineController@customerApproved');

    // Job has been rejected by customer
    Route::get('/OnlineJobs/customerReject/{id}', 'OrderOnlineController@customerReject');

    // Return pending jobs
    Route::get('/OnlineJobs/pending', 'OrderOnlineController@pending');

    // Return prints in progress
    Route::get('/OnlineJobs/prints', 'OrderOnlineController@prints');

    // Return completed
    Route::get('/OnlineJobs/completed', 'OrderOnlineController@completed');

    // Route to manage pending jobs
    Route::get('/OnlineJobs/managePendingJob/{id}', 'OrderOnlineController@managePendingJob');

    // Route to assign print to currently managed job
    Route::post('/OnlineJobs/managePendingJob/{id}', 'OrderOnlineController@assignPrint');

    // Route to cancel assigned prints leaving no trace in the DB
    Route::get('/OnlineJobs/DeletePrint/{id}', 'OrderOnlineController@deletePrint');

    // Route for job failed
    Route::post('/OnlineJobs/jobFailed/{id}', 'OrderOnlineController@jobFailed');

    // Route for job success
    Route::get('/OnlineJobs/jobSuccess/{id}', 'OrderOnlineController@jobSuccess');

    // Route to report print as successful
    Route::get('/OnlineJobs/printSuccessful/{id}', 'OrderOnlineController@printSuccessful');

    // Route to report print as failed
    Route::get('/OnlineJobs/printFailed/{id}', 'OrderOnlineController@printFailed');


});

// Group of routes for managing the ROTA
/////////////////////////////////////////////////////////////////////////////////////////////

// Open a form to display the rota sessions
Route::get('/rota','RotaController@index');


Route::group(['middleware' => ['role:,jobs_manage']], function () {
    // Open a form to indicate availability for sessions
    Route::get('/rota/availability','AvailabilityController@edit'); //logical url based on the availability being part of the rota workflow
    Route::get('/availability','AvailabilityController@edit'); //shortcut to use in email

    // Update availability for sessions
    Route::post('/rota/availability','AvailabilityController@update');

});

Route::group(['middleware' => ['role:,staff_manage']], function () {

    // Open a form to create a new rota sessions
    //Route::post('/rota/session/new/make','SessionController@startcreate');  //deprecated
    Route::post('/rota/session/find','SessionController@startcreate');

    // Open a form to create a new rota session and update existing ones
    //Route::get('/rota/session/new/{date}','RotaController@edit');  //deprecated
    Route::get('/rota/session/{date}','RotaController@edit');

    // Store a new rota session
    Route::post('/rota/session/new','SessionController@store');

    // Delete an existing rota sessions
    Route::get('/rota/session/delete/{id}','SessionController@destroy');

    // Update an existing rota session
    Route::post('/rota/updatesession','SessionController@update'); //deprecated
    Route::post('/rota/session/update','SessionController@update');

    // Open a form to assign demonstrators to sessions
    Route::get('/rota/assign/{date}','SessionController@showassign');

    // Assign demonstrators to sessions
    Route::post('/rota/assign/{date}','SessionController@assign');
    
    // Open form to create email for rota
    Route::get('/rota/email/{date}','RotaController@createmail');
    // Send rota email
    Route::post('/rota/email/{date}','RotaController@sendmail');

    // Show blade to create a new event
    Route::get('/rota/newevent','EventController@create'); //deprecated
    Route::get('/rota/event/new','EventController@create');

    // Store a new event
    Route::post('/rota/newevent','EventController@store'); //deprecated
    Route::post('/rota/event/new','EventController@store');

    // Show blade to update an existing event
    Route::get('/rota/event/update/{id}','EventController@edit');

    // Update an existing event
    Route::post('/rota/event/update/{id}','EventController@update');

});

/////////////////////////////////////////////////////////////////////////////////////////////

// Open a form to request a job
Route::get('/printingData/create','PrintingDataController@create');

// Save the job to a database and send to a demonstrator for approval
Route::post('/printingData','PrintingDataController@store');

// Here we redirect users to 'News' page
Route::get('news', 'NewsController@index');

// Here the users are redirected to the page where they can rent a printer
Route::get('loan', 'LoanController@index');

// Redirection to a page with generic information and possibly some lessons
Route::get('/learn', 'LearnController@index');

// Routes to display online job request form
Route::get('/OnlineJobs/create', 'OrderOnlineController@create');

// Route to store an online request
Route::post('onlineJobs', 'OrderOnlineController@store');

// Route to getting paid page
Route::get('/gettingPaid', 'StaffController@gettingPaid');

// Route to documents page
Route::get('/documents', 'StaffController@documents');

// Route to faq

Route::get('/faq','FAQController@index');

Route::get('/statistics','StatisticsController@show');

// Route::get('/notify', function () {
//    notify()->flash('Welcome back!', 'success', [
//        'text' => 'It\'s really great to see you again',
//    ]);
//    return redirect() -> to('/aboutWorkshop');
//});

// Authentication Routes...
/////////////////////////////////////////////////////////////////////////////////////////////
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
$this->post('register', 'Auth\RegisterController@register')->name('auth.register');

// Change Password Routes...
/////////////////////////////////////////////////////////////////////////////////////////////
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
/////////////////////////////////////////////////////////////////////////////////////////////
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

Route::get('/UoSlogin','Auth\UoScontroller@requestAuthenticationFromUoS');

Route::get('/faq/create', 'FAQController@create');
