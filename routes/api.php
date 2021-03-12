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
    Route::group(['prefix' => 'v1.0'], function () {
        // Route::group(['middleware' => 'check.api.key'], function () {
            Route::get('categories', 'CategoryController@getCategoryList');
            Route::get('categories/{id}/subCategories', 'SubCategoryController@getSubCategoryList');
            Route::get('subcategories/{subCategoryId}/services', 'ServiceController@getServiceList');
            Route::get('zones', 'ZoneController@getZoneList');
            Route::get('zones/{zoneId}/townships', 'TownshipController@getByZoneId');
            Route::get('holidays', 'HolidayController@getHolidays');
            Route::get('postalCodes', 'PostalCodeController@getPostalCodes');

            Route::group(['prefix' => 'travelBlogs'], function () {
                Route::get('/', 'TravelBlogController@getTravelBlogList');
                Route::get('/{id}', 'TravelBlogController@getDetail');
            });
            
            Route::group(['middleware' => 'authenticate.to.uaa'], function () {
                Route::group(['prefix' => 'savedTravelBlog'], function () {
                    Route::get('/', 'SavedBlogController@getSavedBlogList');
                    Route::delete('/{travelBlogId}', 'SavedBlogController@deleteSavedBlog');
                });
                Route::get('travelBlogs/{id}/save', 'SavedBlogController@saveBlog');

                Route::group(['prefix' => 'foodBlogs'], function () {
                    Route::get('{id}/save', 'SavedFoodBlogController@saveFoodBlog');
                });
                

            });

           


            Route::get('foodBlogs/categories', 'FoodBlogCategory@getAllCategories');
        });

        // Route::group(['middleware' => 'authenticate.to.uaa'], function () {
        //     Route::group(['prefix' => 'foodBlogs'], function () {
        //         Route::get('/', 'FoodBlogController@getFoodBlogList');
        //         Route::get('{id}/save', 'SavedFoodBlogController@saveFoodBlog');
        //     });
        // });
    // });
});
