<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Http\Requests\CustomerAppointment;
use App\Http\Requests\RescheduleAppointment;
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
        if(Auth::guard('customer')->check())
        {
            $pendingcount     = \App\Appointment::
                                where('customer_id', Auth::user()->id)
                                ->where('appointStatus', "Pending")
                                ->count();
            $appointmentcount = \App\Appointment::where('customer_id', Auth::user()->id)->count();
            $transactioncount = \App\Appointment::where('customer_id', Auth::user()->id)->count();
        }

        return view('customer', compact(['pendingcount', 'appointmentcount', 'transactioncount']));
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
        ->addColumn('date', function($appointment){
            return date('M d, Y', strtotime($appointment->appointDateTime));
        })
        ->addColumn('time', function($appointment){
            return date('h:i A', strtotime($appointment->appointDateTime));
        })
        ->addColumn('timeend', function($appointment){
            return date('h:i A', strtotime('+'.$appointment->service->serviceduration.' minutes', strtotime($appointment->appointDateTime)));
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

    public function getcurrentappointments()
    {
        $appointments = \App\Appointment::where('appointStatus', "Pending");

        return Datatables::of($appointments)
        ->addColumn('date', function($appointment){
            return date
            ('M d, Y', strtotime($appointment->appointDateTime));
        })
        ->addColumn('time', function($appointment){
            return date
            ('h:i A', strtotime($appointment->appointDateTime));
        })
        ->addColumn('timeend', function($appointment){
            return date('h:i A', strtotime('+'.$appointment->service->serviceduration.' minutes', strtotime($appointment->appointDateTime)));
        })
        ->addColumn('workername', function($appointment){
            return $appointment->worker->workerlname.", ".$appointment->worker->workerfname;
        })
        ->addColumn('service', function($appointment){
            return $appointment->service->servicename;
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

    public function storeappointment(CustomerAppointment $request)
    {

        if(Auth::guard('customer')->check())
        {
                $id = Auth::user()->id;
        }
        
        $now = date('Y-m-d H:i:s');
        $present = date('Y-m-d H:i:s', strtotime('+3 hours'));
        $daybefore = date('Y-m-d H:i:s', strtotime('+24 hours'));

    $service = \App\Service::findorFail($request->service_id);
    $requesttime = date("H", strtotime($request->appointDateTime));
    $format = date("A", strtotime($request->appointDateTime));
    $requestformatted = date('Y-m-d H:i:s', strtotime($request->appointDateTime));
    $finaltime = date('Y-m-d H:i:s', strtotime('+'.$service->serviceduration.' minutes', strtotime($request->appointDateTime)));
    $requestend = date("H", strtotime($finaltime));
    $formatted = date('Y-m-d H:i:s', strtotime($request->appointDateTime));
    $requestdaytoday    = date('D', strtotime($request->appointDateTime));

     if($service->servicename == "Hair Rebond")
     {
        if($daybefore > $formatted)
        {
            return response()->json(['success' => false, 'msg' => 'Rebond appointment should be booked one day before!']);
        }
    }
    else
    {
        if($present > $formatted)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment should be booked three hours before!']);
        }
    }

    if($formatted < $now)
    {
        return response()->json(['success' => false, 'msg' => 'Date and time chosen already passed!']);
    }

   if($requestdaytoday == "Sun")
    {
        if($requesttime <  10)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot be before opening hours!']);
        }

        if($requesttime >= 21 || $requestend >= 21)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot exceed closing hours!']);
        }
    }
    else
    {
        if($requesttime <  9)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot be before opening hours!']);
        }

        if($requesttime >= 21 || $requestend >= 21)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot exceed closing hours!']);
        }
    }

    $appointments = \App\Appointment::
                where('appointStatus', "Pending")
                ->where('worker_id', $request->worker_id)
                ->whereDate('appointDateTime', '=', date('Y-m-d', strtotime($request->appointDateTime)))
                ->get();          

    foreach($appointments as $appointment)
    {
        $final = date('Y-m-d H:i:s', strtotime('+'.$appointment->service->serviceduration.' minutes', strtotime($appointment->appointDateTime)));

        if($formatted >= $appointment->appointDateTime && $formatted <= $final)
        {
             return response()->json(['success' => false, 'msg' => 'Booked appointment conflicts with appointment of same worker!']);
        }
    }
   
            $apt = new \App\Appointment;
            $apt->appointDateTime    =  $request->appointDateTime;
            $apt->datetimeResched    =  date('Y-m-d H:i:s', strtotime('-3 hours', strtotime($request->appointDateTime)));
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


    public function reschedule(RescheduleAppointment $request, $id)
    {
        $now            = date('Y-m-d H:i:s');
        $present        = date('Y-m-d H:i:s', strtotime('+3 hours'));
        $daybefore      = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $app            = Appointment::find($id);

    $service            = \App\Service::findorFail($app->service_id);
    $requesttime        = date("H", strtotime($request->appointDateTime));
    $format             = date("A", strtotime($request->appointDateTime));
    $requestformatted   = date('Y-m-d H:i:s', strtotime($request->appointDateTime));
    $finaltime          = date('Y-m-d H:i:s', strtotime('+'.$service->serviceduration.' minutes', strtotime($request->appointDateTime)));
    $requestend         = date("H", strtotime($finaltime));
    $formatted          = date('Y-m-d H:i:s', strtotime($request->appointDateTime));
    $minus              = date('Y-m-d H:i:s', strtotime('-3 hours', strtotime($request->appointDateTime)));
    $requestdaytoday    = date('D', strtotime($request->appointDateTime));

    if($now > $app->datetimeResched)
    {
        return response()->json(['success' => false, 'msg' => 'Reschedule must be done before the valid reschedule date provided!']);
    }

    if($formatted < $now)
    {
        return response()->json(['success' => false, 'msg' => 'Date and time chosen already passed!']);
    }

   if($requestdaytoday == "Sun")
    {
        if($requesttime <  10)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot be before opening hours!']);
        }

        if($requesttime >= 21 || $requestend >= 21)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot exceed closing hours!']);
        }
    }
    else
    {
        if($requesttime <  9)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot be before opening hours!']);
        }

        if($requesttime >= 21 || $requestend >= 21)
        {
            return response()->json(['success' => false, 'msg' => 'Appointment time cannot exceed closing hours!']);
        }
    }

    $appointments = \App\Appointment::
                where('appointStatus', "Pending")
                ->where('worker_id', $app->worker_id)
                ->where('id', '!=', $app->id)
                ->whereDate('appointDateTime', '=', date('Y-m-d', strtotime($request->appointDateTime)))
                ->get();          

    foreach($appointments as $appointment)
    {
        $final = date('Y-m-d H:i:s', strtotime('+'.$appointment->service->serviceduration.' minutes', strtotime($appointment->appointDateTime)));

        if($formatted >= $appointment->appointDateTime && $formatted <= $final)
        {
             return response()->json(['success' => false, 'msg' => 'Booked appointment conflicts with appointment of same worker!']);
        }
    }

        
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

        $karon          = date('Y-m-d H:i:s');
        $app            = Appointment::find($id);

        $data = request()->validate([
        'appointRemarks' => 'required',
        ]);
 
        if($karon > $app->datetimeResched)
        {
            return response()->json(['success' => false, 'msg' => 'Cancellation must be done before the valid reschedule/cancellation date provided!']);
        }

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
            return $transactiondetail->service->serviceprice;
        })
        ->make(true);
    }
}
