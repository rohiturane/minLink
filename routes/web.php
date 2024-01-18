<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SocialController;

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

Route::get('/', [HomeController::class,'index']);

Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy']);
Route::get('/terms-of-service',[HomeController::class, 'termsService']);
Route::get('/contact-us',[HomeController::class, 'contactUs']);

Route::get('/posts', [BlogController::class, 'frontendBlogList']);
Route::get('/post/{slug}', [BlogController::class, 'postDetails']);

// Subscription
Route::post('/auth/add-subscription', [HomeController::class, 'addSubscription']);

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/auth/authenicate/user', [AuthController::class,'authenicate']);
Route::get('/register', [AuthController::class,'register']);
Route::post('/auth/register/user', [AuthController::class, 'registerUser']);
Route::post('/logout', [AuthController::class,'logout']);

Route::get('auth/google', [SocialController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth']], function () {
    // Account Page
    Route::get('/dashboard', [HomeController::class,'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // blog
    Route::get('/posts',[BlogController::class, 'index']);
    Route::get('/post/create', [BlogController::class, 'create']);
    Route::post('/post/store',[BlogController::class,'store']);
    Route::get('/post/{id}/edit', [BlogController::class,'edit']);
    Route::post('/post/{id}/update', [BlogController::class,'update']);
    Route::get('/post/{id}/delete',[BlogController::class,'delete']);

    //setting
    Route::get('/setting', [HomeController::class, 'setting']);
    Route::post('/setting/store',[HomeController::class, 'settingStore']);

    // Page Information
    Route::get('/page_informations', [HomeController::class, 'pageMeta']);
    Route::get('/page_information/create', [HomeController::class, 'pageCreate']);
    Route::post('/page_information/store', [HomeController::class, 'pageSave']);
    Route::get('/page_information/{id}/edit', [HomeController::class, 'pageEdit']);
    Route::post('/page_information/{id}/update', [HomeController::class, 'pageUpdate']);
    Route::get('/page_information/{id}/delete', [HomeController::class,'pageDelete']);

    Route::get('/generate/sitemap',[HomeController::class,'generateSiteMap']);
    Route::get('/optimize-app', [HomeController::class, 'optimizeApplication']);

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoice/create', [InvoiceController::class, 'create']);
    Route::post('/invoice/store', [InvoiceController::class, 'store']);
    Route::get('/invoice/{uuid}/edit', [InvoiceController::class, 'edit']);
    Route::post('/invoice/{uuid}/update',[InvoiceController::class, 'update']);
    Route::get('/invoice/{uuid}/delete', [InvoiceController::class, 'destory']);

    Route::get('/permissions', [HomeController::class, 'permissions']);
    Route::post('/permissions/store', [HomeController::class, 'storePermissions']);


    Route::get('/businesses',[BusinessController::class, 'index']);
    Route::get('/business/create',[BusinessController::class,'create']);
    Route::post('/business/store', [BusinessController::class, 'store']);
    Route::get('/business/{uuid}/edit', [BusinessController::class, 'edit']);
    Route::post('/business/{uuid}/update', [BusinessController::class, 'update']);
    Route::get('/business/{uuid}/delete', [BusinessController::class, 'destory']);
});