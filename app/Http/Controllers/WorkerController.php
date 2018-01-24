<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\TransactionDetail;
use App\Worker;
use Yajra\DataTables\Facades\Datatables;

class WorkerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:worker');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {if(Auth::guard('worker')->check())
        {
            $pendingcount     = \App\Appointment::
                                where('worker_id', Auth::user()->id)
                                ->where('appointStatus', "Pending")
                                ->count();
            $appointmentcount = \App\Appointment::where('worker_id', Auth::user()->id)->count();
            $transactioncount = \App\Appointment::where('worker_id', Auth::user()->id)->count();
        }
        return view('worker', compact(['pendingcount', 'appointmentcount', 'transactioncount']));
    }

    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){
 
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("success","Password changed successfully !");
    } 

    public function myappointments()
    {
        return view('worker.myappointments');
    }

    public function getpendingappointments()
    {
        $appointments = \App\Appointment::
            where('worker_id', Auth::user()->id)
            ->where('appointStatus', "Pending")
            ->get();
            

        return Datatables::of($appointments)
       ->addColumn('id', function($appointment){
            return $appointment->id;
        })
        ->addColumn('datetime', function($appointment){
            return date('M d, Y h:i A', strtotime($appointment->appointDateTime));
        })
        ->addColumn('customername', function($appointment){
            return $appointment->customer->custlname.", ".$appointment->customer->custfname;
        })
        ->addColumn('service', function($appointment){
            return $appointment->service->servicename;
        })
        ->addColumn('action', function ($appointment){
            return '
                    <div class="btn-group" style="display: flex;">
                    <button title="View Appointment Details" class="btn btn-primary view-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    </div>';
        })
        ->make(true);
    }

    public function getappointments()
    {
        $status = ["Cancelled", "Closed"];

        $appointments = \App\Appointment::
            where('worker_id', Auth::user()->id)
            ->wherein('appointStatus', $status)
            ->get();
            

        return Datatables::of($appointments)
       ->addColumn('id', function($appointment){
            return $appointment->id;
        })
        ->addColumn('datetime', function($appointment){
            return date('M d, Y h:i A', strtotime($appointment->appointDateTime));
        })
        ->addColumn('customername', function($appointment){
            return $appointment->customer->custlname.", ".$appointment->customer->custfname;
        })
        ->addColumn('service', function($appointment){
            return $appointment->service->servicename;
        })
        ->addColumn('action', function ($appointment){
            return '
                    <div class="btn-group" style="display: flex;">
                    <button title="View Appointment Details" class="btn btn-primary view-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    </div>';
        })
        ->make(true);
    }

    public function viewappointmentdetails($id)
    {
        $appointment = \App\Appointment::findOrFail($id);
        //dd($userEdit->id);
        return view('worker.viewappointmentdetails')->with('appointment',$appointment);
    }

    public function mytransactions()
    {
        return view('worker.mytransactions');
    }

    public function gettransactionhistory()
    {
        $transactions = \App\Transaction::where('transactStatus', "Closed")
        ->select('id')
        ->get();

        $transactiondetails = \App\TransactionDetail::
        where('worker_id', Auth::user()->id)
        ->wherein('transaction_id', $transactions)
        ->get();

        return Datatables::of($transactiondetails)
        ->addColumn('id', function($transactiondetail){
            return $transactiondetail->transaction_id;
        })
        ->addColumn('datetime', function($transactiondetail){
            return date('M d, Y h:i A', strtotime($transactiondetail->transaction->created_at));
        })
        ->addColumn('handlinguser', function($transactiondetail){
            return $transactiondetail->transaction->user->lastname.", ".$transactiondetail->transaction->user->firstname;
        })
        ->addColumn('customername', function($transactiondetail){
            return $transactiondetail->transaction->customer->custlname.", ".$transactiondetail->transaction->customer->custfname;
        })
        ->addColumn('service', function($transactiondetail){
            return $transactiondetail->service->servicename;
        })
         ->addColumn('bill', function($transactiondetail){
            return $transactiondetail->transaction->transactBill;
        })
        ->make(true);
    }

    public function mygrossincome()
    {
        return view('worker.mygrossincome');
    }

     public function getgrossincome(Request $request)
    {
        if($request->choice == 1)
        {   
                $grossincomes = \App\TransactionDetail::
                join('workers', 'transaction_details.worker_id', '=', 'workers.id')
                ->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
                ->groupBy('workers.id')
                ->where('workers.id', Auth::user()->id)
                ->whereYear('transaction_details.created_at', '=', $request->year)
                ->get();
        }
        else if($request->choice == 2)
        { 
            $grossincomes = \App\TransactionDetail::
                join('workers', 'transaction_details.worker_id', '=', 'workers.id')
                ->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
                ->groupBy('workers.id')
                ->where('workers.id', Auth::user()->id)
                ->whereYear('transaction_details.created_at', '=', $request->year)
                ->whereMonth('transaction_details.created_at', '=', $request->month)
                ->get();
        }
        else if($request->choice == 3)
        {
            $grossincomes = \App\TransactionDetail::
                join('workers', 'transaction_details.worker_id', '=', 'workers.id')
                ->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
                ->groupBy('workers.id')
                ->where('workers.id', Auth::user()->id)
                ->whereDate('transaction_details.created_at', '=', $request->date1)
                ->get();
        }
        else
        {
            $grossincomes = \App\TransactionDetail::
                join('workers', 'transaction_details.worker_id', '=', 'workers.id')
                ->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
                ->groupBy('workers.id')
                ->where('workers.id', Auth::user()->id)
                ->whereDate('transaction_details.created_at', '>=', $request->date1)
                ->whereDate('transaction_details.created_at', '<=', $request->date2)
                ->get();
        }

        return Datatables::of($grossincomes)
        ->addColumn('id', function($grossincome){
            return $grossincome->id;
        })
        ->addColumn('firstname', function($grossincome){
            return $grossincome->firstname;
        })
        ->addColumn('lastname', function($grossincome){
            return $grossincome->lastname;
        })
        ->addColumn('transactioncount', function($grossincome){
            return $grossincome->transactioncount;
        })
        ->addColumn('grossincome', function($grossincome){
            return '₱ '.number_format($grossincome->grossincome, 2, '.', ',');
        })
        ->make(true);
    }
}
