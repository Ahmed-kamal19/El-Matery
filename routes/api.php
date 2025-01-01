<?php

use App\Http\Controllers\Api\AdsController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\citiyController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\CalculatorController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;

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
Route::group(['middleware' => ['json.response']], function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/register', 'Api\Auth\AuthController@register');
    Route::post('/login', 'Api\Auth\AuthController@login');
    Route::post('/send-otp', 'Api\Auth\ForgetPasswordController@sendOtp');
     Route::post('/resend-otp', 'Api\Auth\ForgetPasswordController@resendOtp');
    Route::post('/reset-password', 'Api\Auth\ForgetPasswordController@resetPassword');
    Route::post('/verify-otp', 'Api\Auth\VerificationController@verifyOtp');
    Route::get('/act_mod', 'Api\UserController@act_mod');
    Route::post('/resend-otp-order', [FinanceController::class, 'resendOtp']);

     Route::group(['middleware' => 'auth:sanctum'], function () {
        // Route::post('/resend-otp', 'Api\Auth\VerificationController@resendOtp');
        Route::post('/logout', 'Api\Auth\AuthController@logout');
        Route::post('/add-Your-addss', [AdsController::class, 'store']);
        Route::delete('/addss/delete/{id}', 'Api\UserController@destroy');
        Route::get('/addss/edit/{id}', 'Api\UserController@edit');
        Route::get('/notification','Api\UserController@notification');
        Route::get('/changestatuenotificaton','Api\UserController@changestatue');

        Route::post('/addss/update/{id}', 'Api\UserController@update');

        Route::get('/profile', 'Api\UserController@profile');
        Route::post('/update-profile', 'Api\UserController@updateProfile');
        Route::post('/change-password', 'Api\UserController@changPassword');
        Route::get('/addss', [UserController::class,'ads']);
        Route::post('/update-status/{id}', 'Api\UserController@updateAdsShowInHomePage');
        Route::get('/filter-addss', 'Api\UserController@filter');
        Route::post('/add-favorite-withauth', 'Api\FavoriteController@store');
        Route::get('/requests_auth','Api\RequestController@index')->name('get-requests');
        Route::post('/finance-Order', [FinanceController::class, 'financeOrder'])->name('finance.order');
        Route::post('/favorite-auth', 'Api\UserController@favorite');

    });
    Route::post('/favorite-withoutauth', 'Api\UserController@favorite');
    Route::post('/add-favorite-withoutauth', 'Api\FavoriteController@store');

    // ------------------------- Home ---------------------------------------

    Route::get('/models', 'Api\HomeController@models');
    Route::get('/cars', 'Api\HomeController@cars');
    Route::get('/brands', 'Api\HomeController@brands');
    Route::get('/questions', 'Api\HomeController@questions');
    Route::get('/getAllData', 'Api\HomeController@getAllData');
    Route::get('/banks',[BankController::class,'index']);
    Route::get('/brand/{id}', 'Api\HomeController@carsbrand');
    Route::get('/brands-search',[HomeController::class,'brandsSearch']);
    Route::get('/advanced-search-selects/{id}/{step}',[CarController::class,'advancedSelect']);
    Route::get('/advanced-select-search/{modelId}',[CarController::class,'advancedSelect2']);
    Route::get('/why-code-car', 'Api\HomeController@why_code_car');
    Route::get('/financing-advantage', 'Api\HomeController@financing_advantage');
    Route::get('/financing-body', 'Api\HomeController@financing_bodies');
    Route::get('/models-search/{brandId}',[HomeController::class,'modelsSearch']);
    Route::get('/normal-search',[HomeController::class,'normalSearch']);
    Route::get('/latest-models',[HomeController::class,'latestModel']);
    Route::get('/exclusive-offers',[HomeController::class,'exclusiveOffers']);
    Route::post('/advanced-search',[HomeController::class,'advancedSearchCar']);
    Route::get('/getAllCars',[HomeController::class,'getAllCars']);
    Route::get('/getColorsWithPrice/{car}',[HomeController::class,'getColorsWithPrice']);
    // Route::post('/car/search', 'Api\HomeController@carSearch');
    // ----------------------- colors filter ---------------------------
    Route::get('/cars/{car}/colors/{color}',[CarController::class,'getColorImages']);
    // ----------------------- Settings --------------------------------
    Route::get('/calc_data', 'Api\HomeController@act_mod');
    Route::get('/partners', 'Api\PartnerController@index');

    Route::get('/footer', 'Api\SettingController@footer');
    Route::get('/finance', 'Api\SettingController@finance');
    Route::get('/social', 'Api\SettingController@social');
    Route::get('/cars-news', 'Api\SettingController@cars_news');
    Route::get('/contact-us', 'Api\SettingController@contact_us');
    Route::get('/about', 'Api\SettingController@about');
    Route::get('/filter_count', 'Api\SettingController@filter_count');

    Route::get('/offer', 'Api\SettingController@offer');
    Route::get('/setting', 'Api\SettingController@setting');
    Route::get('/terms-condition-privacy', 'Api\SettingController@termsCondition');
    Route::get('/settings', 'Api\SettingController@setting');
    Route::get('/allsettings', 'Api\SettingController@AllDescription');
    Route::get('/cashing', 'Api\SettingController@cach');


    //  -------------------- Career -----------------------
    Route::group([
        'prefix' => 'career'
    ], function ($router) {
        Route::get('/', 'Api\CareerController@index');
        Route::post('/store/{career_id}', 'Api\CareerController@store');
    });
    // -------------------------- Subscriber ----------------------------
    Route::post('/subscriber/store', 'Api\SubscriberController@store');
    // -------------------------- News --------------------------------
    Route::get('/news/{id}', 'Api\NewsController@show');
    Route::get('/news', 'Api\NewsController@index');


    // -------------------------------------------------------

    Route::get('/careers', 'Api\CareerController@index');
    Route::get('/cars', [CarController::class, 'carsdetails']);
    Route::get('/car-option', [CarController::class, 'CarOption']);

    Route::get('/car/{id}', [CarController::class, 'cardetails']);

    Route::post('/contact', [ContactController::class, 'contact']);
    Route::get('/car-model', [CarController::class, 'carmodel']);

    // Route::post('/add-Your-Ad', [AdsController::class, 'store']);
    // Route::post('/add-Your-Ad/{step}', [AdsController::class, 'store']);

    // Route::post('/send-otp', [FinanceController::class, 'sendOtp']);
    Route::post('/verify-otp-order', [FinanceController::class, 'verifyOtp']);
    // Route::post('/cash-Order', [FinanceController::class, 'sendOtp']);
    Route::post('/cash-Order', [FinanceController::class, 'validationcash']);
    Route::post('/financecar-Order', [FinanceController::class, 'validationfinance']);



    Route::get('/cities', [citiyController::class, 'index']);



     // -----------------------services----------------------
     Route::get('/services',[ServiceController::class,'index']);
     Route::get('/services/{service}',[ServiceController::class,'show']);
     Route::get('/similar-services/{service}',[ServiceController::class,'similarService']);
     Route::get('/service-city',[ServiceController::class,'revieveCity']);

   //--------------------------------------------------------------
    // ----------------------- Offer ----------------------
    Route::get('/offer/show/{id}', 'Api\OfferController@show');
    Route::get('/offers', 'Api\OfferController@index');
    // --------------------------------
    Route::get('/best-selling-cars', [CarController::class, 'BestSellingCars']);
    Route::get('/cars-biggest-discount', [CarController::class, 'carsWithBiggestDiscount']);
    Route::get('/current-year', [CarController::class, 'currentyear']);
    Route::get('/filter', [CarController::class, 'filter']);
    Route::get('/filterData',[CarController::class,'filterGetApi']);
    //  -------------------------------------------
    Route::post('/search', [SearchController::class, 'search']);
    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::get('/car-type', [CarController::class, 'cartype']);
 
    Route::get('/prices', [CarController::class, 'prices']);
    Route::get('/search-car-prices', [CarController::class, 'searchCar']);


    
    Route::get('/calculator',[CalculatorController::class,'index'])->name('calculator');
    Route::post('/amount-calculator',[CalculatorController::class,'calculate'])->name('amount-calculator');
    Route::post('/calculate-installments',[CalculatorController::class,'calculateInstallmentss'])->name('calculateInstallments');
    Route::get('/order/all',[OrderController::class,'index']);



    Route::post('/individuals-finance',[OrderController::class,'individualsFinance'])->name('individualsFinance');
    Route::post('/individuals-cash',[OrderController::class,'individualsCash'])->name('individualsCash');
    Route::post('/company-finance',[OrderController::class,'companyFinance'])->name('companyFinance');
    Route::post('/company-cash',[OrderController::class,'companyCash'])->name('companyCash');


    // Route::get('/requests','Api\RequestController@index')->name('get-requests');
    Route::get('/requests-search','Api\RequestController@search');
    Route::post('/find','Api\financecalc@encry');

    Route::get('/requests','Api\RequestController@index')->name('get-requests-without-auth');
    Route::post('/finance-Order', [FinanceController::class, 'financeOrder'])->name('finance.order2');

});



Route::get('/search',function(Request $request){
     
    
});