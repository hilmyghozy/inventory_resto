<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin/blank', function () {
    return view('welcome');
});


Route::get('storage/{file}', function ($file) {
    return response()->file(storage_path('app/public/' . $file));
});

Route::get('/', 'Dashboard\overview@index');
Route::get('admin', 'Dashboard\overview@index');
Route::post('admin/data', 'Dashboard\overview@data');

Route::get('admin/login', 'Dashboard\login@index');
Route::post('admin/login/submit', 'Dashboard\login@submit');
Route::get('admin/session-flush', 'Dashboard\login@sessionFlush');

//User-config

Route::resource('menu', 'c_menu');
Route::resource('role', 'c_role');
Route::resource('user', 'c_UserManagement');

//Inventory-config
Route::resource('storehouse', 'c_storehouse');

Route::resource('supplier', 'c_supplier');

Route::get('/admin/inventory-config/unit', function () {
    return view('inventory-config.unit');
});
Route::get('/admin/inventory-config/raw_product', function () {
    return view('inventory-config.raw_product');
});
Route::get('/admin/inventory-config/half_product', function () {
    return view('inventory-config.half_product');
});
Route::get('/admin/inventory-config/half_product/half_detail', function () {
    return view('inventory-config.half_detail');
});
Route::get('/admin/inventory-config/recipe', function () {
    return view('inventory-config.recipe');
});
Route::get('/admin/inventory-config/recipe/recipe_detail', function () {
    return view('inventory-config.recipe_detail');
});
Route::get('/admin/inventory-config/banquette', function () {
    return view('inventory-config.banquette');
});

//Controller Store
Route::get('pos/store', 'POS_StoreController@index');
Route::get('pos/store/edit/{id}', 'POS_StoreController@edit');
Route::post('pos/store/add', 'POS_StoreController@add');
Route::post('pos/store/updateProcess', 'POS_StoreController@update');
Route::delete('pos/store/destroy/{id}', 'POS_StoreController@destroy');

//Controller kasir
Route::get('uc/user', 'POS_KasirController@index');
Route::get('uc/user/edit/{id}', 'POS_KasirController@edit');
Route::post('uc/user/add', 'POS_KasirController@create');
Route::post('uc/user/updateProcess', 'POS_KasirController@update');
Route::delete('uc/user/destroy/{id}', 'POS_KasirController@destroy');

//Controller Kategori
Route::get('pos/kategori', 'POS_ProductKategoriController@index');
Route::get('pos/kategori/edit/{id}', 'POS_ProductKategoriController@edit');
Route::post('pos/kategori/add', 'POS_ProductKategoriController@create');
Route::post('pos/kategori/updateProcess', 'POS_ProductKategoriController@update');
Route::delete('pos/kategori/destroy/{id}', 'POS_ProductKategoriController@destroy');
Route::get('pos/kategori/pagination/{id}', 'POS_ProductKategoriController@pagination');
// Route::get('pos/kategori', 'POS_ProductKategoriController@show');
Route::get('pos/kategori/table', 'POS_ProductKategoriController@table');

//Controller Item
Route::get('pos/item', 'POS_ProductItemController@index');
Route::get('pos/item/edit/{id}', 'POS_ProductItemController@edit');
Route::post('pos/item/add', 'POS_ProductItemController@create');
Route::post('pos/item/updateProcess', 'POS_ProductItemController@update');
Route::delete('pos/item/destroy/{id}', 'POS_ProductItemController@destroy');


//Controller Item
Route::get('pos/item-group', 'POS_ProductItemGroupController@index');
Route::get('pos/item-group/edit/{id}', 'POS_ProductItemGroupController@edit');
Route::post('pos/item-group/edit/{id}', 'POS_ProductItemGroupController@update');
Route::post('pos/item-group/add', 'POS_ProductItemGroupController@create');
Route::post('pos/item-group/updateProcess', 'POS_ProductItemGroupController@update');
Route::delete('pos/item-group/destroy/{id}', 'POS_ProductItemGroupController@destroy');

// Controller Paket
Route::get('pos/paket', 'POS_ProductPaketController@index');
Route::get('pos/paket/edit/{id}', 'POS_ProductPaketController@edit');
Route::post('pos/paket/edit/{id}', 'POS_ProductPaketController@update');
Route::get('pos/paket/kelola/{id}', 'POS_ProductPaketController@kelolaPaket');
Route::post('pos/paket/kelola/{id}/add-detail', 'POS_ProductPaketController@addPaketDetail');
Route::get('pos/paket/kelola/{id}/edit/{id_detail}', 'POS_ProductPaketController@editPaketDetail');
Route::post('pos/paket/kelola/{id}/edit/{id_detail}', 'POS_ProductPaketController@updatePaketDetail');
Route::delete('pos/paket/kelola/{id}/destroy/{id_detail}', 'POS_ProductPaketController@deletePaketDetail');


Route::get('pos/paket/edit/{id}', 'POS_ProductPaketController@edit');
Route::post('pos/paket/add', 'POS_ProductPaketController@create');
Route::post('pos/paket/updateProcess', 'POS_ProductPaketController@update');
Route::delete('pos/paket/destroy/{id}', 'POS_ProductPaketController@destroy');
Route::get('pos/paket/pagination/{id}', 'POS_ProductPaketController@pagination');

//Controller Stock I/O
Route::get('pos/product/stock', 'POS_ProductStockController@index');
Route::get('pos/product/stock/edit/{id}', 'POS_ProductStockController@edit');
Route::post('pos/product/stock/add', 'POS_ProductStockController@create');
Route::post('pos/product/stock/updateProcess', 'POS_ProductStockController@update');
Route::delete('pos/product/stock/destroy/{id}', 'POS_ProductStockController@destroy');

//Controller Payment
Route::get('pos/payment', 'POS_PaymentController@pos_payment');
Route::post('pos/payment/add', 'POS_PaymentController@add');
Route::delete('pos/payment/destroy/{id}', 'POS_PaymentController@destroy');
Route::get('pos/payment/edit/{id}', 'POS_PaymentController@edit');
Route::post('pos/payment/updateProcess', 'POS_PaymentController@update');
Route::get('pos/payment/delstorage/{id}', 'POS_PaymentController@deletestorage');

//Controller Diskon
Route::get('pos/discount', 'POS_DiscountController@index');
Route::post('pos/discount/add', 'POS_DiscountController@create');
Route::get('pos/discount/edit/{id}', 'POS_DiscountController@edit');
Route::post('pos/discount/updateProcess', 'POS_DiscountController@update');
Route::delete('pos/discount/destroy/{id}', 'POS_DiscountController@destroy');

//Controller Sales
Route::get('report/sales', function () {
    return view('report/sales/sales');
});
Route::post('report/sales', 'Report_SalesController@show');
Route::post('report/sales/invoice', 'Report_SalesController@export_invoice');
Route::post('report/sales/item', 'Report_SalesController@export_item');
Route::post('report/sales/kategori', 'Report_SalesController@export_kategori');
Route::post('report/sales/store', 'Report_SalesController@export_store');
Route::post('report/sales/diskon', 'Report_SalesController@export_diskon');
Route::post('report/sales/kasir', 'Report_SalesController@export_kasir');
// Route::get('report/sales/edit/{id}', 'POS_ProductItemController@edit');
// Route::post('report/sales/add', 'POS_ProductItemController@create');
// Route::post('report/sales/updateProcess', 'POS_ProductItemController@update');
// Route::delete('report/sales/destroy/{id}', 'POS_ProductItemController@destroy');

//Controller Store Sales
Route::get('report/store_sales', 'Report_StoreSalesController@index');
Route::post('report/store_sales', 'Report_StoreSalesController@show');

//Controller Transaction Log
Route::get('transaction/log', 'Transaction_LogController@index');
Route::get('transaction/log/void/{no_inv}', 'Transaction_LogController@void');
Route::get('transaction/log/detail/{no_inv}', 'Transaction_LogController@show');
Route::post('transaction/log/keterangan/{no_inv}', 'Transaction_LogController@keterangan');

//Controller Transaction Session
Route::get('transaction/session', 'Transaction_SessionController@index');
Route::post('transaction/session/detail', 'Transaction_SessionController@show');

// User
Route::get('uc/admin', 'UserController@index');
Route::post('uc/admin/add', 'UserController@create');
Route::get('uc/admin/edit/{id}', 'UserController@edit');
Route::post('uc/admin/updateProcess', 'UserController@update');
Route::delete('uc/admin/destroy/{id}', 'UserController@destroy');

Route::get('logout', 'UserController@logout');
