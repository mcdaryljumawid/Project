<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\Model;
use App\Worker;
use Validator;
use Session;

class WorkersController extends Controller
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
        return view('workers.index');
    }

    public function get_datatable()
    {
        $workers = Worker::select(['id','workerfname', 'workermname', 'workerlname', 'workerlevel', 'workertype']);

        return Datatables::of($workers)
        ->addColumn('action', function ($worker){

            return '
                    <button title="View Worker Details" class="btn btn-primary view-data-btn" data-id="'.$worker->id.'">
                            <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <button title="Edit Worker" class="btn btn-warning edit-data-btn" data-id="'.$worker->id.'">
                            <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <button title="Delete Worker" class="btn btn-danger delete-data-btn" data-id="'.$worker->id.'">
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
        return view('workers.create');
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
        'workerfname' => 'required|max:25',
        'workerlname' => 'required|max:25',
        'workermname' => 'required|max:25',
        'workerbrgy' => 'required|max:25',
        'workertown' => 'required|max:25',
        'workergender' => 'required',
        'workerprovince' => 'required|max:25',
        'workerContactNo' => 'required|size:11|regex:/(09)[0-9]{9}/|unique:workers',
        'workerlevel' => 'required',
        'workertype' => 'required',
        'password' => 'required|min:6|max:20|same:confirm_password',
        'workerdbirth' => 'nullable|date',
        ]);

        /*if($validator->fails())
        {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            Worker::create([
            'workerfname' => ucfirst($request->workerfname),
            'workerlname' => ucfirst($request->workerlname),
            'workermname' => ucfirst($request->workermname),
            'workerdbirth' => $request->workerdbirth,
            'workerbrgy' => ucfirst($request->workerbrgy),
            'workertown' => ucfirst($request->workertown),
            'workerprovince' => ucfirst($request->workerprovince),
            'workergender' => $request->workergender,   
            'workermaritalStatus' => $request->workermaritalStatus,
            'workerContactNo' => $request->workerContactNo,
            'workertype' => $request->workertype,
            'workerlevel' => $request->workerlevel,
            'password' => bcrypt($request->password)
            ]);

            Session::flash('message', 'Worker successfully created!');
            return redirect('/workers');
        }*/

        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }
        if(\App\Worker::create($data)){
            return response()->json(['success' => true, 'msg' => 'Worker Successfully added!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while adding worker!']);
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
        $worker = Worker::findOrFail($id);
        //dd($userEdit->id);
        return view('workers.view')->with('worker',$worker);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $worker = Worker::findOrFail($id);
        //dd($userEdit->id);
        return view('workers.edit')->with('worker',$worker);
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
        'workerfname' => 'required|max:25',
        'workerlname' => 'required|max:25',
        'workermname' => 'required|max:25',
        'workerbrgy' => 'required|max:25',
        'workertown' => 'required|max:25',
        'workergender' => 'required',
        'workerprovince' => 'required|max:25',
        'workerContactNo' => 'required|size:11|regex:/(09)[0-9]{9}/ ',
        'workerlevel' => 'required',
        'workertype' => 'required',
        'password' => 'nullable|min:6|max:20|same:confirm_password',
        ]);

        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }else{
            unset($data['password']);
        }

        if(Worker::find($id)->update($data)){
            return response()->json(['success' => true, 'msg' => 'Worker Successfully updated!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while updating worker!']);
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
        try{
        if(Worker::destroy($id)){
            return response()->json(['success' => true, 'msg' => 'Worker Successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting worker!']);
        }
        }catch (\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'Worker cannot be deleted!']);
        }
    }
}
