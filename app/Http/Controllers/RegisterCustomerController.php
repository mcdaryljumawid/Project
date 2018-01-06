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
        $validator = Validator::make($request->all(), [
        'custfname' => 'required|max:25',
        'custmname' => 'required|max:25',
        'custlname' => 'required|max:25',
        'custContactNo' => 'required|unique:customers|min:11|size:11',
        'email' => 'required|unique:customers|email',
        'custUsername' => 'required|unique:customers|max:25',
        'password' => 'required|min:6|max:50',
        ]);

        if($validator->fails())
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

        Session::flash("Successfully registered!");
        return redirect('/registercustomer');
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
