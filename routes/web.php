<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserInvoiceController;

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
    Route::get('/profile',[AuthController::class,'profile']);
    Route::post('/profile/store', [AuthController::class, 'profileStore']);
    
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

   
    Route::get('/permissions', [HomeController::class, 'permissions']);
    Route::post('/permissions/store', [HomeController::class, 'storePermissions']);

    //Project
    Route::get('/projects',[ProjectController::class, 'index']);
    Route::get('/project/create',[ProjectController::class, 'create']);
    Route::get('/project/{uuid}/edit',[ProjectController::class, 'edit']);
    Route::post('/project/store',[ProjectController::class,'store']);
    Route::post('/project/{uuid}/update',[ProjectController::class, 'update']);
    Route::get('/project/{uuid}/delete',[ProjectController::class, 'destory']);

    //License
    Route::get('/licenses',[LicenseController::class, 'index']);
    Route::get('/license/create',[LicenseController::class, 'create']);
    Route::get('/license/{uuid}/edit',[LicenseController::class, 'edit']);
    Route::post('/license/store',[LicenseController::class,'store']);
    Route::post('/license/{uuid}/update',[LicenseController::class, 'update']);
    Route::get('/license/{uuid}/delete',[LicenseController::class, 'destory']);

    Route::get('/razorpay',[RazorPayController::class, 'index']);
    Route::post('/transaction-success',[RazorPayController::class, 'handlePayment']);
    Route::post('/transaction-failed',[RazorPayController::class, 'handleFailure']);
    Route::get('/transactions',[TransactionController::class,'index']);
    Route::get('/transaction/{uuid}/view',[TransactionController::class, 'view']);
});