<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\Model;
use App\Customer;
use Validator;
use Session;

class CustomersController extends Controller
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
        return view('customers.index');
    }

    public function get_datatable()
    {
        $customers = Customer::select(['id', 'custUsername','custfname', 'custmname', 'custlname', 'custgender', 'custContactNo','email']);

        return Datatables::of($customers)
        ->addColumn('action', function ($customer){
            return '
                    <button title="Edit Customer" class="btn btn-warning edit-data-btn" data-id="'.$customer->id.'">
                            <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <button title="Delete Customer" class="btn btn-danger delete-data-btn" data-id="'.$customer->id.'">
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
        return view('customers.create');
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
        'custfname' => 'required|max:25',
        'custmname' => 'required|max:25',
        'custlname' => 'required|max:25',
        'custContactNo' => 'required|unique:customers|min:11|size:11',
        'email' => 'required|unique:customers|email',
        'custUsername' => 'required|unique:customers|max:25',
        'custgender' => 'required',
        'password' => 'required|min:6|max:20|same:confirm_password'
        ]);

        /*if($validator->fails())
        {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            Customer::create([
            'custfname' => ucfirst($request->custfname),
            'custlname' => ucfirst($request->custlname),
            'custmname' => ucfirst($request->custmname),
            'custgender' => $request->custgender,
            'custContactNo' => $request->custContactNo,
            'email' => $request->email,
            'custUsername' => $request->custUsername,
            'password' => bcrypt($request->password)
            ]);

        Session::flash("Successfully added customer!");
        return redirect('/customers');
        }
    }*/
        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }

        if($data['custfname']){
            $data['custfname'] = ucfirst($data['custfname']);          
        }

        if($data['custmname']){
            $data['custmname'] = ucfirst($data['custmname']);          
        }

        if($data['custlname']){
            $data['custlname'] = ucfirst($data['custlname']);          
        }

        if(\App\Customer::create($data)){
            return response()->json(['success' => true, 'msg' => 'Customer Successfully added!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while adding customer!']);
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
        $customer = Customer::findOrFail($id);
        //dd($userEdit->id);
        return view('customers.view', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        //dd($userEdit->id);
        return view('customers.edit')->with('customer', $customer);
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
        'custfname' => 'required|max:25',
        'custmname' => 'required|max:25',
        'custlname' => 'required|max:25',
        'custContactNo' => 'required|min:11|size:11',
        'email' => 'required|email',
        'custUsername' => 'required|max:25',
        'custgender' => 'required',
        'password' => 'nullable|min:6|max:20|same:confirm_password'
        ]);

        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }else{
            unset($data['password']);
        }

        if($data['custfname']){
            $data['custfname'] = ucfirst($data['custfname']);          
        }

        if($data['custmname']){
            $data['custmname'] = ucfirst($data['custmname']);          
        }

        if($data['custlname']){
            $data['custlname'] = ucfirst($data['custlname']);          
        }

        if(Customer::find($id)->update($data)){
            return response()->json(['success' => true, 'msg' => 'Customer Successfully updated!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while updating customer!']);
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
        if(Customer::destroy($id)){
            return response()->json(['success' => true, 'msg' => 'Customer Successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
        }catch (\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'Customer cannot be deleted!']);
        }
    }
}
