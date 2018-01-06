<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class WorkerLoginController extends Controller
{
    public function __construct()
	{
		$this->middleware('guest:worker', ['except' => ['logout']]);
	}

    public function showLoginForm()
    {
    	return view('auth.worker-login');
    }

    public function login(Request $request)
    {
    	//validate the form data
    	$this->validate($request, [
    		'id' => 'required|integer',
    		'password' => 'required|min:6',
    	]);

    	if(Auth::guard('worker')->attempt(['id' => $request->id, 'password' => $request->password], $request->remember)){ //If successful, then redirect to
    		return redirect()->intended(route('worker.dashboard'));
    	} 
    	//If unsuccessful, http_redirect()
    	return redirect()->back()->withInput($request->only('id', 'remember'));
    }

    public function logout()
    {
        Auth::guard('worker')->logout();
        return redirect('worker/login');
    }
}

