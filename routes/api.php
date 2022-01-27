<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\AdminLoanController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//user Route
Route::group(['middleware' => ['auth:api', 'user_accessible']], function () {
    Route::post('next-loan-payments', [LoanController::class, 'nextLoanPayments']);
    Route::post('pay-loan-payments', [LoanController::class, 'payLoanPayments']);
    Route::apiResource('loan', LoanController::class, ['except' => ['create','edit','update','destroy']]);
});

//admin route
Route::group(['middleware' => ['auth:api', 'admin_accessible']], function () {
    Route::get('admin-loan', [AdminLoanController::class, 'index']);
    Route::post('admin-loan/approval-loan', [AdminLoanController::class, 'approvalLoan']);
    Route::delete('admin-loan/delete/{id}', [AdminLoanController::class, 'destroy']);
});


