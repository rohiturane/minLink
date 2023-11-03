<?php

use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\SEOController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

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

// Youtube Route
Route::get('/youtube-trends',[YoutubeController::class,'getTrends']);
Route::get('/youtube-extract-tags', [YoutubeController::class,'extractTags']);
Route::get('/youtube-generate-tags',[YoutubeController::class,'generateTags']);
Route::get('/youtube-extract-hashtag',[YoutubeController::class,'extractHashtag']);
Route::get('/youtube-generate-hashtag',[YoutubeController::class,'generateHashtag']);
Route::get('/youtube-extract-title',[YoutubeController::class,'extractVideoTitle']);
Route::get('/youtube-generate-video-title',[YoutubeController::class,'generateVideoTitle']);
Route::get('/youtube-extract-description',[YoutubeController::class,'extractVideoDecription']);
Route::get('/youtube-embed-video',[YoutubeController::class,'makeEmbedVideo']);
Route::get('/youtube-channel-id',[YoutubeController::class, 'extractChannelId']);
Route::get('/youtube-video-statistics',[YoutubeController::class,'getVideoStatistics']);
Route::get('/youtube-channel-statistics', [YoutubeController::class,'getChannelStatistics']);
Route::get('/youtube-logo-download',[YoutubeController::class,'getChannelLogo']);
Route::get('/youtube-banner-download',[YoutubeController::class,'getChannelBanner']);
Route::get('/youtube-money-calculator',[YoutubeController::class, 'moneyCalculator']);
Route::get('/youtube-channel-search',[YoutubeController::class,'searchChannel']);

// SEO Routes
Route::get('/google-page-speed', [SEOController::class, 'googlePageSpeed']);
Route::get('/robot-txt-generator',[SEOController::class, 'robotTxtGenerator']);
Route::get('/google-index-checker',[SEOController::class, 'googleIndexChecker']);
Route::get('/google-cache-checker',[SEOController::class,'googleCacheChecker']);
Route::get('/domain-age-checker',[SEOController::class, 'domainAgeChecker']);
Route::get('/domain-lookup', [SEOController::class, 'domainLookup']);
Route::get('/keyword-density-checker', [SEOController::class, 'keywordDensityChecker']);
Route::get('/meta-tag-generator',[SEOController::class, 'metaTagsGenerator']);
Route::get('/meta-tag-checker',[SEOController::class,'metaTagsAnalyzer']);
Route::get('/open-graph-checker',[SEOController::class, 'openGraphChecker']);
Route::get('/open-graph-generator',[SEOController::class,'openGraphGenerator']);
Route::get('/keyword-suggestion',[SEOController::class, 'keywordSuggestionTool']);
Route::get('/adsence-calculator',[SEOController::class,'adsenceCalculator']);
Route::get('/privacy-policy-generator',[SEOController::class,'privacyPolicyGenerator']);
Route::get('/terms-of-service-generator',[SEOController::class,'termsOfServiceGenerator']);
Route::get('/lorem-ipsum-generator',[SEOController::class,'loremIpsumGenerator']);
Route::get('/gzip-enabled-checker',[SEOController::class,'gzipCompressionChecker']);
Route::get('/malware-checker', [SEOController::class, 'malwareChecker']);

// Image Routes
Route::any('/jpg-to-png-generator',[ImageController::class,'jpgToPngGenerator']);
Route::any('/jpg-to-webp-generator',[ImageController::class,'jpgToWebpGenerator']);
Route::any('/png-to-jpg-generator',[ImageController::class,'pngToJpgGenerator']);
Route::any('/png-to-webp-generator',[ImageController::class,'pngToWebpGenerator']);
Route::any('/webp-to-jpg-generator',[ImageController::class,'webpToJpgGenerator']);
Route::any('/webp-to-png-generator',[ImageController::class,'webpToPngGenerator']);
Route::any('/jpg-to-psd-generator',[ImageController::class,'jpgToPSDGenerator']);
Route::any('/png-to-psd-generator',[ImageController::class,'pngToPSDGenerator']);
Route::any('/image-compressor', [ImageController::class,'imageCompressor']);
Route::any('/image-resizer', [ImageController::class,'imageResizer']);
Route::any('/image-to-base64',[ImageController::class,'convertBase64']);


//Developer Routes
Route::any('/csv-to-json-converter', [DeveloperController::class, 'csvToJSONConverter']);
Route::any('/json-to-csv-converter', [DeveloperController::class, 'jsonTOCSVConverter']);
Route::any('/json-beautifier', [DeveloperController::class,'jsonBeautifier']);
Route::any('/json-validator', [DeveloperController::class, 'jsonValidation']);
Route::any('/html-minifier', [DeveloperController::class, 'htmlMinify']);
Route::any('/css-minifier', [DeveloperController::class, 'cssMinify']);
Route::any('/js-minifier', [DeveloperController::class, 'jsMinify']);
Route::get('/password-generator', [DeveloperController::class, 'passwordGenerator']);
Route::get('/md5-generator', [DeveloperController::class, 'md5Generator']);
Route::get('/sha-generator',[DeveloperController::class, 'shaGenerator']);
Route::get('/bcrypt-generator', [DeveloperController::class,'bcryptGenerator']);
Route::get('/hash-generator',[DeveloperController::class,'hashGenerator']);

Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy']);
Route::get('/terms-of-service',[HomeController::class, 'termsService']);
Route::get('/contact-us',[HomeController::class, 'contactUs']);

// Subscription
Route::post('/auth/add-subscription', [HomeController::class, 'addSubscription']);

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/auth/authenicate/user', [AuthController::class,'authenicate']);
Route::get('/register', [AuthController::class,'register']);
Route::post('/auth/register/user', [AuthController::class, 'registerUser']);
Route::post('/logout', [AuthController::class,'logout']);

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    // Account Page
    Route::get('/dashboard', [HomeController::class,'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // blog
    Route::get('/posts',[BlogController::class, 'index']);
    Route::get('/post/create', [BlogController::class, 'create']);

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
});