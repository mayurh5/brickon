<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CertifiactesController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactUsController;

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

Auth::routes(['verify' => true]);

// dashboard Routes
// Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('verified');
Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard');



Route::group(['namespace'=>'admin'], function () {

  Route::group(['prefix' => 'leads', 'namespace'=>'leads', 'as'=>'leads.'], function () {

    Route::get('/', [LeadsController::class, 'index'])->name('index');
    Route::get('/create', [LeadsController::class, 'create'])->name('create');
    Route::get('/view', [LeadsController::class, 'view'])->name('view');


  });

  Route::group(['prefix' => 'users', 'namespace'=>'users', 'as'=>'users.'], function () {

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::get('/view', [UserController::class, 'view'])->name('view');


  });

  Route::group(['prefix' => 'certifiactes', 'namespace'=>'certifiactes', 'as'=>'certifiactes.'], function () {

    Route::get('/', [CertifiactesController::class, 'index'])->name('index');
    Route::get('/create', [CertifiactesController::class, 'create'])->name('create');
    Route::post('/store', [CertifiactesController::class, 'store'])->name('store');
    Route::post('/list', [CertifiactesController::class, 'certificate_list_json']);

  });

  Route::group(['prefix' => 'distributor', 'namespace'=>'distributor', 'as'=>'distributor.'], function () {

    Route::get('/', [DistributorController::class, 'index'])->name('index');
    Route::get('/create', [DistributorController::class, 'create'])->name('create');

  });

  Route::group(['prefix' => 'banner', 'namespace'=>'banner', 'as'=>'banner.'], function () {

    Route::get('/', [BannerController::class, 'index'])->name('index');
    Route::get('/create', [BannerController::class, 'create'])->name('create');

  });

  Route::group(['prefix' => 'product', 'namespace'=>'product', 'as'=>'product.'], function () {

    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [ProductController::class, 'create'])->name('create');
    Route::post('/store/{id?}', [ProductController::class, 'store'])->name('store');
    Route::post('/list', [ProductController::class, 'productListJson'])->name('productListJson');

  });

  Route::group(['prefix' => 'application', 'namespace'=>'application', 'as'=>'application.'], function () {

    Route::get('/', [ApplicationController::class, 'index'])->name('index');
    Route::get('/create', [ApplicationController::class, 'create'])->name('create');

  });

  Route::group(['prefix' => 'setting', 'namespace'=>'setting', 'as'=>'setting.'], function () {

    Route::get('/', [SettingController::class, 'index'])->name('index');

  });

  Route::group(['prefix' => 'contact_us', 'namespace'=>'contact_us', 'as'=>'contact_us.'], function () {

    Route::get('/', [ContactUsController::class, 'index'])->name('index');

  });



});
