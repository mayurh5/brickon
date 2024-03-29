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
use App\Http\Controllers\Admin\RoleRightController;
use App\Http\Controllers\Auth\LoginController;

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

// Auth::routes(['verify' => true]);
Route::get('/login', [LoginController::class, 'show_login_form'])->name('show_login_form');
Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::middleware(['auth'])->group(function () {

  Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

  Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard');

Route::group(['namespace'=>'admin'], function () {

  Route::group(['prefix' => 'leads', 'namespace'=>'leads', 'as'=>'leads.'], function () {

    Route::get('/', [LeadsController::class, 'index'])->name('index');
    Route::get('/create', [LeadsController::class, 'create'])->name('create');
    Route::get('/view/{id?}', [LeadsController::class, 'view'])->name('view');
    Route::post('/list', [LeadsController::class, 'get_lead_list_json'])->name('get_lead_list_json');
    Route::post('/status/update', [LeadsController::class, 'status_update'])->name('status_update');


  });

  Route::group(['prefix' => 'users', 'namespace'=>'users', 'as'=>'users.'], function () {

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [UserController::class, 'create'])->name('create');
    Route::get('/view/{id?}', [UserController::class, 'view'])->name('view');
    Route::post('/list', [UserController::class, 'user_json_list']);
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::post('/web_user_json_list', [UserController::class, 'web_user_json_list']);
    Route::get('/change_password', [UserController::class, 'change_password'])->name('change_password');
    Route::POST('/admin_change_password', [UserController::class, 'admin_change_password'])->name('admin_change_password');


  });

  Route::group(['prefix' => 'certifiactes', 'namespace'=>'certifiactes', 'as'=>'certifiactes.'], function () {

    Route::get('/', [CertifiactesController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [CertifiactesController::class, 'create'])->name('create');
    Route::post('/store/{id?}', [CertifiactesController::class, 'store'])->name('store');
    Route::post('/list', [CertifiactesController::class, 'certificate_list_json']);
    Route::post('/status/update', [CertifiactesController::class, 'status_update_doc']);

  });

  Route::group(['prefix' => 'distributor', 'namespace'=>'distributor', 'as'=>'distributor.'], function () {

    Route::get('/', [DistributorController::class, 'index'])->name('index');
    Route::get('/create', [DistributorController::class, 'create'])->name('create');

  });

  Route::group(['prefix' => 'banner', 'namespace'=>'banner', 'as'=>'banner.'], function () {

    Route::get('/', [BannerController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [BannerController::class, 'create'])->name('create');
    Route::post('/store/{id?}', [BannerController::class, 'store'])->name('store');
    Route::post('/list', [BannerController::class, 'banner_list_json']);

  });

  Route::group(['prefix' => 'product', 'namespace'=>'product', 'as'=>'product.'], function () {

    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [ProductController::class, 'create'])->name('create');
    Route::post('/store/{id?}', [ProductController::class, 'store'])->name('store');
    Route::post('/list', [ProductController::class, 'productListJson'])->name('productListJson');

  });

  Route::group(['prefix' => 'application', 'namespace'=>'application', 'as'=>'application.'], function () {

    Route::get('/', [ApplicationController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [ApplicationController::class, 'create'])->name('create');
    Route::post('/store/{id?}', [ApplicationController::class, 'store'])->name('store');
    Route::post('/list', [ApplicationController::class, 'application_list_json'])->name('application_list_json');


  });

  Route::group(['prefix' => 'setting', 'namespace'=>'setting', 'as'=>'setting.'], function () {

    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('update/', [SettingController::class, 'update'])->name('update');

  });

  Route::group(['prefix' => 'contact_us', 'namespace'=>'contact_us', 'as'=>'contact_us.'], function () {

    Route::get('/', [ContactUsController::class, 'index'])->name('index');
    Route::post('update/', [ContactUsController::class, 'update'])->name('update');

  });

  Route::group(['prefix' => 'roles', 'namespace'=>'roles', 'as'=>'roles.'], function () {

    Route::get('/', [RoleRightController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [RoleRightController::class, 'create'])->name('create');
    // Route::post('update/', [RoleRightController::class, 'update'])->name('update');
    Route::post('/get_right_list', [RoleRightController::class,'get_right_list']);
    Route::post('/store', [RoleRightController::class,'store'])->name('store');
    Route::post('/get_role_list_json', [RoleRightController::class,'get_role_list_json'])->name('get_role_list_json');
    Route::get('/status/update', [RoleRightController::class,'change_status']);

  });



});

});


