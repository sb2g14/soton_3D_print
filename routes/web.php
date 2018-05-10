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


// Routes for GENERIC PAGES
/////////////////////////////////////////////////////////////////////////////////////////////

// Here we redirect users to the 'Welcome' page
Route::get('/','HomeController@index')->name('home');

// This route uses controller to redirect to the 'About Workshop' page
Route::get('/aboutWorkshop','AboutWorkshopController@index'); //deprecated
Route::get('/about','AboutWorkshopController@index');

// This route uses controller to redirect to the 'Photolibrary' page
Route::get('/photolibrary','PhotolibraryController@index'); //deprecated
Route::get('/gallery','PhotolibraryController@index');

// display of charts
Route::get('/charts/{name}/{color}/{height}', 'ChartsController@show')->name('chart');

Route::group(['middleware' => ['auth']], function () {
    // This route uses controller to redirect to a personal page of every member
    Route::get('/myprints/','CustomerController@showprints');
});

// Here we redirect users to 'News' page
Route::get('news', 'NewsController@index'); //deprecated
Route::get('/history', 'NewsController@index');

// Redirection to a page with generic information and possibly some lessons
Route::get('/learn', 'LearnController@index');
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for FAQ
/////////////////////////////////////////////////////////////////////////////////////////////
// Route to faq
Route::get('/faq','FAQController@index');

Route::group(['middleware' => ['auth'], 'prefix' => 'faq'], function () {
    // Route to create a new Q & A
    Route::get('/create', 'FAQController@create');
});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for DEMONSTRATOR INFORMATION Pages
/////////////////////////////////////////////////////////////////////////////////////////////

// Route to getting paid page
Route::get('/gettingPaid', 'StaffController@gettingPaid');

// Route to documents page
Route::get('/documents', 'StaffController@documents');

// Route to statistics page
Route::get('/statistics','StatisticsController@show');
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for ANNOUNCEMENTS
/////////////////////////////////////////////////////////////////////////////////////////////

// Here we redirect to the page where we store announcement data
Route::post('/announcements','AnnouncementsController@store');

// Delete announcements
Route::get('/announcement/delete/{id}','AnnouncementsController@destroy');
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for GENERIC ISSUES (posts)
/////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Demonstrator|Coordinator|Technician|NewDemonstrator']], function () {
    // Here we redirect users to the create new post
    Route::get('/posts','PostsController@create');

    // Here we redirect to the page where we store post data
    Route::post('/posts','PostsController@store');

    // Here we redirect to the controller that would store our comments
    Route::post('/posts/{post}/comments', 'CommentsController@store');

    // Delete comments
    Route::get('/comments/delete/{id}', 'CommentsController@destroy');    

    // Resolve issues in posts
    Route::get('/posts/resolve/{id}', 'PostsController@resolve');

    // Remove posts

    Route::get('/post/delete/{id}', 'PostsController@destroy');
});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for PRINTER ISSUES (issues)
/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['role:,issues_manage']], function () {

    // Redirect to the view where one can manage issues
//    Route::get('/issues/index','IssuesController@index'); //deprecated
    Route::get('/issues','IssuesController@index');

    // Redirect to a form where demonstrator rise the issue and can update the printer status
    Route::get('/issues/select', 'IssuesController@select');

    // Select printer for updating status
    Route::post('/issues/select','IssuesController@selectPrinter');

    // The route for the raising the issue
    Route::post('/issues/create','IssuesController@create');

    //Route to update the issue
//    Route::get('/issues/update/{id}','IssuesController@edit'); //deprecated
    Route::get('/issues/{id}/edit','IssuesController@edit');

    // Route to update database entry for a resolved issue
    //Route::post('issues/resolve','IssuesController@resolve');
    Route::post('/issues/{id}/resolve','IssuesController@resolve');

    // Route to export issues to CSV
    Route::get('issues/export',
        [
            'as' => 'issues.export',
            'uses' => 'IssuesController@printersIssuesExport'
        ]);

    // Delete issue if it has been created by accident
//    Route::get('/issues/delete/{id}','IssuesController@destroy'); //deprecated
    Route::get('/issues/{id}/delete','IssuesController@destroy');

    //Form updating the issue
    Route::post('/issues/updates','IssuesUpdatesController@create');
//    Route::post('/issues/{id}/edit','IssueUpdatesController@update');

    // Delete issue update
//    Route::get('/issues/delete_update/{id}', 'IssuesController@deleteupdate'); //deprecated
    Route::get('/issues/updates/{id}/delete', 'IssuesUpdatesController@destroy');
});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for PRINTER MANAGEMENT
/////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['role:,printers_manage']], function () {
    
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
    Route::get('/printers/update/{id}','PrintersController@edit'); //deprecated
    Route::get('/printers/{id}/edit','PrintersController@edit');

    // Here we update printer information
    Route::post('/printers/update/{id}','PrintersController@update'); //deprecated
    Route::post('/printers/{id}/edit','PrintersController@update');

});

Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Coordinator|Technician|Demonstrator|NewDemonstrator|OnlineJobsManager']], function () {
//Route::group(['middleware' => ['role:,printers_view']], function () {
    // Here we redirect to the page containing general printer info using controller
    Route::get('/printers','PrintersController@index'); //deprecated
    Route::get('/printers','PrintersController@index');

    // Route view resolved issue for each printer
    Route::get('/issues/show/{id}','PrintersController@show'); //deprecated
    Route::get('/printers/{id}','PrintersController@show');
});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for WORKSHOP PRINTS
/////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['auth']], function () {
    // Open a form to request a job
    //Route::get('WorkshopJobs/create','WorkshopJobsController@create');

    // Save the job to a database and send to a demonstrator for approval
    //Route::post('WorkshopJobs/','WorkshopJobsController@store');
    
    // Routes to create and store Workshop jobs
    Route::resource('WorkshopJobs', 'WorkshopJobsController',['only' => ['create', 'store']]);
});

Route::group(['middleware' => ['role:,jobs_manage'], 'prefix' => 'WorkshopJobs'], function () {
    
    
    // Show a list of jobs waiting for approval
    Route::get('/requests','WorkshopJobsController@getRequests');
    
    // Show a list of approved/ printing jobs
    Route::get('/approved','WorkshopJobsController@getApproved');
    
    // Show a list of finished jobs
    Route::get('/finished','WorkshopJobsController@getFinished'); 
    
    // Route to export jobs to CSV
    Route::get('/export',
        [
            'as' => 'workshopJobs.export',
            'uses' => 'WorkshopJobsController@printingDataExport'
        ]);
    
    // Show details for a requested job
    Route::get('/{id}','WorkshopJobsController@show');
    
    // Approve a requested job and update the record
    Route::post('/{id}','WorkshopJobsController@update');
    
    // Reject a requested job and delete it from the database
    Route::get('/{id}/delete','WorkshopJobsController@destroy');

    // Mark approved job as successful
    Route::get('/{id}/success','WorkshopJobsController@success');
    
    // Mark approved job as failed/ unsuccessful
    Route::get('/{id}/failed','WorkshopJobsController@abort');
    
    // Show a form to edit a finished job
    Route::get('/{id}/edit','WorkshopJobsController@edit');

    // Update a finished job
    Route::post('/{id}/edit','WorkshopJobsController@review');
    
    // Restart a finished but failed job
    Route::get('/{id}/restart','WorkshopJobsController@restart');
    
    

});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for ONLINE ORDERS
/////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['auth']], function () {
    //// Routes to display online job request form
    //Route::get('/OnlineJobs/create', 'OrderOnlineController@create');

    //// Route to store an online request
    //Route::post('OnlineJobs', 'OrderOnlineController@store');
    
    // Routes to create and store online jobs
    Route::resource('OnlineJobs', 'OrderOnlineController',['only' => ['create', 'store']]);
});

Route::group(['middleware' => ['auth']], function () {
    // View approved job info
   // Route::get('/OnlineJobs/manageApproved/{id}', 'OrderOnlineController@manageApproved'); //deprecated
    Route::get('/OnlineJobs/approved/{id}', 'OrderOnlineController@manageApproved');

    // Job has been approved by customer
   // Route::get('/OnlineJobs/customerApproved/{id}', 'OrderOnlineController@customerApproved'); //deprecated
    Route::get('/OnlineJobs/approved/{id}/accept', 'OrderOnlineController@customerApproved');

    // Job has been rejected by customer
   // Route::get('/OnlineJobs/customerReject/{id}', 'OrderOnlineController@customerReject'); //deprecated
    Route::get('/OnlineJobs/approved/{id}/reject', 'OrderOnlineController@customerReject');
    
});

Route::group(['middleware' => ['role:,manage_online_jobs']], function () {
    
    // List pending online requests
   // Route::get('/OnlineJobs/index', 'OrderOnlineController@index'); //deprecated
    Route::get('/OnlineJobs/requests', 'OrderOnlineController@index');

    // Review each pending online request
   // Route::get('/OnlineJobs/checkrequest/{id}', 'OrderOnlineController@checkrequest'); //deprecated
    Route::get('/OnlineJobs/requests/{id}', 'OrderOnlineController@checkrequest');

    // Assign print preview to each online job request
   // Route::post('/OnlineJobs/checkrequest/{id}', 'OrderOnlineController@assignPrintPreview'); //deprecated
    Route::post('/OnlineJobs/requests/{id}', 'OrderOnlineController@assignPrintPreview');

    // Delete print preview from the job request
   // Route::get('/OnlineJobs/DeletePrintPreview/{id}', 'OrderOnlineController@deletePrintPreview'); //deprecated
    Route::get('/OnlineJobs/PrintPreview/{id}/delete', 'OrderOnlineController@deletePrintPreview');

    // Route to approve Job
  //  Route::get('/OnlineJobs/approveRequest/{id}', 'OrderOnlineController@approveRequest'); //deprecated
    Route::get('/OnlineJobs/requests/{id}/approve', 'OrderOnlineController@approveRequest');

    // Job approved by online jobs manager
    Route::get('/OnlineJobs/approved', 'OrderOnlineController@approved');

    // Return pending jobs
    Route::get('/OnlineJobs/pending', 'OrderOnlineController@pending');

    // Route to manage pending jobs
   // Route::get('/OnlineJobs/managePendingJob/{id}', 'OrderOnlineController@managePendingJob'); //deprecated
    Route::get('/OnlineJobs/pending/{id}', 'OrderOnlineController@managePendingJob');

    // Route to assign print to currently managed job
   // Route::post('/OnlineJobs/managePendingJob/{id}', 'OrderOnlineController@assignPrint'); //deprecated
    Route::post('/OnlineJobs/pending/{id}', 'OrderOnlineController@assignPrint');
    
    // Return prints in progress
    Route::get('/OnlineJobs/prints', 'OrderOnlineController@prints');
    
    // Route to cancel assigned prints leaving no trace in the DB
    //Route::get('/OnlineJobs/DeletePrint/{id}', 'OrderOnlineController@deletePrint'); //deprecated
    Route::get('/OnlineJobs/prints/{id}/delete', 'OrderOnlineController@deletePrint');
    
    // Route to report print as successful
   // Route::get('/OnlineJobs/printSuccessful/{id}', 'OrderOnlineController@printSuccessful'); //deprecated
    Route::get('/OnlineJobs/prints/{id}/success', 'OrderOnlineController@printSuccessful');

    // Route to report print as failed
   // Route::get('/OnlineJobs/printFailed/{id}', 'OrderOnlineController@printFailed'); //deprecated
    Route::get('/OnlineJobs/prints/{id}/failed', 'OrderOnlineController@printFailed');
    
    // Return completed online jobs
   // Route::get('/OnlineJobs/completed', 'OrderOnlineController@completed'); //deprecated
    Route::get('/OnlineJobs/finished', 'OrderOnlineController@completed');
    
    // Route for job failed
   // Route::post('/OnlineJobs/jobFailed/{id}', 'OrderOnlineController@jobFailed'); //deprecated
    Route::post('/OnlineJobs/{id}/failed', 'OrderOnlineController@jobFailed');

    // Route for job success
   // Route::get('/OnlineJobs/jobSuccess/{id}', 'OrderOnlineController@jobSuccess'); //deprecated
    Route::get('/OnlineJobs/{id}/success', 'OrderOnlineController@jobSuccess');
    
    // Job rejected by online jobs manager
   // Route::post('/OnlineJobs/delete/{id}', 'OrderOnlineController@rejectJobManager'); //deprecated
    Route::post('/OnlineJobs/{id}/delete', 'OrderOnlineController@rejectJobManager');
    
});

Route::group(['middleware' => ['auth']], function () {
    // Show messages for the job to customer and Online Manager
    Route::get('/OnlineJobs/{id}','OrderOnlineController@show');
    
    // Store new message for the job
    Route::post('/OnlineJobs/{id}/message','MessagesController@store');
});
/////////////////////////////////////////////////////////////////////////////////////////////


// Group of routes for PRINTER LOANS
/////////////////////////////////////////////////////////////////////////////////////////////

// Here the users are redirected to the page where they can rent a printer
Route::get('loan', 'LoanController@index');
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for managing the ROTA
/////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['role:,jobs_manage']], function () {
    // Open a form to display the rota sessions
    Route::get('/rota','RotaController@index');
    
    // Open a form to indicate availability for sessions
    Route::get('/rota/availability','AvailabilityController@edit'); //logical url based on the availability being part of the rota workflow
    Route::get('/availability','AvailabilityController@edit'); //shortcut to use in email

    // Update availability for sessions
    Route::post('/rota/availability','AvailabilityController@update');

});

Route::group(['middleware' => ['role:,staff_manage']], function () {

    // Open a form to create a new rota sessions
    Route::post('/rota/session/find','SessionController@startcreate');

    // Open a form to create a new rota session and update existing ones
    Route::get('/rota/session/{date}','RotaController@edit'); //deprecated
    Route::get('/rota/{date}/edit','RotaController@edit');

    // Store a new rota session
    Route::post('/rota/session/new','SessionController@store');

    // Delete an existing rota sessions
    Route::get('/rota/session/delete/{id}','SessionController@destroy'); //deprecated
    Route::get('/rota/session/{id}/delete','SessionController@destroy');

    // Update an existing rota session
    Route::post('/rota/updatesession','SessionController@update'); //deprecated
    Route::post('/rota/session/update','SessionController@update');

    // Open a form to assign demonstrators to sessions
    Route::get('/rota/assign/{date}','SessionController@showassign'); //deprecated
    Route::get('/rota/{date}/assign','SessionController@showassign');

    // Assign demonstrators to sessions
    Route::post('/rota/assign/{date}','SessionController@assign'); //deprecated
    Route::post('/rota/{date}/assign','SessionController@assign');
    
    // Open form to create email for rota
    Route::get('/rota/email/{date}','RotaController@createmail');
    // Send rota email
    Route::post('/rota/email/{date}','RotaController@sendmail');

    // Show blade to create a new event
    Route::get('/rota/newevent','EventController@create'); //deprecated
    Route::get('/rota/event/create','EventController@create');

    // Store a new event
    Route::post('/rota/event','EventController@store');

    // Show blade to update an existing event
    Route::get('/rota/event/{id}/edit','EventController@edit');

    // Update an existing event
    Route::post('/rota/event/{id}','EventController@update');

});
/////////////////////////////////////////////////////////////////////////////////////////////


// Group of routes for managing the FINANCES
/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['role:administrator|Coordinator']], function () {
    // Show default finance page
    Route::get('/finance','FinanceController@index');
    
    // Show page with latest unclaimed prints
    Route::get('/finance/jobs','FinanceController@jobsNow');

    // Show page with unclaimed prints
    Route::get('/finance/jobs/{month}','FinanceController@jobs');

    // Offer Download of Excel Spreadsheet with data
    Route::get('/finance/jobs/{month}/download','FinanceController@downloadJobs');
});

Route::group(['middleware' => ['role:,manage_cost_codes']], function () {

    // Here we redirect to the view where all cost codes are shown
    Route::get('/costCodes','CostCodesController@index');

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

});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for MANAGING STAFF, ROLES AND PERMISSIONS
/////////////////////////////////////////////////////////////////////////////////////////////

// Shows the list of workshop members
Route::get('/members/index','StaffController@index');

Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Demonstrator|OnlineManager|Coordinator|Technician']], function () {
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
});

Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Coordinator|Technician']], function () {

    // Manage roles blade
    Route::get('/roles', 'RolesManageController@index');
    
    // Here we redirect users to the add new member post page
    Route::get('/members','StaffController@create');

    // Here we redirect to the page where we store a new member
    Route::post('/members','StaffController@store');

});
/////////////////////////////////////////////////////////////////////////////////////////////


// Group of routes for ADMINISTRATIVE TASKS
/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['role:administrator']], function () {
    //execute database content updates
    Route::get('/admin/update','UpdateController@doUpdate'); 
});

Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Coordinator|Technician']], function () {

    // Find blade that shows print by id
    Route::get('/print/{id}','PrintsController@show');
    
    // Show information about a job by id
    Route::get('/job/{id}','JobsController@show');

    // Find blade that shows job by id
    Route::get('/job/{id}/find','JobsController@find');

    // Show Rota Settings for editing
    Route::get('/rota/settings','SettingsController@editRota');
    
    // Update Rota Settings
    Route::post('/rota/settings','SettingsController@updateRota');

    // Show Finance Settings for editing
    Route::get('/finance/settings','SettingsController@editFinance');
    
    // Update Finance Settings
    Route::post('/finance/settings','SettingsController@updateFinance');

});
/////////////////////////////////////////////////////////////////////////////////////////////


// Routes for AUTHENTICATION related things
/////////////////////////////////////////////////////////////////////////////////////////////

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
$this->post('register', 'Auth\RegisterController@register')->name('auth.register');
//SAML Authentication
$this->get('loginSAML', 'Auth\LoginController@loginSAML')->name('auth.UoS.login');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['role:administrator|LeadDemonstrator|Coordinator'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'AdminController@index');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

});

Route::get('/UoSlogin','Auth\UoScontroller@requestAuthenticationFromUoS');
/////////////////////////////////////////////////////////////////////////////////////////////
