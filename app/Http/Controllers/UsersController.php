<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Validator;
use Session;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('manager');
    }

    public function index()
    {
        return view('users.index');
    }

    public function get_datatable()
    {
        $users = User::select(['id','firstname', 'middlename', 'lastname', 'role']);

        return Datatables::of($users)
        ->addColumn('action', function ($user){

                return '
                            <button title="Edit User" class="btn btn-warning edit-data-btn" data-id="'.$user->id.'">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button title="Delete User" class="btn btn-danger delete-data-btn" data-id="'.$user->id.'">
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
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([/*Validator::make($request->all(), [*/
        'firstname'     => 'required|max:25',
        'lastname'      => 'required|max:25',
        'middlename'    => 'required|max:25',
        'password'      => 'required|min:6|max:20|same:confirm_password',
        'role'          => 'required'
        ]);

        /* if($validator->fails())
        {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            User::create([
            'firstname' => ucfirst($request->firstname),
            'lastname' => ucfirst($request->lastname),
            'middlename' => ucfirst($request->middlename),
            'role' => $request->role,
            'password' => bcrypt($request->password)
            ]);

            Session::flash('message', 'User successfully created!');
            return redirect('/users');
        }*/
        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }
        
        if($data['firstname']){
            $data['firstname'] = ucfirst($data['firstname']);          
        }

        if($data['middlename']){
            $data['middlename'] = ucfirst($data['middlename']);          
        }

        if($data['lastname']){
            $data['lastname'] = ucfirst($data['lastname']);          
        }
        

        if(\App\User::create($data)){
            return response()->json(['success' => true, 'msg' => 'User Successfully added!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while adding user!']);
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
        $user = User::findOrFail($id);
        //dd($userEdit->id);
        return view('users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        //dd($userEdit->id);
        //return $user;
        return view('users.edit')->with('user',$user);
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
        'firstname'     => 'required|max:25',
        'lastname'      => 'required|max:25',
        'middlename'    => 'required|max:25',
        'password'      => 'nullable|min:6|max:20|same:confirm_password',
        'role'          => 'required',
        ]);

        if($data['password']){
            $data['password'] = bcrypt($data['password']);          
        }else{
            unset($data['password']);
        }

        if($data['firstname']){
            $data['firstname'] = ucfirst($data['firstname']);          
        }

        if($data['middlename']){
            $data['middlename'] = ucfirst($data['middlename']);          
        }

        if($data['lastname']){
            $data['lastname'] = ucfirst($data['lastname']);          
        }

        if(User::find($id)->update($data)){
            return response()->json(['success' => true, 'msg' => 'User Successfully updated!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while updating user!']);
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
        if(Auth::user()->id == $id)
        {
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
        else
        {
            if(User::destroy($id)){
                return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
            }
        }
    }
}
