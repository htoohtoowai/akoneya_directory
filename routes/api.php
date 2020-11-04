<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'localization','namespace'=>'API'], function () {

    Route::get('categories','CategoryController@getCategoryList');
    Route::get('categories/{id}/subCategories','SubCategoryController@getSubCategoryList');
	Route::get('subcategories/{subCategoryId}/services', 'ServiceController@getServiceList');
    Route::get('zones', 'ZoneController@getZoneList');
	Route::get('zones/{zoneId}/townships', 'TownshipController@getByZoneId');


});