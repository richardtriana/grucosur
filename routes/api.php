<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HeadquarterController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\MainBoxController;
use App\Http\Controllers\PrintTicketController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\TypeExpenseController;
use App\Http\Controllers\UserController;
use App\Models\Company;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::resource('/boxes',  BoxController::class);

Route::resource('/clients',  ClientController::class);
Route::post('/clients/{client}/change-status',  [ClientController::class, 'changeStatus']);
Route::get('/clients/{client}/credits', [ClientController::class, 'credits']);
Route::post('/clients/filter-client-list',  [ClientController::class, 'filterClientList']);

Route::resource('/configurations', CompanyController::class);
Route::get('/company-logo', function () {
	$configuration = new Company();
	$image = $configuration->select('logo')->first();
	return $image;
});

Route::get('/credits/amortization-table', [InstallmentController::class, 'printTable']);
Route::post('/credits/pay-credit-installments/{id}', [CreditController::class, 'payMultipleInstallments']);
Route::resource('/credits', CreditController::class);
Route::post('/credits/{credit}/change-status',  [CreditController::class, 'changeStatus']);
Route::get('/credits/{credit}/installments', [CreditController::class, 'installments']);

Route::resource('/expenses',  ExpenseController::class);
Route::post('/expenses/{expense}/change-status',  [ExpenseController::class, 'changeStatus']);

Route::get('/headquarters/list-all-headquarters',  [HeadquarterController::class, 'listAllHeadquarters']);
Route::get('/headquarters/list-headquarter',  [HeadquarterController::class, 'listHeadquarter']);
Route::resource('/headquarters',  HeadquarterController::class);
Route::post('/headquarters/{headquarter}/change-status',  [HeadquarterController::class, 'changeStatus']);

Route::get('/installments/calculate-installments', [InstallmentController::class, 'calculateInstallments']);
Route::resource('/installments', InstallmentController::class);
Route::post('/installment/{id}/pay-installment', [InstallmentController::class, 'payInstallment']);

Route::get('/main-box/current-balance', [MainBoxController::class, 'currentBalance']);
Route::resource('/main-box',  MainBoxController::class);

Route::resource('/providers',  ProviderController::class);
Route::post('/providers/{provider}/change-status',  [ProviderController::class, 'changeStatus']);
Route::post('/providers/filter-provider-list',  [ProviderController::class, 'filterProviderList']);

Route::get('/print-installment', [PrintTicketController::class, 'printInstallment']);

Route::resource('/type-expenses',  TypeExpenseController::class);

Route::resource('/users',  UserController::class);
Route::post('/users/{user}/change-status',  [UserController::class, 'changeStatus']);
