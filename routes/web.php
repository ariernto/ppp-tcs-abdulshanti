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

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/terms', 'StaticController@terms')->name('terms');
Route::get('/policy', 'StaticController@policy')->name('policy');
Route::get('/login', function () { return view('auth/login'); });
Auth::routes();
Route::post('/login', 'AdminAuthController@postlogin')->name('login');
Route::get('/logout', 'AdminAuthController@logout');
//Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email.post');
Route::get('/sended', 'AdminAuthController@sended')->name('sended');
Route::middleware(['logincheck'])->group(function () {
    //Route::get('/logout', 'AdminAuthController@logout');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/home', 'HomeController@index')->name('home');
    // properties
    Route::get('/properties', 'PropertyControlle@index')->name('properties');
    Route::get('/properties/{sortby}/{filterby}', 'PropertyControlle@index')->name('properties.sort');
    Route::get('/properties/{pagination}', 'PropertyControlle@index')->name('properties.pagination');
    Route::get('/properties/{sortby}/{filterby}/{pagination}', 'PropertyControlle@index')->name('properties.filter');
    Route::get('/property/{id}', 'PropertyControlle@show')->name('property.details');
    Route::post('/properties', 'PropertyControlle@indexPost')->name('properties.post');
    Route::post('/properties/{sortby}/{filterby}', 'PropertyControlle@indexPost')->name('properties.post');
    Route::post('/properties/{sortby}/{filterby}/{pagination}', 'PropertyControlle@indexPost')->name('properties.post');
    // enquiries
    Route::get('/enquiries', 'PropertyControlle@enquiries')->name('enquiries');
    Route::get('/enquiries/{sortby}/{filterby}', 'PropertyControlle@enquiries')->name('enquiries.sort');
    Route::get('/enquiries/{sortby}/{filterby}/{pagination}', 'PropertyControlle@enquiries')->name('enquiries.filter');
    Route::post('/enquiries', 'PropertyControlle@enquiriesPost')->name('enquiries.post');
    Route::post('/enquiries/{sortby}/{filterby}', 'PropertyControlle@enquiriesPost')->name('enquiries.post');
    Route::post('/enquiries/{sortby}/{filterby}/{pagination}', 'PropertyControlle@enquiriesPost')->name('enquiries.post');
    Route::get('/enquiry/{id}', 'PropertyControlle@enquiry')->name('enquiry.details');
    Route::post('/enquiryChat', 'PropertyControlle@enquiryChat')->name('enquiry.chat');
    Route::post('/enquiryUpdate', 'PropertyControlle@enquiryUpdate')->name('enquiry.update');
    // applications
    Route::get('/applications', 'PropertyControlle@applications')->name('applications');
    Route::get('/applications/{sortby}/{filterby}', 'PropertyControlle@applications')->name('applications.sort');
    Route::get('/applications/{sortby}/{filterby}/{pagination}', 'PropertyControlle@applications')->name('applications.filter');
    Route::get('/application/{id}', 'PropertyControlle@applicationDetails')->name('application.details');
    Route::post('/applications', 'PropertyControlle@applicationsPost')->name('applications.post');
    Route::post('/applications/{sortby}/{filterby}', 'PropertyControlle@applicationsPost')->name('applications.post');
    Route::post('/applications/{sortby}/{filterby}/{pagination}', 'PropertyControlle@applicationsPost')->name('applications.post');
    Route::post('/applicationChat', 'PropertyControlle@applicationChat')->name('application.chat');
    Route::post('/application/change_status', 'PropertyControlle@application_status')->name('application.change_status');
    // inspections
    Route::get('/inspections', 'PropertyControlle@inspections')->name('inspections');
    Route::get('/inspection/delete_message', 'PropertyControlle@delete_message')->name('inspection.delete_message');
    Route::get('/inspections/{sortby}/{filterby}/{pagination}', 'PropertyControlle@inspections')->name('inspections.filter');
    Route::get('/inspections/{sortby}/{filterby}', 'PropertyControlle@inspections')->name('inspections.sort');
    Route::get('/inspection/{id}', 'PropertyControlle@inspectionDetails')->name('inspection.details');
    Route::post('/inspections', 'PropertyControlle@inspectionsPost')->name('inspections.post');
    Route::post('/inspections/{sortby}/{filterby}/{pagination}', 'PropertyControlle@inspectionsPost')->name('inspections.post');
    Route::post('/inspections/{sortby}/{filterby}', 'PropertyControlle@inspectionsPost')->name('inspections.post');
    Route::post('/inspectionChat', 'PropertyControlle@inspectionChat')->name('inspection.chat');
    Route::post('/inspection/change_status', 'PropertyControlle@inspection_status')->name('inspection.change_status');
    Route::post('/inspection/delete', 'PropertyControlle@inspection_delete')->name('inspection.delete');
    // wishlist
    Route::get('/wishlist', 'PropertyControlle@wishlist_list')->name('wishlist');
    Route::get('/wishlist/{sortby}/{filterby}', 'PropertyControlle@wishlist_list')->name('wishlist.sort');
    Route::get('/wishlist/{sortby}/{filterby}/{pagination}', 'PropertyControlle@wishlist_list')->name('wishlist.filter');
    Route::post('/wishlist', 'PropertyControlle@wishlistPost')->name('wishlist.post');
    Route::post('/wishlist/{sortby}/{filterby}', 'PropertyControlle@wishlistPost')->name('wishlist.post');
    Route::post('/wishlist/{sortby}/{filterby}/{pagination}', 'PropertyControlle@wishlistPost')->name('wishlist.post');
    // Maintanance
    Route::get('/maintanances', 'PropertyControlle@maintanances')->name('maintanances');
    Route::get('/maintanances/{sortby}/{filterby}', 'PropertyControlle@maintanances')->name('maintanances.sort');
    Route::get('/maintanances/{sortby}/{filterby}/{pagination}', 'PropertyControlle@maintanances')->name('maintanances.filter');
    Route::post('/maintanances', 'PropertyControlle@maintanancesPost')->name('maintanances.post');
    Route::post('/maintanances/{sortby}/{filterby}', 'PropertyControlle@maintanancesPost')->name('maintanances.post');
    Route::post('/maintanances/{sortby}/{filterby}/{pagination}', 'PropertyControlle@maintanancesPost')->name('maintanances.post');
    Route::get('/maintanance/{id}', 'PropertyControlle@maintananceDetails')->name('maintanance.details');
    Route::post('/maintananceChat', 'PropertyControlle@maintananceChat')->name('maintanance.chat');
    Route::post('/maintenance/change_status', 'PropertyControlle@job_status')->name('maintanance.change_status');
    // tenants
    Route::get('/tenants', 'TenantController@index')->name('tenants');
    Route::get('/tenants/edit/{id}', 'TenantController@edit')->name('tenants.edit');
    Route::post('/tenants/edit/{id}', 'TenantController@update')->name('tenants.update');

    Route::get('/tenants/{sortby}/{filterby}', 'TenantController@index')->name('tenants.sort');
    Route::get('/tenants/{sortby}/{filterby}/{pagination}', 'TenantController@index')->name('tenants.pagination.sort');

    Route::get('/tenants/{id}', 'TenantController@show')->name('tenants.details');
    Route::post('/tenants', 'TenantController@index_post')->name('tenants.post');
    Route::post('/tenants/{sortby}/{filterby}', 'TenantController@index_post')->name('tenants.post');
    Route::post('/tenants/{sortby}/{filterby}/{pagination}', 'TenantController@index_post')->name('tenants.pagination.post');
    Route::get('/new-tenant', 'TenantController@create')->name('new-tenant');
    Route::post('/new-tenant', 'TenantController@store')->name('new-tenant.create');
    Route::post('/get-agent', 'TenantController@agent')->name('get-agent');
    // tenants
    Route::get('/prospects', 'ProspectsController@index')->name('prospects');
    Route::get('/prospects/{sortby}/{filterby}', 'ProspectsController@index')->name('prospects.sort');
    Route::post('/prospects', 'ProspectsController@index_post')->name('prospects');
    Route::post('/prospects/{sortby}/{filterby}', 'ProspectsController@index_post')->name('prospects.sort');
    Route::get('/prospects/{id}', 'ProspectsController@show')->name('prospects.details');
    // users
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/{sortby}/{filterby}', 'UserController@index')->name('users');
    Route::post('/users/delete', 'UserController@destroy')->name('users.delete');
    Route::post('/users/deactivate', 'UserController@deactivate')->name('users.deactivate');
    Route::post('/users/activate', 'UserController@activate')->name('users.activate');
    Route::post('/users/create', 'UserController@store')->name('users.store');

    Route::post('/users/check_user', 'UserController@create')->name('users.create');

    Route::get('/user/{id}', 'UserController@show')->name('user.show');
    Route::get('/user/{id}/edit', 'UserController@edit')->name('user.edit');
    Route::post('/user/{id}/edit', 'UserController@update')->name('user.update');
    // workers
    Route::get('/workers', 'WorkerController@index')->name('workers');
    Route::get('/workers/{sortby}/{filterby}', 'WorkerController@index')->name('workers');
    Route::post('/workers/delete', 'WorkerController@destroy')->name('workers.delete');
    Route::post('/workers/deactivate', 'WorkerController@deactivate')->name('workers.deactivate');
    Route::post('/workers/activate', 'WorkerController@activate')->name('workers.activate');
    Route::post('/worker/create', 'WorkerController@store')->name('worker.store');
    Route::get('/worker/{id}', 'WorkerController@show')->name('worker.show');
    Route::get('/worker/get/{id}', 'WorkerController@edit')->name('worker.edit');
    Route::post('/worker/update', 'WorkerController@update')->name('worker.update');
    // Help guides
    Route::get('/help', 'HelpController@index')->name('help');
    Route::get('/help/{sortby}/{filterby}', 'HelpController@index')->name('help');
    Route::get('/help/{id}', 'HelpController@show')->name('help.show');
    Route::post('/help/edit', 'HelpController@edit')->name('help.edit');
    Route::post('/help/store', 'HelpController@store')->name('help.store');
    Route::post('/help/update', 'HelpController@update')->name('help.update');
    Route::post('/help/delete', 'HelpController@destroy')->name('help.destroy');
    // News
    Route::get('/news', 'NewsController@index')->name('news');
    Route::get('/news/{sortby}/{filterby}', 'NewsController@index')->name('news');
    Route::post('/news/delete', 'NewsController@destroy')->name('news.delete');
    Route::get('/news/{id}', 'NewsController@show')->name('news.show');
    Route::post('/news/edit', 'NewsController@edit')->name('news.edit');
    Route::post('/news/update', 'NewsController@update')->name('news.update');
    Route::post('/news/store', 'NewsController@store')->name('news.store');
    // update-notice
    Route::get('/update-notice', 'UpdateNoticeController@index')->name('updateNotice');
    Route::get('/update-notice/{sortby}/{filterby}', 'UpdateNoticeController@index')->name('updateNotice');
    Route::get('/update-notice/{id}', 'UpdateNoticeController@show')->name('updateNotice.show');
    Route::post('/update-notice/delete', 'UpdateNoticeController@destroy')->name('updateNotice.destroy');
    Route::post('/update-notice/store', 'UpdateNoticeController@store')->name('updateNotice.store');
    Route::post('/update-notice/edit', 'UpdateNoticeController@edit')->name('updateNotice.edit');

    Route::post('/update-notice/update', 'UpdateNoticeController@update')->name('updateNotice.update');

    // push-notification
    Route::get('/push-notification', 'PropertyControlle@notification');
});



