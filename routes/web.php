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
Route::get('/appointments/get_datatable_appointhistory', 'AppointmentsController@get_datatable_appointhistory')->name('appointments.get_datatable_appointhistory');
Route::get('/transactions/get_datatable', 'TransactionsController@get_datatable')->name('transactions.get_datatable');

//crudroutes
Route::resource('users', 'UsersController'); //user routes
Route::resource('workers', 'WorkersController'); //worker routes
Route::resource('customers', 'CustomersController'); //customer routes
Route::resource('services', 'ServicesController'); //customer routes
Route::resource('appointments', 'AppointmentsController');	//appointmentroutes
Route::resource('transactions', 'TransactionsController');  //transactionroutes
Route::resource('transactiondetails', 'TransactionDetailsController'); //transactiondetails
Route::resource('registercustomer', 'RegisterCustomerController'); //registercustomerroute

//appointments -- reschedule
Route::get('appointments/{appointment}/rescheduleform', 'AppointmentsController@rescheduleform')->name('appointments.rescheduleform');
Route::patch('appointments/{appointment}', 'AppointmentsController@reschedule')->name('appointments.reschedule');
//appointments -- cancel
Route::get('appointments/{appointment}/cancelform', 'AppointmentsController@cancelform')->name('appointments.cancelform');
Route::patch('appointments/{appointment}/cancel', 'AppointmentsController@cancel')->name('appointments.cancel');
//Route::patch('appointments/{appointment}', 'AppointmentsController@cancel')->name('appointments.cancel');
//transaction add transaction details
Route::get('transactions/{transaction}/adddetailsform', 'TransactionsController@adddetailsform')->name('transactions.adddetailsform');
Route::patch('transactions/{transaction}/adddetails', 'TransactionsController@adddetails')->name('transactions.adddetails');
//transactions
Route::get('select-service/{data}', 'TransactionsController@selectService')->name('select-service');
Route::get('select-worker/{data}', 'TransactionsController@selectWorker')->name('select-worker');

//appointments
Route::get('select-service-appointment/{data}', 'AppointmentsController@selectService')->name('select-service-appointment');
Route::get('select-worker-appointment/{data}', 'AppointmentsController@selectWorker')->name('select-worker-appointment');

//workerappointments
Route::get('workers/{workerId}/appointments', 'WorkerAppointmentController@index');

//getservice filtered
Route::get('get_services_by_category/{category}', 'ServicesController@get_services_by_category');



