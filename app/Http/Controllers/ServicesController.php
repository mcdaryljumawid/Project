<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\Model;
use App\Service;
use Validator;
use Session;
use Eloquent;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }

    public function index()
    {
        return view('services.index');
    }

    public function get_datatable()
    {
        $services = Service::select(['id', 'servicetype', 'servicename', 'serviceprice', 'serviceduration']);

        return Datatables::of($services)
        ->addColumn('action', function ($service){
            return '
                    <button title="Edit Service Details" class="btn btn-warning edit-data-btn" data-id="'.$service->id.'">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <button title="Delete Service" class="btn btn-danger delete-data-btn" data-id="'.$service->id.'">
                        <span class="glyphicon glyphicon-trash"></span>
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
        $service = Service::all();
        return view('services.create', compact('service'));
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
        'servicename'       => 'required|unique:services|max:50',
        'serviceprice'      => 'required|integer',
        'serviceduration'   => 'required|integer',
        'servicetype'       => 'required'
        ]);

        /* if($validator->fails())
        {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            Service::create([
            'servicename'       => ucfirst($request->servicename),
            'serviceprice'      => $request->serviceprice,
            'serviceduration'   => $request->serviceduration,
            'servicetype'       => $request->servicetype,
            ]);

            Session::flash('message', 'Service successfully created!');
            return redirect('/services');
        }*/
        if(\App\Service::create($data)){
            return response()->json(['success' => true, 'msg' => 'Service Successfully added!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while adding service!']);
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
        $service = Service::findOrFail($id);
        //dd($userEdit->id);
        //return $user;
        return view('services.edit')->with('service',$service);
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
        'servicename'       => 'required|max:50',
        'serviceprice'      => 'required|integer',
        'serviceduration'   => 'required|integer',
        'servicetype'       => 'required'
        ]);

        if(Service::find($id)->update($data)){
            return response()->json(['success' => true, 'msg' => 'Service successfully updated!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while updating service!']);
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
        if(Service::destroy($id)){
            return response()->json(['success' => true, 'msg' => 'Service successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting service!']);
        }
    }
}
