<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;

class WorkerAppointmentController extends Controller
{
    public function index($workerId)
    {
    	$appointments = Worker::find($workerId)->appointments;

    	return view('appointments.index');
    }
}
