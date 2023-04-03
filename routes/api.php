<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\API\DocumentController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\DistributorController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {

    Route::group(['prefix' => 'v1', 'namespace' => 'App'], function () {

      Route::post('/send_otp', [UserController::class, 'send_otp']);
      Route::post('/verify_otp', [UserController::class, 'verify_otp']);
      Route::post('/register', [UserController::class, 'register']);
      Route::post('/login', [UserController::class, 'login']);

      // set auth token apis now

      Route::post('logout', [UserController::class, 'logout']);

      Route::post('get_user_details_by_id', [UserController::class, 'get_user_details_by_id']);
      Route::post('update_user_details_by_id', [UserController::class, 'update_user_details_by_id']);
      Route::get('get_contact_us', [UserController::class, 'get_contact_us']);

      Route::post('get_kyc_details', [UserController::class, 'get_kyc_details']);
      Route::post('update_kyc_details', [UserController::class, 'update_kyc_details']);

      Route::post('store_lead', [LeadController::class, 'store_lead']);
      Route::post('get_lead_list_by_user', [LeadController::class, 'get_lead_list_by_user']);
      Route::post('get_lead_detail_by_lead_id', [LeadController::class, 'get_lead_detail_by_lead_id']);
      Route::post('get_product_list', [LeadController::class, 'get_product_list']);

      Route::get('get_documnent_type', [DocumentController::class, 'get_documnent_type']);
      Route::post('get_document_list_by_type', [DocumentController::class, 'get_document_list_by_type']);

      Route::get('get_cms_pages', [SettingController::class, 'get_cms_pages']);

      Route::get('store_feedback', [FeedbackController::class, 'store_feedback']);
      Route::post('get_feedback_details', [FeedbackController::class, 'get_feedback_details']);

      Route::get('get_distributor_list', [DistributorController::class, 'get_distributor_list']);


    });

});
