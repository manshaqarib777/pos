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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});






    Route::post('login', 'APIController@login');
    Route::post('forgot', 'APIController@forgot');
    Route::post('social_login', 'APIController@social_login');
    Route::get('countries', 'APIController@countries');
    Route::get('states/{id}', 'APIController@states');
    Route::get('substates/{id}', 'APIController@substates');
    Route::get('cities/{id}', 'APIController@cities');
    Route::post('register', 'APIController@register');
    Route::get('faq','APIController@faq');
    Route::get('about','APIController@about');
    Route::get('searchcars','APIController@search_cars');
    Route::get('get_cars_across_category','APIController@get_cars_across_category');
    Route::get('expertreview','APIController@expert_review');
    Route::get('view_car','APIController@view_car');
    Route::post('blogcategory','APIController@blogcategory');

    Route::get('getreviews/{id}', 'APIController@getreviews');
    Route::get('getsubcategories/{id}','APIController@getsubcategories');
    Route::get('getallinpectors','APIController@getallinpectors');
    Route::get('getsingleinpector/{id}','APIController@getsingleinpector');
    Route::post('sendmailtoinspector','APIController@sendmailtoinspector');


    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/logout', 'APIController@logout');
        Route::get('/contacts', 'APIController@get');
        Route::get('/conversation/{id}', 'APIController@getMessagesFor');
        Route::post('/conversation/send', 'APIController@send');
        Route::post('postreview/{id}', 'APIController@postreview');
        Route::get('profile','APIController@profile');
        Route::get('car-detail','APIController@car_detail');
        Route::get('all/cars','APIController@all_cars');
        Route::get('featured/cars','APIController@featured');
        Route::get('package','APIController@package');
        Route::post('add_car','APIController@add_car');
        Route::post('changecarstatus','APIController@change_car_status');
        Route::post('edit_car','APIController@edit_car');
        Route::post('update_car','APIController@update_car');
        Route::post('updateprofile','APIController@update_profile');
    });
