<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\Model;
use App\Appointment;
use App\Customer;
use App\Worker;
use App\Service;
use Carbon\Carbon;
use Validator;
use Session;
use Eloquent;
use Auth;
use DateTime;
use DateInterval;

class AppointmentsController extends Controller
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
        return view('appointments.index');
    }

    public function get_datatable()
    {
        $appointments = \App\Appointment::where('appointStatus', "Pending");

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
        ->addColumn('workername', function($appointment){
            return $appointment->worker->workerlname.", ".$appointment->worker->workerfname;
        })
        ->addColumn('service', function($appointment){
            return $appointment->service->servicename;
        })
        ->addColumn('status', function($appointment){
            return $appointment->appointStatus;
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
                    <button title="Make transaction from appointment" class="btn btn-default make-transaction-btn" data-id="'.$appointment->id.'">
                        <span class="fa fa-plus-square"></span>
                    </button></div>';
        })
        ->make(true);
    }

    public function get_datatable_appointhistory()
    {
        $status = ["Cancelled", "Closed"];
        $appointments = \App\Appointment::wherein('appointStatus', $status)->get();

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
        ->addColumn('workername', function($appointment){
            return $appointment->worker->workerlname.", ".$appointment->worker->workerfname;
        })
        ->addColumn('service', function($appointment){
            return $appointment->service->servicename;
        })
        ->addColumn('status', function($appointment){
            return $appointment->appointStatus;
        })
        ->addColumn('action', function ($appointment){
            return '
                    <button title="View Appointment Details" class="btn btn-primary view-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>';
        })
        ->make(true);
    }

    public function appointmenttransactionform($id)
    {
        $appointment = Appointment::findOrFail($id);

        return view('appointments.appointmenttransactionform')->with('appointment',$appointment);
    }

    public function appointmenttransaction(Request $request, $id)
    {
        $transaction = \App\Transaction::create([
            'customer_id' => $request->customer_id,
            'transactStatus' => "Pending",
            'transactBill' => 0, 
            'user_id' => Auth::user()->id,
        ]);

        $transactiondetail = \App\TransactionDetail::create([
            'service_id' => $request->service_id,
            'worker_id'  => $request->worker_id,
            'transaction_id' => $transaction->id,
            'workergrossincome' => 0,
            'companygrossincome' => 0,
        ]);

        $appointmenttransaction = \App\AppointmentTransaction::create([
            'transaction_id' => $transaction->id,
            'appointment_id' => $id,
        ]);

            if(Appointment::find($id)->update([
                'appointStatus' => "Closed",
            ])){
                return response()->json(['success' => true, 'msg' => 'Transaction from Appointment Successfully Created!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'Transaction from Appointment Not Created!']);
            }

        //appointment = Appointment::findOrFail($id);

        //return ('appointments.addappointmenttransactionform')->with('appointment',$appointment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('id', '!=', 1)->get();
        $services = Service::all();
        $workers = Worker::all();

        return view('appointments.create', compact(['customers', 'services', 'workers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today = Carbon::today();
        $now = date('Y-m-d H:i:s');
        $present = date('Y-m-d H:i:s', strtotime('+3 hours'));
        $daybefore = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $data = request()->validate([
        'appointDateTime'       => 'required|after:'. $today .'',
        'appointRemarks'        => 'nullable',
        'service_id'            => 'required',
        'worker_id'             => 'required',
        'customer_id'           => 'required',
        'agree'                 => 'required',
        ]);


    $service = \App\Service::findorFail($request->service_id);

    $requesttime = date("H", strtotime($request->appointDateTime));

    $format = date("A", strtotime($request->appointDateTime));
    $requestformatted = date('Y-m-d H:i:s', strtotime($request->appointDateTime));


    $finaltime = date('Y-m-d H:i:s', strtotime('+'.$service->serviceduration.' minutes', strtotime($request->appointDateTime)));
    $requestend = date("H", strtotime($finaltime));

    $formatted = date('Y-m-d H:i:s', strtotime($request->appointDateTime));

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

    if($requesttime <  8)
    {
        return response()->json(['success' => false, 'msg' => 'Appointment time cannot be before opening hours!']);
    }

    if($requesttime >= 19 || $requestend >=19)
    {
        return response()->json(['success' => false, 'msg' => 'Appointment time cannot exceed closing hours!']);
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
            //$apt->appointRemarks     =  $request->appointRemarks;
            $apt->service_id         =  $request->service_id;
            $apt->worker_id          =  $request->worker_id;
            $apt->customer_id        =  $request->customer_id;


        if($apt->save()){
            return response()->json(['success' => true, 'msg' => 'Appointment Successfully Booked!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while booking appointment!']);
        }
    }

    public function rescheduleform($id)
    {
        $appointment = Appointment::findorFail($id);

        return view('appointments.rescheduleform')->with('appointment',$appointment);
    }


    public function reschedule(Request $request, $id)
    {
        $today = Carbon::today();
        $now = date('Y-m-d H:i:s');
        $present = date('Y-m-d H:i:s', strtotime('+3 hours'));
        $daybefore = date('Y-m-d H:i:s', strtotime('+24 hours'));

         $data = request()->validate([
        'appointDateTime'       => 'required|after:'. $today .'',
        ]);



        $minus = date('Y-m-d H:i:s', strtotime('-3 hours', strtotime($request->appointDateTime)));
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

        return view('appointments.cancelform')->with('appointment',$appointment);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        //dd($userEdit->id);
        return view('appointments.view')->with('appointment',$appointment);
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

    public function messages()
    {
        return [
            'appointDateTime.after' => 'Date should be today or the next day!',
            'body.required'  => 'A message is required',
        ];
    }

    public function selectService(Request $request, $data)
    {
        if($request->ajax())
        {
            $services = \App\Service::where('servicecategory', $data)->get();
            /*$data = ->render();
            return response()->json(['options'=>$data]);*/
            return  view('appointments.ajax-select',compact('services'));
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
            else if($service->servicename === "Hair Rebond")
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
            return  view('appointments.ajax-select-worker',compact('workers'));
        }
    }
}
