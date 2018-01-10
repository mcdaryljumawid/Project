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
                    <button title="View Appointment Details" class="btn btn-primary view-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <button title="Re-schedule appointment" class="btn btn-warning reschedule-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </button>
                    <button title="Cancel appointment" class="btn btn-danger cancel-data-btn" data-id="'.$appointment->id.'">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                    </button>';
        })
        ->make(true);
    }

    public function get_datatable_appointhistory()
    {
        $appointments = \App\Appointment::where('appointStatus', ["Cancelled","Closed"]);

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
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
        //$yesterday = Carbon::now()->subDays(1)->toDateString();
        $yesterday = date('Y-m-d h:i:s', strtotime('-24 hours', strtotime('now')));
        $data = request()->validate([
        'appointDateTime'       => 'required', //|after:'.$yesterday.'',
        'appointRemarks'        => 'nullable',
        'service_id'            => 'required',
        'worker_id'             => 'required',
        'customer_id'           => 'required',
        'agree'                 => 'required',
        ]);

       // $dy = date('Y', strtotime($request->appointDateTime));
        // $dm = date('m', strtotime($request->appointDateTime));
        //$dd = date('d', strtotime($request->appointDateTime));
        //$dh = date('h', strtotime($request->appointDateTime));
        //$dm = date('i', strtotime($request->appointDateTime));
        //$ds = date('s', strtotime($request->appointDateTime));
        //$dt = Carbon::create($dy,$dm,$dd,$dh,$dm);



            $apt = new \App\Appointment;
            $apt->appointDateTime    =  $request->appointDateTime;
            $apt->datetimeResched    =  date('Y-m-d h:i:s', strtotime('-3 hours', strtotime($request->appointDateTime)));
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
}
