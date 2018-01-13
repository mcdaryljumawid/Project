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

class TransactionsController extends Controller
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
        return view('transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_datatable()
    {
        $transactions = \App\Transaction::all();

        return Datatables::of($transactions)
        ->addColumn('id', function($transaction){
            return $transaction->id;
        })
        ->addColumn('datetime', function($transaction){
            return date('M d, Y h:i A', strtotime($transaction->created_at));
        })
        ->addColumn('handlinguser', function($transaction){
            return $transaction->user->lastname.", ".$transaction->user->firstname;
        })
        ->addColumn('customername', function($transaction){
            return $transaction->customer->custlname.", ".$transaction->customer->custfname;
        })
        ->addColumn('status', function($transaction){
            return $transaction->transactStatus;
        })
        ->addColumn('action', function ($transaction){
            return '
                    <button title="Add Transaction Details" class="btn btn-primary add-details-btn" data-id="'.$transaction->id.'">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    <button title="View Transaction Details" class="btn btn-primary view-transaction-btn" data-id="'.$transaction->id.'">
                        <span class="glyphicon glyphicon-list"></span>
                    </button>
                    <button title="Generate Bill" class="btn btn-info generate-bill-btn" data-id="'.$transaction->id.'">
                        <span class="glyphicon glyphicon-credit-card"></span>
                    </button>';
        })
        ->make(true);
    }

    public function create()
    {
        $customers = Customer::all();

        return view('transactions.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $data = request()->validate([
        'customer_id'  => 'required',
        ]);

         $trans = new \App\Transaction;
         $trans->transactStatus = "Pending";
         $trans->transactBill = 0; 
         $trans->user_id = Auth::user()->id;
         $trans->customer_id = $request->customer_id;

         if($trans->save()){
            return response()->json(['success' => true, 'msg' => 'Transaction Successfully Created!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while creating transaction!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::findorFail($id);

        $transactiondetails = TransactionDetail::where('transaction_id', $id)->get();

        return view('transactions.view', compact(['transaction', 'transactiondetails']));
    }

    public function adddetailsform($id)
    {
        $transaction = Transaction::findorFail($id);
        $services = Service::all();
        $workers = Worker::all();

        return view('transactions.adddetailsform', compact(['services', 'workers', 'transaction']));
    }

    public function adddetails(Request $request, $id)
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
         $transactiondetails->transaction_id = $request->transaction_id;

         if($transactiondetails->save()){
            return response()->json(['success' => true, 'msg' => 'Transaction Details Successfully Created!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while creating transaction details!']);
        }
    }

    public function selectService(Request $request, $data)
    {
        if($request->ajax())
        {
            $services = \App\Service::where('servicecategory', $data)->get();
            /*$data = ->render();
            return response()->json(['options'=>$data]);*/
            return  view('transactions.ajax-select',compact('services'));
        }
    }

    public function selectWorker(Request $request, $data)
    {
        $types = ["All-around (Rebond specialized)","All-around (Haircut specialized)"];
        if($request->ajax())
        {
            $service = Service::findorFail($data);

            if($service->servicename === "Hair Cut (Men)")
            {
                $workers = Worker::where('workertype', "Barber")->get();
            }
            else if($service->servicename === "Rebond")
            {
                $workers = Worker::where('workertype', "All-around (Rebond specialized)")->get();
            }
            else if($service->servicename === "Hair Cut (Women)")
            {
                $workers = Worker::where('workertype', "All-around (Haircut specialized)")->get();
            }
            else
            {
                $workers = Worker::wherein('workertype', $types)->get();
            }
            /*$data = ->render();
            return response()->json(['options'=>$data]);*/
            return  view('transactions.ajax-select-worker',compact('workers'));
        }
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
        //
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
