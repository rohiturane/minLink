<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeWebhookController;
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
Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handleWebhook']);
Route::get('auth/google', [SocialController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth'],'prefix'=>'admin'], function () {
    // Account Page
    Route::get('/dashboard', [HomeController::class,'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile',[AuthController::class,'profile']);
    Route::post('/profile/store', [AuthController::class, 'profileStore']);

    Route::get('/plans',[SubscriptionController::class, 'plans']);
    Route::get('/plan/{package}',[SubscriptionController::class, 'selectPlan']);
    Route::get('/cancel-plan', [SubscriptionController::class, 'cancelPlan']);
    
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

    // Domain
    Route::get('/domains',[DomainController::class, 'index']);
    Route::get('/domain/create',[DomainController::class, 'create']);
    Route::post('/domain/store',[DomainController::class, 'store']);
    Route::get('/domain/{uuid}/edit',[DomainController::class, 'edit']);
    Route::post('/domain/{uuid}/update',[DomainController::class, 'update']);
    Route::get('/domain/{uuid}/delete',[DomainController::class, 'delete']);


    // User
    Route::get('/users',[UserController::class, 'index']);
    Route::get('/user/create',[UserController::class, 'create']);
    Route::post('/user/store',[UserController::class, 'store']);
    Route::get('/user/{id}/edit',[UserController::class, 'edit']);
    Route::post('/user/{id}/update',[UserController::class, 'update']);
    Route::get('/user/{id}/delete',[UserController::class, 'delete']);

    // Links
    Route::get('/links',[LinkController::class, 'index']);
    Route::get('/link/create',[LinkController::class, 'create']);
    Route::post('/link/store',[LinkController::class, 'store']);
    Route::get('/link/{uuid}/edit',[LinkController::class, 'edit']);
    Route::post('/link/{uuid}/update',[LinkController::class, 'update']);
    Route::get('/link/{uuid}/delete',[LinkController::class, 'delete']);

    Route::get('/link/{link}/analytics', [LinkController::class, 'analytics']);
    Route::get('/link/{link}/preview', [LinkController::class, 'preview']);

    Route::get('/razorpay',[RazorPayController::class, 'index']);
    Route::post('/transaction-success',[RazorPayController::class, 'handlePayment']);
    Route::post('/transaction-failed',[RazorPayController::class, 'handleFailure']);
    Route::get('/transactions',[TransactionController::class,'index']);
    Route::get('/transaction/{uuid}/view',[TransactionController::class, 'view']);


});

Route::any('{code}', [LinkController::class, 'visit'])->where('all', '.*');
Route::get('{code}/qr', [LinkController::class,'qr'])->where('all', '.*');