<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use \App\Service;
use \App\Worker;
use \App\Appointment;
use Yajra\DataTables\Facades\Datatables;


class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer');
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
        return view('customer.myappointments');
    }

    public function getpendingappointments()
    {
        $appointments = \App\Appointment::
            where('customer_id', Auth::user()->id)
            ->where('appointStatus', "Pending")
            ->get();
            

        return Datatables::of($appointments)
       ->addColumn('id', function($appointment){
            return $appointment->id;
        })
        ->addColumn('datetime', function($appointment){
            return date('M d, Y h:i A', strtotime($appointment->appointDateTime));
        })
        ->addColumn('workername', function($appointment){
            return $appointment->worker->workerlname.", ".$appointment->worker->workerfname;
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
                    <button title="Re-schedule appointment" class="btn btn-warning reschedule-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </button>
                    <button title="Cancel appointment" class="btn btn-danger cancel-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                    </button>   
                    </div>';
        })
        ->make(true);
    }

    public function getappointments()
    {
        $status = ["Cancelled", "Closed"];

        $appointments = \App\Appointment::
            where('customer_id', Auth::user()->id)
            ->wherein('appointStatus', $status)
            ->get();
            

        return Datatables::of($appointments)
       ->addColumn('id', function($appointment){
            return $appointment->id;
        })
        ->addColumn('datetime', function($appointment){
            return date('M d, Y h:i A', strtotime($appointment->appointDateTime));
        })
        ->addColumn('workername', function($appointment){
            return $appointment->worker->workerlname.", ".$appointment->worker->workerfname;
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
        return view('customer.viewappointmentdetails')->with('appointment',$appointment);
    }

    public function addappointment()
    {

        $services = Service::all();
        $workers = Worker::all();
        
        return view('customer.addappointment', compact(['services', 'workers']));
    }

    public function storeappointment(Request $request)
    {

        if(Auth::guard('customer')->check())
        {
                $id = Auth::user()->id;
        }
        //$yesterday = Carbon::now()->subDays(1)->toDateString();
        $yesterday = date('Y-m-d h:i:s', strtotime('-24 hours', strtotime('now')));

        $data = request()->validate([
        'appointDateTime'       => 'required', //|after:'.$yesterday.'',
        'appointRemarks'        => 'nullable',
        'service_id'            => 'required',
        'worker_id'             => 'required',
        'agree'                 => 'required',
        ]);

   
            $apt = new \App\Appointment;
            $apt->appointDateTime    =  $request->appointDateTime;
            $apt->datetimeResched    =  date('Y-m-d h:i:s', strtotime('-3 hours', strtotime($request->appointDateTime)));
            $apt->appointStatus      =  "Pending";
            $apt->appointRemarks     =  "";           
            $apt->service_id         =  $request->service_id;
            $apt->worker_id          =  $request->worker_id;
            $apt->customer_id        =  $id;


        if($apt->save()){
            return response()->json(['success' => true, 'msg' => 'Appointment Successfully Booked!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while booking appointment!']);
        }
    }

    public function selectService(Request $request, $data)
    {

        if($request->ajax())
        {
            $services = \App\Service::where('servicecategory', $data)->get();
            /*$data = ->render();
            return response()->json(['options'=>$data]);*/
            return  view('customer.ajax-select',compact('services'));
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
            return  view('customer.ajax-select-worker',compact('workers'));
        }
    }

     public function rescheduleform($id)
    {
        $appointment = Appointment::findorFail($id);

        return view('customer.rescheduleform')->with('appointment',$appointment);
    }


    public function reschedule(Request $request, $id)
    {
        $minus = date('Y-m-d h:i:s', strtotime('-3 hours', strtotime($request->appointDateTime)));
         if(Appointment::find($id)->update([
            'appointDateTime' => $request->appointDateTime,
            'datetimeResched' => $minus,
         ])){
            return response()->json(['success' => true, 'msg' => 'Appointment successfully re-scheduled!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while re-scheduling service!']);
        }
    }

    public function cancelform($id)
    {
        $appointment = Appointment::findorFail($id);

        return view('customer.cancelform')->with('appointment',$appointment);
    }



    public function cancel(Request $request, $id)
    {
        $data = request()->validate([
        'appointRemarks' => 'required',
        ]);

        if(Appointment::find($id)->update([
            'appointStatus' => "Cancelled",
            'appointRemarks' => $request->appointRemarks,
         ])){
            return response()->json(['success' => true, 'msg' => 'Appointment successfully cancelled!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while cancelling service!']);
        }
    }

    public function mytransactions()
    {
        return view('customer.mytransactions');
    }

    public function gettransactionhistory()
    {

        if(Auth::guard('customer')->check())
        {
            $id = Auth::user()->id;    
        }

        $transactions = \App\Transaction::where('transactStatus', "Closed")
        ->where('customer_id', $id)
        ->select('id')
        ->get();

        $transactiondetails = \App\TransactionDetail::wherein('transaction_id', $transactions)
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
        ->addColumn('workername', function($transactiondetail){
            return $transactiondetail->worker->workerlname.", ".$transactiondetail->worker->workerfname;
        })
        ->addColumn('service', function($transactiondetail){
            return $transactiondetail->service->servicename;
        })
         ->addColumn('bill', function($transactiondetail){
            return $transactiondetail->transaction->transactBill;
        })
        ->make(true);
    }
}
