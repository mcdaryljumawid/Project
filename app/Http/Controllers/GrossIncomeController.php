<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class GrossIncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager');
    }

    public function index()
    {
		return view('grossincome.index');        
    } 
}
