<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Yajra\DataTables\Facades\Datatables;
use App\TransactionDetail;
use App\Worker;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager');
    }

    public function index()
    {
        return view('reports.index');        
    }

    public function projectedincome()
    {
        return view('reports.projectedincome');        
    }

    public function workerperformance()
    {
    	$workers = \App\Worker::all();

    	return view('reports.workerperformance', compact('workers'));
    }

    public function getprojectedincome(Request $request)
    {
    	if($request->choice == 1)
    	{	
     	   $projectedincomes = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'services.serviceprice', DB::raw('SUM(transaction_details.companygrossincome) as grossincome')])
    			->groupBy('services.id')
    			->whereYear('transaction_details.created_at', '=', $request->year)
    			->get();    
    	}
    	else if($request->choice == 2)
    	{	
     	   $projectedincomes = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'services.serviceprice', DB::raw('SUM(transaction_details.companygrossincome) as grossincome')])
    			->groupBy('services.id')
    			->whereYear('transaction_details.created_at', '=', $request->year)
    			->whereMonth('transaction_details.created_at', '=', $request->month)
    			->get();    
    	}
    	else if($request->choice == 3)
    	{	
     	   $projectedincomes = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'services.serviceprice', DB::raw('SUM(transaction_details.companygrossincome) as grossincome')])
    			->groupBy('services.id')
    			->whereDate('transaction_details.created_at', '=', $request->date1)
    			->get();    
    	}
    	else
    	{
    		$projectedincomes = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'services.serviceprice', DB::raw('SUM(transaction_details.companygrossincome) as grossincome')])
    			->groupBy('services.id')
    			->whereDate('transaction_details.created_at', '>=', $request->date1)
    			->whereDate('transaction_details.created_at', '<=', $request->date2)
    			->get();   
    	}

    	return Datatables::of($projectedincomes)
    	->addColumn('id', function($projectedincome){
            return $projectedincome->id;
        })
        ->addColumn('servicename', function($projectedincome){
            return $projectedincome->name;
        })
        ->addColumn('transactioncount', function($projectedincome){
            return $projectedincome->transactioncount;
        })
        ->addColumn('serviceprice', function($projectedincome){
            return $projectedincome->serviceprice;
       })
        ->addColumn('grossincome', function($projectedincome){
            return '₱ '.number_format($projectedincome->grossincome, 2, '.', ',');
        })
        ->make(true);
    }

     public function getworkerperformance(Request $request)
    {
    	if($request->choice == 1)
    	{	
     	   $workerperformances = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'workers.workerlname as lastname', 'workers.workerfname as firstname'])
    			->groupBy('services.id')
    			->whereYear('transaction_details.created_at', '=', 2018)
    			->where('transaction_details.worker_id', $request->worker_id)
    			->get();    
    	}
    	else if($request->choice == 2)
    	{	
     	   $workerperformances = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'workers.workerlname as lastname', 'workers.workerfname as firstname'])
    			->groupBy('services.id')
    			->whereYear('transaction_details.created_at', '=', $request->year)
    			->whereMonth('transaction_details.created_at', '=', $request->month)
    			->where('transaction_details.worker_id', $request->worker_id)
    			->get(); 
	   	}		
    	else if($request->choice == 3)
    	{	
     	   $workerperformances = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'workers.workerlname as lastname', 'workers.workerfname as firstname'])
    			->groupBy('services.id')
    			->whereDate('transaction_details.created_at', '=', $request->date1)
    			->where('transaction_details.worker_id', $request->worker_id)
    			->get();    
    	}
    	else
    	{
    		$workerperformances = \App\TransactionDetail::
    			join('services', 'transaction_details.service_id', '=', 'services.id')
    			->join('workers', 'transaction_details.worker_id', '=', 'workers.id')
    			->select(['services.id as id', 'services.servicename as name', DB::raw('COUNT(transaction_details.transaction_id) as transactioncount'), 'workers.workerlname as lastname', 'workers.workerfname as firstname'])
    			->groupBy('services.id')
    			->whereDate('transaction_details.created_at', '>=', $request->date1)
    			->whereDate('transaction_details.created_at', '<=', $request->date2)
    			->where('transaction_details.worker_id', $request->worker_id)
    			->get();   
    	} 

    	return Datatables::of($workerperformances)
    	->addColumn('id', function($workerperformance){
            return $workerperformance->id;
        })
        ->addColumn('servicename', function($workerperformance){
            return $workerperformance->name;
        })
        ->addColumn('transactioncount', function($workerperformance){
            return $workerperformance->transactioncount;
        })
        ->addColumn('workername', function($workerperformance){
            return $workerperformance->lastname.', '.$workerperformance->firstname;
       })
        ->make(true);
    } 
}
