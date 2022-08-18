<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/request_loan', 'RequestLoanController@requestLoan'); // this API is used to create loan request
Route::get('/get_all_loans', 'RequestLoanController@getAllLoans'); // this is used for admin view the loan request with payment rescheduled
Route::post('/take_action', 'RequestLoanController@takeAction'); // this is used for admin take action against each loan token number
Route::post('/get_own_loans', 'RequestLoanController@getOwnLoans'); // this is used for customer can view own loan by providing the loan token number
Route::post('/payLoanAmount', 'RequestLoanController@payLoanAmount'); // this is used for customer can pay loan amount of scheduled weekly loan by providing token number , amount and due date.
