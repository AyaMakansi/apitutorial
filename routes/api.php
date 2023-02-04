<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Auth;

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
Route::group(['middleware' => ['api','checkPassword','changeLanguage'],'namespace'=>'Api'],function(){
    Route::post('get-main-categories', [CategoriesController::class, 'index']);
    Route::post('get-main-category-byId', [CategoriesController::class, 'getCategorybyId']);
    Route::post('change-category-status', [CategoriesController::class, 'changestatus']);
   Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout',[AuthController::class,'logout'])->middleware('auth.guard:api_admin');
   });
    
   Route::group(['prefix'=>'user','middleware'=>'auth.guard:api_user'],function(){
    Route::post('userprofile',function(){return Auth::user();});
    
    
   });

   Route::group(['prefix'=>'user','namespace'=>'User'],function(){
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout',[UserController::class,'logout'])->middleware('auth.guard:api_user');
   });
});

Route::group(['middleware' => ['api','checkPassword','changeLanguage','checkAdmintoken:api_admin']],function(){
    Route::get('offers', [CategoriesController::class, 'index']);
    
});

