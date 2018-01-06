<?php

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

Auth::routes();
//main users redirection route
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cashier', 'CashierController@index')->name('cashier');
Route::get('/logindirect', 'PagesController@logindirect')->name('logindirect');
//main users logout redirection
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
//customer login and redirection routs
Route::prefix('customer')->group(function(){
	Route::get('/login', 'Auth\CustomerLoginController@showLoginForm')->name('customer.login');
	Route::post('/login', 'Auth\CustomerLoginController@login')->name('customer.login.submit');
	Route::get('/', 'CustomerController@index')->name('customer.dashboard');
	Route::get('/logout', 'Auth\CustomerLoginController@logout')->name('customer.logout');
	Route::post('/logout', 'Auth\CustomerLoginController@logout')->name('customer.logout');
});
//workerlogin and redirection routes
Route::prefix('worker')->group(function(){
	Route::get('/login', 'Auth\WorkerLoginController@showLoginForm')->name('worker.login');
	Route::post('/login', 'Auth\WorkerLoginController@login')->name('worker.login.submit');
	Route::get('/', 'WorkerController@index')->name('worker.dashboard');
	Route::get('/logout', 'Auth\WorkerLoginController@logout')->name('worker.logout');
	Route::post('/logout', 'Auth\WorkerLoginController@logout')->name('worker.logout');
});
//datatables route
Route::get('/users/get_datatable', 'UsersController@get_datatable')->name('users.get_datatable');
Route::get('/workers/get_datatable', 'WorkersController@get_datatable')->name('workers.get_datatable');
Route::get('/customers/get_datatable', 'CustomersController@get_datatable')->name('customers.get_datatable');
Route::get('/services/get_datatable', 'ServicesController@get_datatable')->name('services.get_datatable');
Route::get('/appointments/get_datatable', 'AppointmentsController@get_datatable')->name('appointments.get_datatable');

//crudroutes
Route::resource('users', 'UsersController'); //user routes
Route::resource('workers', 'WorkersController'); //worker routes
Route::resource('customers', 'CustomersController'); //customer routes
Route::resource('services', 'ServicesController'); //customer routes
Route::resource('appointments', 'AppointmentsController'); //customer routes
Route::resource('registercustomer', 'RegisterCustomerController');

Route::get('workers/{workerId}/appointments', 'WorkerAppointmentController@index');


