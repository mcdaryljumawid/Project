<?php

namespace App\Http\Controllers;

use App\Transaction;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Appointment;
use App\Customer;
use App\Worker;
use App\Service;
use App\TransactionDetail;
use App\Http\Controllers\TransactionDetailsController;
use Carbon\Carbon;
use Auth;
use Validator;
use Session;
use Eloquent;

class TransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        return ('transactiondetails.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        $workers = Worker::all();

        return view('transactiondetails.create', compact(['services', 'workers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data = request()->validate([
        'worker_id'  => 'required',
        'service_id'  => 'required',
        ]);

         $transactiondetails = new \App\TransactionDetail;
         $transactiondetails->workergrossincome = 0;
         $transactiondetails->companygrossincome = 0; 
         $transactiondetails->worker_id = $request->worker_id;
         $transactiondetails->service_id = $request->service_id;
         $transactiondetails->transaction_id = $id;

         if($transactiondetails->save()){
            return response()->json(['success' => true, 'msg' => 'Transaction Details Successfully Created!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while creating transaction details!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
