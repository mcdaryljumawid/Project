<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class CustomerLoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:customer', ['except' => ['logout']]);
	}

    public function showLoginForm()
    {
    	return view('auth.customer-login');
    }

    public function login(Request $request)
    {
    	//validate the form data
    	$this->validate($request, [
    		'custUsername' => 'required|max:50',
    		'password' => 'required|min:6',
    	]);

    	if(Auth::guard('customer')->attempt(['custUsername' => $request->custUsername, 'password' => $request->password, 'status' => 'Active'], $request->remember)){ //If successful, then redirect to
    		return redirect()->intended(route('customer.dashboard'));
    	} 
    	//If unsuccessful, http_redirect()
    	return redirect()->back()->withInput($request->only('custUsername', 'remember'))->with('message', 'Login failed!');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('customer/login');
    }
}
