<?php

namespace App\Exports;

use App\DeliveryMan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon;

class SuccesslistExport implements FromView
{

protected $reportstdate,$reportenddate;

  public function __construct($reportstdate,$reportenddate){
  	$this->reportstdate=$reportstdate;
  	$this->reportenddate=$reportenddate;
  }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

    $today = today();
    $month = $today->format('m');
    // dd($month);
    $dates = []; 

    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-y');
    }
    
    $now = Carbon\Carbon::now();
    $mymonth=$now->month;
    $reportstdate=$this->reportstdate;
    $reportenddate=$this->reportenddate;
    $ways=DeliveryMan::with('ways')->whereHas('ways',function($query) use($mymonth){
    $query->WhereMonth('created_at',$mymonth)->where('status_code','001');
  	})->orWhereDoesntHave('ways')->with('pickups')->orWhereHas('pickups',function($query) use($mymonth){
    $query->WhereMonth('created_at',$mymonth)->where('status','1');
 	 })->orWhereDoesntHave('pickups')->with('user')->with('ways.item')->get();
  	//dd($ways);
       return view('dashboard.successview',compact('ways','dates','month'));
    }
}
