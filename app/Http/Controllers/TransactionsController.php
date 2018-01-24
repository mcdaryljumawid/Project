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
        $transactions = \App\Transaction::where('transactStatus', "Pending");

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
        ->addColumn('action', function ($transaction){
            return '
                    <div class="btn-group" style="display: flex;">
                    <button title="Add Transaction Details" class="btn btn-primary add-details-btn" data-id="'.$transaction->id.'">
                        <span class="fa fa-plus"></span>
                    </button>
                    <button title="Generate Bill" class="btn btn-warning generate-bill-btn" data-id="'.$transaction->id.'">
                        <span class="fa fa-money"></span>
                    </button>
                    <button title="Delete Transaction Details" class="btn btn-danger transaction-details-btn" data-id="'.$transaction->id.'">
                        <span class="fa fa-ban"></span>
                    </button></div>';
        })
        ->make(true);
    }

    public function get_datatable_closedtransactions()
    {
        $transactions = \App\Transaction::where('transactStatus', "Closed");

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
         ->addColumn('bill', function($transaction){
            return $transaction->transactBill;
        })
        ->addColumn('action', function ($transaction){
            return '
                    <button title="View Transaction Details" class="btn btn-info view-transaction-btn" data-id="'.$transaction->id.'">
                        <span class="glyphicon glyphicon-list"></span>
                    </button>';
        })
        ->make(true);
    }

    public function create()
    {
        $ids = Transaction::
        where('transactStatus', "Pending")
        ->select('customer_id')
        ->get();

        $customers = Customer::
        where('id', '!=', 1)
        //->wherein('id', '!=', $ids)
        ->get();

        return view('transactions.create', compact('customers'));
    }

    public function walkinform()
    {

        return view('transactions.walkinform');
    }

    public function addwalkin(Request $request)
    {
        $transaction = \App\Transaction::create([
            'customer_id' => $request->customer_id,
            'transactStatus' => "Pending",
            'transactBill' => 0, 
            'user_id' => Auth::user()->id,
        ]);

        if(\App\TransactionDetail::create([
            'service_id' => $request->service_id,
            'worker_id'  => $request->worker_id,
            'transaction_id' => $transaction->id,
            'workergrossincome' => 0,
            'companygrossincome' => 0,
        ]))
        {
            Worker::find($request->worker_id)->update([
                'availability' => 0,
            ]);

            return response()->json(['success' => true, 'msg' => 'Walk-in Transaction Successfully Created!']);
        }else{
             return response()->json(['success' => false, 'msg' => 'Transaction Not Created!']);
        }

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

         $trans->save();
         

         if(\App\TransactionDetail::create([
            'service_id' => $request->service_id,
            'worker_id'  => $request->worker_id,
            'transaction_id' => $trans->id,
            'workergrossincome' => 0,
            'companygrossincome' => 0,
        ]))
        {
            Worker::find($request->worker_id)->update([
                'availability' => 0,
            ]);

            return response()->json(['success' => true, 'msg' => 'Transaction Successfully Created!']);
        }else{
             return response()->json(['success' => false, 'msg' => 'Transaction Not Created!']);
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

    public function generatebill($id)
    {
        $transaction = Transaction::findorFail($id);
        $sum = 0;  
        $transactiondetails = TransactionDetail::where('transaction_id', $id)->get();

        foreach($transactiondetails as $transactiondetail)
        {
            $sum = $sum + $transactiondetail->service->serviceprice;
        }

        return view('transactions.generatebill', compact(['transaction', 'transactiondetails', 'sum']));
    }

    public function transactiondetails($id)
    {
        //$transaction = Transaction::findorFail($id);
        $transactiondetails = TransactionDetail::where('transaction_id', $id)->get();

        return view('transactions.transactiondetails', compact(['transactiondetails']));
    }

    public function deletetransactiondetails($id)
    {
        $transactiondetail = TransactionDetail::find($id);

         if(TransactionDetail::destroy($id)){
            Worker::find($transactiondetail->worker_id)->update([
                'availability' => 1,
            ]);
            return response()->json(['success' => true, 'msg' => 'Transaction Detail Successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting transaction detail!']);
        }
    }

    public function finalizepayment(Request $request, $id)
    {
        $transaction = Transaction::findorFail($id);
        $sum = 0;  
        $workergrossincome = 0;
        $companygrossincome = 0;

        $transactiondetails = TransactionDetail::where('transaction_id', $id)->get();

        foreach($transactiondetails as $transactiondetail)
        {
            $sum = $sum + $transactiondetail->service->serviceprice;
            if($transactiondetail->worker->workerlevel === "High")
            {
                $workergrossincome = ($transactiondetail->service->serviceprice)*.60;
                $companygrossincome = ($transactiondetail->service->serviceprice)*.40;
            }
            else
            {
                $workergrossincome = ($transactiondetail->service->serviceprice)*.50;
                $companygrossincome = ($transactiondetail->service->serviceprice)*.50;
            }

             TransactionDetail::find($transactiondetail->id)->update([
                'workergrossincome' => $workergrossincome,
                'companygrossincome' => $companygrossincome,
            ]);

             Worker::find($transactiondetail->worker_id)->update([
                'availability' => 1,
             ]);
        }

        if(Transaction::find($id)->update([
            'transactBill' => $sum,
            'transactStatus' => "Closed",
        ])){
            return response()->json(['success' => true, 'msg' => 'Payment successfully finalized!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Error finalizing payment!']);
        }
    }

    public function adddetailsform($id)
    {
        $transaction = Transaction::findorFail($id);
        $serviceids   = TransactionDetail::
                             select('service_id')
                            ->where('transaction_id', $id)
                            ->get();

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

            Worker::find($request->worker_id)->update([
                'availability' => 0,
            ]);

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
                $workers = Worker::
                where('workertype', "Barber")
                ->where('availability', 1)
                ->get();
            }
            else if($service->servicename === "Hair Rebond")
            {
                $workers = Worker::
                where('workertype', "All-around (Rebond specialized)")
                ->where('availability', 1)
                ->get();
            }
            else if($service->servicename === "Hair Cut (Women)")
            {
                $workers = Worker::
                where('workertype', "All-around (Haircut specialized)")
                ->where('availability', 1)
                ->get();
            }
            else
            {
                $workers = Worker::
                wherein('workertype', $types)
                ->where('availability', 1)
                ->get();
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
