<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; //inisialisasi

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('relasi-1', function() {
    $member = App\Models\TransactionSale::where('id','=','1')->first();
    // foreach ($member->transaction_sale_details as $temp) {
    //     # code...
    //     echo '<li>Nama :'.$temp->product_id.'</li>';
    // }
    return $member->transaction_sale_details->id;
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('transactionSaleDetails', App\Http\Controllers\TransactionSaleDetailController::class);

Route::resource('transactionSales', App\Http\Controllers\TransactionSaleController::class);
Route::get('api/transactionSales', [App\Http\Controllers\TransactionSaleController::class, 'api']);
Route::get('/detailsProduct', [App\Http\Controllers\TransactionSaleController::class, 'detailsProduct']);
Route::get('/selectProduct', [App\Http\Controllers\TransactionSaleController::class, 'selectProduct']);
Route::get('/product/{id}', [App\Http\Controllers\TransactionSaleController::class, 'getProduct']);


Route::get('api/transactionsaleDetails', [App\Http\Controllers\TransactionSaleDetailController::class, 'api']);

Route::resource('transactionSuppliers', App\Http\Controllers\TransactionSupplierController::class);
Route::get('api/transactionSuppliers', [App\Http\Controllers\TransactionSupplierController::class, 'api']);
Route::get('api/transactionsupplierdetails', [App\Http\Controllers\TransactionSupplierDetailController::class, 'api']);

Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::get('api/categories', [App\Http\Controllers\CategoryController::class, 'api']);

Route::resource('members', App\Http\Controllers\MemberController::class);
Route::get('api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::resource('officers', App\Http\Controllers\OfficerController::class);
Route::get('api/officers', [App\Http\Controllers\OfficerController::class, 'api']);

Route::resource('products', App\Http\Controllers\ProductController::class);
Route::get('api/products', [App\Http\Controllers\ProductController::class, 'api']);

Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
Route::get('api/suppliers', [App\Http\Controllers\SupplierController::class, 'api']);
