<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//api ApiAuth  route
Route::post('/register', 'ApiAuth@create')->middleware('keyCheck:api'); // register user
Route::post('/login', 'ApiAuth@login')->middleware('keyCheck:api');  //user login
Route::post('/forgot_password', 'ApiAuth@forgot')->middleware('keyCheck:api');  //user forgot password
Route::post('/reset_password', 'ApiAuth@updatePassword')->middleware('keyCheck:api');  //user update password

Route::group(['middleware' => ['tokenverify','keyCheck']], function () {
    Route::post('/details', 'ApiAuth@get_details');  //get profile details
    Route::post('/updateprofile', 'ApiAuth@update_profile');  //user update profile
    Route::post('/logout', 'ApiAuth@logout');  //User logout
    Route::post('/changepassword', 'ApiAuth@change_password');  //change password
    Route::post('/updatenotification', 'ApiAuth@update_notification');  //change notification
    Route::post('/latestnews', 'ApiAuth@latest_news');  //latest news
    Route::post('/newsdetais', 'ApiAuth@news_details');  //News Details
    Route::post('/news/bookmark', 'ApiAuth@news_bookmark');  //News add bookmark
    Route::post('/news/bookmark_list', 'ApiAuth@news_bookmark_list');  //News bookmark list
    Route::post('/news/bookmark_delete', 'ApiAuth@bookmark_delete');  //News bookmark list
    Route::post('/latestevents', 'ApiAuth@latest_event');  //latest event
    Route::post('/eventdetais', 'ApiAuth@event_details');  //event Details
    Route::post('/event/register', 'ApiAuth@register_event');  //register event
    Route::post('/event/myevents', 'ApiAuth@myevents');  //my event
    Route::post('/event/enquire', 'ApiAuth@enquire_event');  //enquire event
    Route::post('/getnotification', 'ApiAuth@get_notification');  //get notificcation
    Route::post('/settingsnotification', 'ApiAuth@setings_notification');  //get notificcation
    Route::post('/updates_and_notice', 'ApiAuth@updates_and_notice');  //get notificcation
    Route::post('/send_feedbcak','ApiAuth@send_feedback');  //send feedback
    Route::post('/helps','ApiAuth@helps');  //help list
    Route::post('/help/details','ApiAuth@help_details');  //help list
    Route::post('/help/feedback','ApiAuth@help_feedback');  //help list
    //api ApiProperties  route
    Route::post('/enquiries/create', 'ApiProperties@create_enquiry');  //create enquiry
    Route::post('/enquiries', 'ApiProperties@enquiries_list');  //enquiries list
    Route::post('/enquiries/sendmessage', 'ApiProperties@enquiries_message');  //enquiry send  message
    Route::post('/enquiries/allmessage', 'ApiProperties@enquiries_message_list');  //enquiry send  message
    Route::post('/enquiries/status', 'ApiProperties@enquiries_status');  //property inspect delete
    Route::post('/enquiries/info', 'ApiProperties@enquery_information');  //enquery infos
    Route::post('/wishlist', 'ApiProperties@wishlist');  //wishlist property
    Route::post('/wishlist/add', 'ApiProperties@wishlist_add');  //wishlist property
    Route::post('/wishlist/allclear', 'ApiProperties@wishlist_clear');  //wishlist clear
    Route::post('/wishlist/delete', 'ApiProperties@wishlist_delete');  //wishlist delete
    Route::post('/wishlist/undo', 'ApiProperties@wishlist_undo');  //wishlist delete
    Route::post('/job/create', 'ApiProperties@job_create');  //job create
    Route::post('/job', 'ApiProperties@job_list');  //job list
    Route::post('/job/detail', 'ApiProperties@job_details');  //job list
    Route::post('/job/messages', 'ApiProperties@job_message_list');  //job list
    Route::post('/job/messages_send', 'ApiProperties@job_message_send');  //job list
    Route::post('/job/review', 'ApiProperties@job_review_rating');  //job list
    Route::post('/application/apply', 'ApiProperties@application_create');  //job list
    Route::post('/applications/status', 'ApiProperties@applications_status');  //property inspect delete ,cancel archive ,mute
    Route::post('/applications', 'ApiProperties@application_list');  //application list
    Route::post('/applications/message', 'ApiProperties@application_message');  //application message
    Route::post('/application/allmessage', 'ApiProperties@application_message_list');  //application message
    Route::post('/application/info', 'ApiProperties@application_information');  //application info
    Route::post('/property/myproperty_list', 'ApiProperties@my_properties');  //my_properties list
    Route::post('/inspections', 'ApiProperties@inspection_list');  //job list
    Route::post('/inspections/create', 'ApiProperties@inspection_create');  //property inspect dates
    Route::post('/inspections/status', 'ApiProperties@inspection_status');  //property inspect delete ,cancel archive ,mute
    Route::post('/inspections/message', 'ApiProperties@inspections_message');  //inspections message
    Route::post('/inspections/allmessage', 'ApiProperties@inspection_message_list');  //inpection message
    Route::post('/inspections/info','ApiProperties@inspection_information');  //inpection info
    Route::post('/job/status', 'ApiProperties@job_status');  //job cancel delete archive mute
    Route::post('/explore', 'ApiProperties@explore_property');  //job cancel delete archive mute
    Route::post('/property/searchlist', 'ApiProperties@search_list');  //search list
    Route::post('/property/search', 'ApiProperties@search');  //search
    Route::post('/property/details', 'ApiProperties@property_details'); // property details
    Route::post('/property/typelist', 'ApiProperties@property_type_list');  //job cancel delete archive mute
    Route::post('/property/nearby', 'ApiProperties@nearby_distance');  //nearby
    Route::post('/property/dropdown_search','ApiProperties@property_dropdown');  //all_property_serach
    Route::post('/property/myproperty','ApiProperties@my_properties_for_dropdown');  //all_property_serach
    Route::post('/property/maintenance','ApiProperties@property_maintenance');  //property_maintenance
    Route::post('/property/rental_info','ApiProperties@rental_info');  //rental info
});
Route::post('/property/create', 'ApiProperties@create_property'); // property  list
Route::post('/agents/create', 'ApiProperties@create_agents'); // agents  list
Route::get('/property/type', 'ApiProperties@propery_type_get'); // property types dropdown  list
Route::get('/search/param', 'ApiProperties@get_search_parameter'); // get srach parameter
