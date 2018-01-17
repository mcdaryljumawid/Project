<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Customer;
use Validator;
use Session;

class RegisterCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('registercustomer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registercustomer.create');
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
        'custfname' => 'required|max:50|regex:/^[a-zA-Z ]+$/',
        'custmname' => 'required|max:50|regex:/^[a-zA-Z ]+$/',
        'custlname' => 'required|max:50|regex:/^[a-zA-Z ]+$/',
        'custContactNo' => 'required|unique:customers|min:11|size:11',
        'email' => 'required|unique:customers|email',
        'custUsername' => 'required|unique:customers|max:25',
        'custgender' => 'required',
        'password' => 'required|min:6|max:20|same:confirm_password'
        ]);

        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }

        if($data['custfname']){
            $data['custfname'] = ucwords($data['custfname']);          
        }

        if($data['custmname']){
            $data['custmname'] = ucwords($data['custmname']);          
        }

        if($data['custlname']){
            $data['custlname'] = ucwords($data['custlname']);          
        }

        if(\App\Customer::create($data)){
            return response()->json(['success' => true, 'msg' => 'Registration successful!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Registration failed!']);
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
