<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Yajra\DataTables\Facades\Datatables;
use App\TransactionDetail;
use App\Worker;

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

    public function byworker()
    {
        $workers = \App\Worker::all();

        return view('grossincome.byworker', compact('workers'));        
    } 

    public function getgrossincome(Request $request)
    {
    	if($request->choice == 1)
    	{	
    			$grossincomes = \App\TransactionDetail::
    			join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
    			->groupBy('workers.id')
    			->whereYear('transaction_details.created_at', '=', $request->year)
    			->get();
    	}
    	else if($request->choice == 2)
    	{ 
    		$grossincomes = \App\TransactionDetail::
    			join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
    			->groupBy('workers.id')
    			->whereYear('transaction_details.created_at', '=', $request->year)
    			->whereMonth('transaction_details.created_at', '=', $request->month)
    			->get();
    	}
    	else if($request->choice == 3)
    	{
    		$grossincomes = \App\TransactionDetail::
    			join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
    			->groupBy('workers.id')
    			->whereDate('transaction_details.created_at', '=', $request->date1)
    			->get();
    	}
    	else
    	{
    		$grossincomes = \App\TransactionDetail::
    			join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['workers.id as id', 'workers.workerfname as firstname', 'workers.workerlname as lastname', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), DB::raw('SUM(transaction_details.workergrossincome) as grossincome')])
    			->groupBy('workers.id')
    			->whereDate('transaction_details.created_at', '>=', $request->date1)
    			->whereDate('transaction_details.created_at', '<=', $request->date2)
    			->get();
    	}

    	return Datatables::of($grossincomes)
    	->addColumn('id', function($grossincome){
            return $grossincome->id;
        })
        ->addColumn('firstname', function($grossincome){
            return $grossincome->firstname;
        })
        ->addColumn('lastname', function($grossincome){
            return $grossincome->lastname;
        })
        ->addColumn('transactioncount', function($grossincome){
            return $grossincome->transactioncount;
       })
        ->addColumn('grossincome', function($grossincome){
            return '₱ '.number_format($grossincome->grossincome, 2, '.', ',');
        })
        ->make(true);
    }

    public function getbyworker(Request $request)
    {
        if($request->choice == 1)
        {
            $byworkers = \App\TransactionDetail::
                where('worker_id', $request->worker_id)
                ->whereYear('created_at', '=', $request->year)
                ->get();
        }
        else if($request->choice == 2)
        {
            $byworkers = \App\TransactionDetail::
                where('worker_id', $request->worker_id)
                ->whereYear('created_at', '=', $request->year)
                ->whereMonth('created_at', '=', $request->month)
                ->get();
        }
        else if($request->choice == 3)
        {
            $byworkers = \App\TransactionDetail::
                where('worker_id', $request->worker_id)
                ->whereDate('created_at', '=', $request->date1)
                ->get();
        }
        else
        {
            $byworkers = \App\TransactionDetail::
                where('worker_id', $request->worker_id)
                ->whereDate('created_at', '>=', $request->date1)
                ->whereDate('created_at', '<=', $request->date2)
                ->get();
        }


        return Datatables::of($byworkers)
        ->addColumn('transactionno', function($byworker){
            return $byworker->transaction_id;
        })
        ->addColumn('workerno', function($byworker){
            return $byworker->worker_id;
        })
        ->addColumn('workername', function($byworker){
            return $byworker->worker->workerlname.', '.$byworker->worker->workerfname;
        })
        ->addColumn('datetime', function($byworker){
            return date('M d, Y H:i A', strtotime($byworker->created_at));
       })
        ->addColumn('service', function($byworker){
            return $byworker->service->servicename;
       })
        ->addColumn('grossincome', function($byworker){
            return '₱ '.number_format($byworker->workergrossincome, 2, '.', ',');
        })
        ->make(true);
    }
}
