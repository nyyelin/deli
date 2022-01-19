<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pickup;
use App\Way;
use App\DeliveryMan;
use App\PaymentType;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon;
use Response;
use App\Bank;
use App\Http\Resources\SuccesswayResource;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\ExpenseResource;
use App\Income;
use App\Notifications\RejectNotification;
use App\Notifications\SeenNotification;
use App\Notifications\PickupNotification;
use App\Expense;
use Yajra\DataTables\Facades\DataTables;
use App\Client;
use Notification;
use App\User;
use App\Events\rejectitem;
use Illuminate\Notifications\DatabaseNotification;
use App\Item;
use App\Exports\SuccesslistExport;
use Excel;
use App\Schedule;
use App\Staff;
use App\Transaction;
use PDF;

class MainController extends Controller
{


  // for dashboard main page
  public function dashboard($value='')
  {
    $incomes = Income::whereMonth('created_at', Carbon\Carbon::now()->month)->where('status',1)->sum('delivery_fees');
    $expenses = Expense::whereMonth('created_at', Carbon\Carbon::now()->month)->where('expense_type_id',4)->sum('amount');
    $staff = Staff::all()->count();
    $deliverymen = DeliveryMan::all()->count();

    return view('dashboard.index',compact('incomes','expenses','staff','deliverymen'));
  }

  public function getways($value='')
  {
    $data = Way::selectRaw('COUNT(*) as count, YEAR(created_at) year, MONTH(created_at) month')
    ->groupBy('year', 'month')
    ->get();
    // dd($data);

    $month = [];
    foreach ($data as $row) {
      if($row->year == Carbon\Carbon::now()->year){
        $month[$row->month] = $row->count;
      }
    }

    $ways = [];
    for ($i=0; $i < 12; $i++) { 
      if(array_key_exists($i+1, $month)){
        array_push($ways, $month[$i+1]);
      }else{
        array_push($ways, 0);
      }
    }

    $success_ways = Way::whereMonth('created_at', Carbon\Carbon::now()->month)->where('status_code','001')->get();
    $reject_ways = Way::whereMonth('created_at', Carbon\Carbon::now()->month)->where('status_code','003')->get();
    
    return Response::json(array(
      'ways' => $ways,
      'success_ways' => count($success_ways),
      'reject_ways' => count($reject_ways)
    ));
  }

  // for success list page
  public function success_list($value='')
  {
    $delivery_men = DeliveryMan::all();
    $success_ways = Way::where('status_code','001')->get();
    return view('dashboard.success_list',compact('delivery_men','success_ways'));
  }

  // for reject list page
  public function reject_list($value='')
  {
    $rejectways=Way::where('refund_date',null)->where('status_code','003')->orderBy('id','desc')->get();
    return view('dashboard.reject_list',compact('rejectways'));
  }

  // for return list page
  public function return_list($value='')
  {
    $returnways=Way::where('deleted_at','!=',null)->orderBy('id','desc')->get();
    return view('dashboard.return_list',compact('returnways'));
  }

  public function rejectitem(Request $request){
    $id=$request->id;
   // dd($id);
    $returnitems=DB::table('items')
            ->join('pickups', 'pickups.id', '=', 'items.pickup_id')
            ->join('schedules', 'schedules.id', '=', 'pickups.schedule_id')
            ->join('clients', 'clients.id', '=', 'schedules.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->select('items.*', 'clients.contact_person as cperson', 'clients.phone_no as cphone','clients.address as caddress','users.name as uname')
            ->where('items.id',$id)
            ->get();
            return $returnitems;
  }

  public function returnitem(Request $request){
    $id=$request->id;
   // dd($id);
    $returnitems=DB::table('items')
            ->join('pickups', 'pickups.id', '=', 'items.pickup_id')
            ->join('schedules', 'schedules.id', '=', 'pickups.schedule_id')
            ->join('clients', 'clients.id', '=', 'schedules.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->select('items.*', 'clients.contact_person as cperson', 'clients.phone_no as cphone','clients.address as caddress','users.name as uname')
            ->where('items.id',$id)
            ->get();
            return $returnitems;
  }

  // for delay list page
  public function delay_list($value='')
  {

   // dd($delayitems);
       $deliverymen = DeliveryMan::all();
     $mytime = Carbon\Carbon::now();
    $delayitems=Item::doesntHave('way')->whereDate('created_at','!=', Carbon\Carbon::today())->get();
    return view('dashboard.delay_list',compact('delayitems','deliverymen'));
  }

  public function delaycount(){
    $mytime = Carbon\Carbon::now();
    $delayitems=Item::doesntHave('way')->whereDate('created_at','!=', Carbon\Carbon::today())->get();
    $delaycount=count($delayitems);
    return $delaycount;

  }
  // financial_statements
  public function financial_statements($value='')
  {
    $banks=Bank::all();
    return view('dashboard.financial_statements',compact('banks'));
  }

  // for debt list page
  public function debt_list($value='')
  {
    // $incomes=Income::whereDate('created_at', Carbon\Carbon::today())->where('amount','=',Null)->get();
    //dd($incomes);
    $clients=DB::table('clients')
                ->join('users', 'users.id', '=', 'clients.user_id')
                ->select('clients.*', 'users.name as clientname')
                ->orderBy('users.name')
                ->get();

    $pickups = Pickup::where('status',4)->orderBy('id','desc')->get();

    $role=Auth::user()->roles()->first();
    $rolename=$role->name;
    // dd($rolename);
    $banks = Bank::all();

    if($rolename == "client") {

      $client_id=Auth::user()->client->id;

      $expenses = Expense::where('client_id',$client_id)->where('status',2)->where('expense_type_id',1)->with('expense_type')->get();

      $incomes = Income::whereIn('payment_type_id',[4,5,6])->with('way.item.pickup.schedule')->whereHas('way.item.pickup.schedule',function ($query) use ($client_id){
        $query->where('client_id', $client_id);
      })->where('amount',null)->get();



      $rejects =  Way::with('item.pickup.schedule')
      ->whereHas('item.pickup.schedule', function($query) use ($client_id){
          $query->where('client_id', $client_id);
      })->where('status_code','003')->where('refund_date',null)->get();

      $carryfees = Expense::where('client_id',$client_id)->where('status',2)->where('expense_type_id',5)->with('item.township')->get();


      return view('dashboard.debt_list',compact('clients', 'expenses', 'incomes', 'rejects', 'carryfees','banks'));
    }

    return view('dashboard.debt_list',compact('clients','banks','pickups'));
  }


  public function debt_detail(Request $request,$id)
  {
    $pickup = Pickup::find($id);
    $banks = Bank::all();

    return view('dashboard.debt_detail',compact('pickup','banks'));
  }






  public function getdebitlistbyclient($id)
  {
    // $expenses = Expense::where('client_id',$id)->where('status',2)->where('expense_type_id',1)->with('expense_type')->with('pickup.items')->get();

    $expenses = Pickup::with('schedule')->whereHas('schedule',function ($query) use ($id){
      $query->where('client_id',$id);
    })->with('items')->with('expense')->where('status',4)->get();

    // $incomes = Income::whereIn('payment_type_id',[4,5,6])->with('way.item.pickup.schedule')->with('way.item.township')->whereHas('way.item.pickup.schedule',function ($query) use ($id){
    //   $query->where('client_id', $id);
    // })->where('amount',null)->get();

    $incomes = Item::whereHas('pickup.schedule', function ($query) use ($id){
      $query->where('client_id',$id);
    })->where('status',0)
    ->where(function ($query) {
        $query->where('paystatus', 2)
            ->orWhere('paystatus', 4);
    })->with('way')->with('township')->with('SenderGate')->with('SenderPostoffice')->get();
   
    $rejects =  Way::with('item.pickup.schedule')
    ->whereHas('item.pickup.schedule', function($query) use ($id){
        $query->where('client_id', $id);
    })->where('status_code','003')->where('refund_date',null)->get();

    $carryfees = Expense::where('client_id',$id)->where('status',1)->where('expense_type_id',5)->with('item.township')->with('item.SenderGate')->with('item.SenderPostoffice')->get();

    $myarray=[];
    foreach ($rejects as $income) {
      foreach ($income->unreadNotifications as $notification) {
        array_push($myarray, $notification->id);
      }
    }
    
    return Response::json(array(
            'rejectnoti'=>$myarray,
            'expenses' => $expenses,
            'rejects' => $rejects,
            'incomes' => $incomes,
            'carryfees' => $carryfees,
      ));
  }

  public function getdebithistorybyclient(Request $request)
  {
    $id = $request->client_id;
    $sdate = $request->sdate;
    $edate = $request->edate;

    $expenses = Expense::where('client_id',$id)->where('status',1)->where('expense_type_id',1)->with('expense_type')->whereColumn('created_at','!=','updated_at')->whereBetween('updated_at', [$sdate.' 00:00:00',$edate.' 23:59:59'])->get();

    $incomes = Income::whereIn('payment_type_id',[4,5,6])->with('way.item.pickup.schedule')->whereHas('way.item.pickup.schedule',function ($query) use ($id){
      $query->where('client_id', $id);
    })->where('amount','!=',null)->whereBetween('updated_at', [$sdate.' 00:00:00',$edate.' 23:59:59'])->get();
   
    $rejects = Way::with('item.pickup.schedule')->whereHas('item.pickup.schedule', function($query) use ($id){
        $query->where('client_id', $id);
    })->where('status_code','003')->where('refund_date','!=',null)->whereBetween('updated_at', [$sdate.' 00:00:00',$edate.' 23:59:59'])->get();

    $carryfees = Expense::where('client_id',$id)->where('status',2)->where('expense_type_id',5)->with('item.township')->whereBetween('updated_at', [$sdate.' 00:00:00',$edate.' 23:59:59'])->get();
    
    return Response::json(array(
      'expenses' => $expenses,
      'rejects' => $rejects,
      'incomes' => $incomes,
      'carryfees' => $carryfees,
    ));
  }

  public function fix_debit(Request $request)
  {
    $expenses = json_decode($request->expenses);
    // dd(json_decode($request->expenses)[0]->amount);
    $request->validate([
      'client_id' => 'required'
    ]);

    $item_array = array();

    $notiarray=explode(",", $request->noti);
    //dd($notiarray);
    $mytime = Carbon\Carbon::now();
    $date=$mytime->toDateString();

    foreach ($notiarray as $notiid) {
      $userconfirm= DB::table('notifications')->where('id', $notiid)->update(array('read_at' => $date));
    }


    $expenses_id = Expense::where('pickup_id',$expenses[0]->id)->get();

    if(count($expenses_id)>0){

      foreach ($expenses_id as $expense_id) {

        if($expense_id && $expense_id->item_id == null && $expense_id->expense_type_id == 1){
            
          if($request->total_amount){

            $expense_id->amount = $expense_id->amount+$request->total_amount;
            $expense_id->description = "Fix Debit List";
            $expense_id->save();

          }else{ 

            if(!$request->carryfees || $request->rejects){
              $expense_id->amount = $expense_id->amount+$request->total_pay_amount;
              $expense_id->description = "Fix Debit List";
              $expense_id->save();
            }
          }

        }


        elseif($expense_id->expense_type_id != 1){
          // dd('hi');
          if($request->total_amount){
            $expense = new Expense;
            $expense->pickup_id = $expenses[0]->id;
            $expense->amount = $request->total_amount;
            $expense->description = "Client Fee";
            $expense->expense_type_id = 1;
            $expense->city_id = 1;
            $expense->status = 1;
            $expense->save();
          }else{

            $expense = new Expense;
            $expense->pickup_id = $expenses[0]->id;
            $expense->amount = $request->total_pay_amount;
            $expense->description = "Client Fee";
            $expense->expense_type_id = 1;
            $expense->city_id = 1;
            $expense->status = 1;
            $expense->save();
          }

        }

      }
    }

    // already expense => carry fees
    else if(count($expenses_id) <= 0){

      
        
        if($request->total_amount){
          $expense = new Expense;
          $expense->pickup_id = $expenses[0]->id;
          $expense->amount = $request->total_amount;
          $expense->description = "Client Fee";
          $expense->expense_type_id = 1;
          $expense->city_id = 1;
          $expense->status = 1;
          $expense->save();
        }else{

          $expense = new Expense;
          $expense->pickup_id = $expenses[0]->id;
          $expense->amount = $request->total_pay_amount;
          $expense->description = "Client Fee";
          $expense->expense_type_id = 1;
          $expense->city_id = 1;
          $expense->status = 1;
          $expense->save();
        }
      }



    // dd($expenses_id);
    
    $id = $request->client_id;
    // $expenses = Expense::where('client_id',$id)->where('status',2)->with('expense_type')->get();
    if ($request->expenses) {
      $expenses = json_decode($request->expenses);
      foreach ($expenses as $row) {
        $expense = Expense::where('pickup_id',$row->id)->first();
        if ($expense) {
          // $expense->status = 2;
          // $expense->save();

          // insert into transaction (expense_id - ဘာနဲ့ရှင်းလိုက်တာလဲ)
          $transaction = new Transaction;
          $transaction->bank_id = $request->payment_method;
          $transaction->expense_id = $expense->id;
          $transaction->amount = $expense->amount;
          $transaction->description = "Fix Debit List";
          // $transaction->item_id = $row->id;
          $transaction->save();

          $bank = Bank::find($request->payment_method);
          if($expense->expense_type_id == 5){
            $bank->amount = $bank->amount+$expense->amount;
          }else{
            $bank->amount = $bank->amount-$expense->amount;
          }
          $bank->save();
        }


        // pickup ထဲမှာ ရှင်းပြီးလုပ်ပေးပါ
        // $pickup = Pickup::find($row->id);
        // $pickup->status = 5;
        // $pickup->save();
      }
    }

    // carry fees
    if ($request->carryfees) {
      $carryfees = json_decode($request->carryfees);
      foreach ($carryfees as $row) {
        $expense = Expense::where('item_id',$row->id)->first();
        $expense->status = 2;
        $expense->save();

                // insert into transaction (expense_id - ဘာနဲ့ရှင်းလိုက်တာလဲ)
        $transaction = new Transaction;
        $transaction->bank_id = $request->payment_method;
        $transaction->expense_id = $expense->id;
        $transaction->amount = $expense->amount;
        $transaction->description = "Fix Debit List";
        $transaction->item_id = $row->id;
        $transaction->save();

        $bank = Bank::find($request->payment_method);
        if($expense->expense_type_id == 5){
          $bank->amount = $bank->amount+$expense->amount;
        }else{
          $bank->amount = $bank->amount-$expense->amount;
        }
        $bank->save();

        array_push($item_array, $row->id);
      }
    }




    // reject way
    if ($request->rejects) {
      $rejects = json_decode($request->rejects);
      foreach ($rejects as $row) {

        $item = Item::find($row->id);
        $item->status = 1;
        $item->save();

        $way = Way::where('item_id',$row->id)->first();
        // dd($way->item->deposit);
        $income = new Income;
        $income->delivery_fees = 0;
        $income->deposit = $way->item->deposit;
        $income->amount = $way->item->deposit;
        $income->cash_amount = $way->item->deposit;
        $income->way_id = $way->id;
        $income->status = 0;
        // $income->item_id = $row->id;
        $income->payment_type_id = 1;
        $income->save();

        // insert into transaction ဘာနဲ့ရှင်းလိုက်တာလဲ
        $transaction = new Transaction;
        $transaction->bank_id = $request->payment_method;
        $transaction->income_id = $income->id;
        $transaction->amount = $income->amount;
        $transaction->description = "Fix Debit List";
        $transaction->item_id = $row->id;
        $transaction->save();

        $bank = Bank::find($request->payment_method);
        $bank->amount = $bank->amount+$income->amount;
        $bank->save();

        $way->refund_date = date('Y-m-d');
        $way->save();
        array_push($item_array, $row->id);

      }
    }

    // income

    if ($request->incomes) {
      $incomes = json_decode($request->incomes);
      foreach ($incomes as $row) {
        $item = Item::find($row->id);
        $item->status = 1;
        $item->save();

        // insert into transaction ဘာနဲ့ရှင်းလိုက်တာလဲ
        $bank = Bank::find($request->payment_method);
        $expenses_id = Expense::where('pickup_id',$expenses[0]->id)->get();


        $transaction = new Transaction;
        $transaction->bank_id = $request->payment_method;
        $transaction->item_id = $row->id;
        $transaction->description = "Fix Debit List";
        if(count($expenses_id)){
          foreach ($expenses_id as $value) {
            if($value->expense_type_id == 1){
              $transaction->expense_id = $value->id;
            }
          }
        }
        $transaction->amount = $row->amount;
        $transaction->save();

        $bank->amount = $bank->amount+$row->amount;
        $bank->save();
        array_push($item_array, $row->id);

      }
    }


    // if ($request->expenses) {
    //   $pickup = Pickup::find($expenses[0]->id);
    //   dd($pickup->id);
      
      
    //   foreach ($expenses as $pickup) {
    //     dd($pickup);
    //     $unique_idtem = array_unique($item_array);
    //     $item_count = count($unique_idtem);
    //     if(count($pickup->items) == $item_count){
    //       $pickup = Pickup::find($row->id);

    //       $pickup->status = 5;
    //       $pickup->save();

    //     }
    //   }
    // }

    return back();
  }

  //update imcome
  public function updateincome(Request $request){
    $id=$request->id;
    $income=Income::find($id);
    $income->delivery_fees=$request->deliamount;
    $income->amount=$request->amount;
    $income->save();
    return "success";
  }

//search income by date
public function incomesearch(Request $request){
  $start_date=$request->start_date;
  $end_date=$request->end_date;
  $incomes=Income::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('amount','!=',Null)->where('status',1)->get();
   $myincomes =  IncomeResource::collection($incomes);
   //dd($myincomes);
  return Datatables::of($myincomes)->addIndexColumn()->toJson();
}

//expensesearch
public function expensesearch(Request $request){
  $start_date=$request->start_date;
  $end_date=$request->end_date;
  //dd($end_date);
  $expenses=Expense::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
  //dd($expenses);
   $myexpenses =  ExpenseResource::collection($expenses);

 // dd($myexpenses);
  return Datatables::of($myexpenses)->addIndexColumn()->toJson();
}

  //profit
  public function profit(Request $request){
    $start_date=$request->start_date;
    $end_date=$request->end_date;
    $allincomes=Income::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('status',1)->sum('amount');
    $netincomes=Income::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('status',1)->sum('delivery_fees');
    $allexpenses=Expense::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('expense_type_id','!=',1)->where('status',1)->sum('amount');
    return Response::json(array(
             'allincomes' => $allincomes,
             'netincomes' => $netincomes,
             'expenses' => $allexpenses,
        ));
  }
  // for income list page
  public function incomes($value='')
  {
    // 
    $ways=Way::where('status_code','!=','005')->whereHas('item',function ($query)
    {
      $query->whereDate('assign_date', Carbon\Carbon::today());
    })->get();
    $delivery_men = DeliveryMan::all();
    
    return view('dashboard.incomes',compact('ways','delivery_men'));
  }

  // for add incomes form page
  public function addincomeform($value='')
  {
    $delivery_men=DB::table('delivery_men')
                ->join('users', 'users.id', '=', 'delivery_men.user_id')
                ->select('delivery_men.*', 'users.name as deliveryname')
                ->orderBy('users.name')
                ->get();
    return view('dashboard.addincomes',compact('delivery_men'));
  }

  // get the success ways by deliveryman
  public function successways($id)
  {
    // dd($id);
    $paymenttypes=PaymentType::all();
    $banks=Bank::all();
    $ways = array();
    $data =Way::where('ways.delivery_man_id',$id)
            ->whereHas('item',function ($query)
            {
              $query->whereDate('assign_date', Carbon\Carbon::today());
            })
            // ->where('status_code', '006') // 006 => deliveryman နဲ့ရှင်းပြီး
            // ->whereDate('created_at',Carbon\Carbon::today())
            ->where('status_code', '!=', '005')
            // ->whereDate('created_at', Carbon\Carbon::today())
            ->with('item.pickup.schedule.client.user')
            ->with('item_with_trash.way_with_trash')
            ->with('item_with_trash.township')
            ->with('item_with_trash.SenderGate')
            ->with('item_with_trash.SenderPostoffice')
            ->with('delivery_man.user')
            ->with('item.township')
            ->get();

      foreach ($data as $value) {
          if($value->income){
            if($value->income->status == 0){
              array_push($ways, $value);
            }
          }else{
            array_push($ways, $value);
          }
      }
      // dd($ways);
    // $way =  SuccesswayResource::collection($ways);
    //dd($ways);
    return Datatables::of($ways)->addIndexColumn()->toJson();


    // return Response::json(array(
    //      'ways' => $ways,
    //      'paymenttypes' => $paymenttypes,
    //      'banks'=>$banks,
    // ));

    // return Response::json(array(
    //        'ways' => $ways,
    //        'paymenttypes' => $paymenttypes,
    //        'banks'=>$banks,
    //   ));
  }

  
  // for add incomes method => store
  public function addincomes(Request $request)
  {

    // dd($request->paymenttype);
    //validation
    $request->validate([
      "carryfees" => 'sometimes'
    ]);
   // dd($request->bank);
    $way = Way::find($request->way_id);
    if($request->paystatus == 1){
      if($request->paymenttype == 4){
        $way->item->paystatus = 2;
        $way->item->save();

      }elseif ($request->paymenttype == 5) {
        $way->item->paystatus = 3;
        $way->item->save();
        
      }elseif ($request->paymenttype == 6) {

        $way->item->paystatus = 4;
        $way->item->save();

      }
    }



    $income=new Income;
    $income->delivery_fees=$request->deliveryfee;
    $income->amount=$request->amount;
    $income->payment_type_id=$request->paymenttype;
    $income->way_id=$request->way_id;
    $income->status = 0;

    $income->bank_id = $request->bank;

    if($request->paymenttype==1){
       $income->cash_amount=$request->amount;
    }else if($request->paymenttype==2){
      if($request->bank!="null"){
        // $income->bank_id=$request->bank;
        $income->cash_amount=0;
        $income->bank_amount=$request->amount;
      } 
    }else if($request->paymenttype==3){
      if($request->bank!="null"){
        // $income->bank_id=$request->bank;
        $income->bank_amount=$request->bank_amount;
        $income->cash_amount=$request->cash_amount;
      }
    }else if($request->paymenttype==4){

      $income->amount=null;
      $income->delivery_fees=null;

    }else if($request->paymenttype==5){
      $income->amount=null;
    }else if($request->paymenttype==6){
      $income->amount=null;
      $income->delivery_fees=null;
      $income->deposit=$request->deposit;
    }

    $income->save();

    // $item = Item::where('id',$income->way->item->id)->first();
    // $item->paystatus = $request->paymenttype;
    // $item->paystatus = $request->paymenttype;
    // if($request->paymenttype ==2 || $request->paymenttype == 3){
    //   $item->deposit = 0; 
    // }
    // $item->save();

    // $item = Item::find($income->way->item_id);
    // $item->status = 1;
    // $item->save();

    // insert into transaction and bank
    // if($request->paymenttype==1){
    //    // insert into transaction
    //    $transaction = new Transaction;
    //    $transaction->bank_id = 1;
    //    $transaction->income_id = $income->id;
    //    $transaction->amount = $request->amount;
    //    $transaction->description = "Success Way";
    //    $transaction->save();

    //    $bank = Bank::find(1);
    //    $bank->amount = $bank->amount+$request->amount;
    //    $bank->save();
    // }else if($request->paymenttype==2){
    //   if($request->bank!="null"){
    //     $transaction = new Transaction;
    //     $transaction->bank_id = $request->bank;
    //     $transaction->income_id = $income->id;
    //     $transaction->amount = $request->amount;
    //     $transaction->description = "Success Way";
    //     $transaction->save();

    //     $bank = Bank::find($request->bank);
    //     $bank->amount = $bank->amount+$request->amount;
    //     $bank->save();
    //   } 

    // }else if($request->paymenttype==3){
    //   if($request->bank!="null"){
    //     // $income->bank_id=$request->bank;
    //     $income->bank_amount=$request->bank_amount;
    //     $income->cash_amount=$request->cash_amount;

    //     // to bank
    //     $transaction = new Transaction;
    //     $transaction->bank_id = $request->bank;
    //     $transaction->income_id = $income->id;
    //     $transaction->amount = $request->bank_amount;
    //     $transaction->description = "Success Way";
    //     $transaction->save();

    //     $bank = Bank::find($request->bank);
    //     $bank->amount = $bank->amount+$request->bank_amount;
    //     $bank->save();

    //     // to bank
    //     $transaction = new Transaction;
    //     $transaction->bank_id = 1;
    //     $transaction->income_id = $income->id;
    //     $transaction->amount = $request->cash_amount;
    //     $transaction->description = "Success Way";
    //     $transaction->save();

    //     $bank = Bank::find(1);
    //     $bank->amount = $bank->amount+$request->cash_amount;
    //     $bank->save();
    //   }
    // }else if($request->paymenttype==5){
    //   $transaction = new Transaction;
    //   $transaction->bank_id = $request->bank;
    //   $transaction->income_id = $income->id;
    //   $transaction->amount = $request->deliveryfee;
    //   $transaction->description = "Only Deli";
    //   $transaction->save();

    //   $bank = Bank::find($request->bank);
    //   $bank->amount = $bank->amount+$request->deliveryfee;
    //   $bank->save();
    // }else if($request->paymenttype==6){
    //   $transaction = new Transaction;
    //   $transaction->bank_id = $request->bank;
    //   $transaction->income_id = $income->id;
    //   $transaction->amount = $request->deposit;
    //   $transaction->description = "Only Item Price";
    //   $transaction->save();

    //   $bank = Bank::find($request->bank);
    //   $bank->amount = $bank->amount+$request->deposit;
    //   $bank->save();
    // }

    // if carry fees (carryfees)
    if($request->carryfees){
      $expense = new Expense;
      $expense->amount = $request->carryfees;
      $expense->description = 'Carry Fees';
      $expense->expense_type_id = 5;
      $expense->client_id = $income->way->item->pickup->schedule->client_id;
      $expense->pickup_id = $income->way->item->pickup->id;
      // $expense->staff_id = Auth::user()->delivery_man->id;
      $expense->city_id = 1;
      $expense->item_id = $income->way->item_id;
      $expense->status = 1;
      $expense->save();
    }

    return response()->json(['success'=>'successfully!']);
  }

  // for pickup page => delivery man view
  public function pickups($value='')
  {
    $role=Auth::user()->roles()->first();
    $rolename=$role->name;
    $pickups="";
    if($rolename="delivery_man"){
      $user=Auth::user();
      $id=$user->delivery_man->id;
      $pickups=Pickup::where('delivery_man_id',$id)->doesntHave('items')->get();
      //dd($pickups);
        $data=[];
      foreach ($pickups as $pickup) {
        
       //dd(count($pickup->unreadNotifications));
        if(count($pickup->unreadNotifications)==0){
          //dd("pike");
           Notification::send($pickup,new PickupNotification($pickup));
        }else{
          //dd($pickup->unreadNotifications);
          foreach ($pickup->unreadNotifications as $noti) {
            $data[]=$noti->data['pickup']['id'];
            if(!in_array($pickup->id, $data)){
               Notification::send($pickup,new PickupNotification($pickup));
            }
            # code...
          }
        }    
      }
      $pickups=Pickup::where('delivery_man_id',$id)->doesntHave('items')->get();

    }
    //dd($pickups);
    return view('dashboard.pickups',compact('pickups'));
  }

  public function pickupdone($id,$qty){
    $pickup=Pickup::find($id);

    if($qty==0){  
      $pickup->status=3;
      $pickup->save();
    }else{
      $pickup->status=1;
      $pickup->save();
    }

    $pickup->schedule->status = 1;
    $pickup->schedule->save();

    return redirect()->route('pickups')->with("successMsg",'Pickup successfully'); 
  }

  // for way page => delivery man view
  public function pending_ways($value='')
  {
    





    // $pending_ways = Way::where('status_code','!=',001)->where('status_code','!=',002)
    //                 ->where('deleted_at',null)
    //                 ->with(array('delivery_man'=>function($q){
    //                     $q->where('city_id','!=','1')->get();
    //                 }))
    //                 ->with(array('item'=>function($query){
    //                     $query->where('township_id',"!=",null)->get();
    //                 }))
    //                 ->orderBy('id','desc')
    //                 ->whereDate('created_at',Carbon\Carbon::today())->get();

    
   

    // foreach ($pending_ways as $value) {

    //    if($value->delivery_date == null && $value->item->township_id != null){
    //     dd($value->id);
    //     $way = Way::find($value->id);
    //     $way->status_code = "002";
    //     $way->status_id = 2;
    //     $way->remark = "မပို့ဖြစ်ပါ";
    //     // $way->save();
    //     // $way->delete();

    //     $day = $way->created_at;
    //     $date = date('Y-m-d',strtotime($day."+1 day"));
    //     $way->item->expired_date = $date;
    //     $way->item->error_remark = "မပို့ဖြစ်ပါ";
    //     // $way->item->save();
    //     }
    //   }








    // pending_ways assigned for that user (must delivery_date and refund_date equal NULL)
    
    if(Auth::user()->delivery_man->city_id == 1){
      $pending_ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->whereDate('created_at',Carbon\Carbon::today())->where('status_code','!=',001)->where('status_code','!=',002)->where('deleted_at',null)->orderBy('id','desc')->whereHas('item')->get();
    }else{
      $pending_ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->where('status_code','!=',002)->where('deleted_at',null)->orderBy('id','desc')->whereHas('item')->get();
    }

    foreach ($pending_ways as $way) {
      $notifications=DB::table('notifications')->select('data')->where('notifiable_type','App\Way')->get();
        // dd($notifications);
         $data = [];
        if(count($notifications)>0){
            //dd("hi");
            foreach ($notifications as $noti) {
                $notiarray=json_decode($noti->data);
                $data[] = $notiarray->ways->id;
            }
        }

        if(Carbon\Carbon::today()->toDateString()==$way->created_at->toDateString() && $way->status_code==005 && !in_array($way->id, $data)){
          Notification::send($way,new SeenNotification($way));
          //dd("ok");
          //event(new rejectitem($way));
        }
    }

    $townships= DB::table('ways')
    ->select('townships.name as township_name','townships.id as township_id')
    ->join('items', 'items.id', '=', 'ways.item_id')
    ->join('townships', 'townships.id', '=', 'items.township_id')
    ->where('ways.delivery_man_id', Auth::user()->delivery_man->id)
    ->orderBy('townships.name','asc')
    ->distinct()
    ->get();

   // dd($townships);
   $gates=DB::table('ways')
    ->select('sender_gates.name as gate_name','sender_gates.id as gate_id')
    ->join('items', 'items.id', '=', 'ways.item_id')
    ->join('sender_gates', 'sender_gates.id', '=', 'items.sender_gate_id')
    ->where('ways.delivery_man_id', Auth::user()->delivery_man->id)
    ->orderBy('sender_gates.name','asc')
    ->distinct()
    ->get();


    $postoffices=DB::table('ways')
      ->select('sender_postoffices.name as office_name','sender_postoffices.id as office_id')
      ->join('items', 'items.id', '=', 'ways.item_id')
      ->join('sender_postoffices', 'sender_postoffices.id', '=', 'items.sender_postoffice_id')
      ->where('ways.delivery_man_id', Auth::user()->delivery_man->id)
      ->orderBy('sender_postoffices.name','asc')
      ->distinct()
      ->get();

    $paymenttypes = PaymentType::all();
    $banks = Bank::all();

    return view('dashboard.pending_ways',compact('pending_ways','townships','gates','postoffices','paymenttypes','banks'));
  }

  public function success_ways($value='')
  {
    $success_ways = Way::with('income')->where('delivery_man_id',Auth::user()->delivery_man->id) ->where('status_code',001)->whereHas('item',function ($query){
      $query->whereDate('assign_date',Carbon\Carbon::today());
    })->orderBy('id','desc')->get();
    //dd($success_ways);

    return view('dashboard.success_ways',compact('success_ways'));
  }

  public function makeDeliver(Request $request)
  {
    $ways = $request->ways;
    // dd($ways);
    foreach ($ways as $way) {
      $way = Way::where('id',$way)->first();
      //dd($way);
      $way->status_id = 1;
      $way->status_code = '001';
      $way->remark =Null;
      $way->delivery_date = date('Y-m-d');
      $way->save();
    }
   return response()->json(['success'=>'successfully!']);
  }

  public function retuenDeliver(Request $request)
  {
    //dd($request);
     $request->validate([
            'remark' => 'required',
            'date' => 'required'
        ]);
      $wayid = $request->wayid;
      $mytime = Carbon\Carbon::now();
      //dd($ways);
      $way = Way::where('id',$wayid)->first();
      //dd($way);
      $way->status_id = 2;
      $way->status_code = '002';
      $way->remark = $request->remark;
      $way->save();
      // $way->delete();
      $way->item->expired_date = $request->date;
      $way->item->error_remark = $request->remark;
      $way->item->save();

    return response()->json(['success'=>'successfully!']);
  }

  public function rejectDeliver(Request $request)
  {
     // $request->validate([
     //        'remark' => 'required',
     //    ]);
      $wayid = $request->wayid;
    
      $way = Way::where('id',$wayid)->first();
      $way->remark = "မယူဖြစ်တော့ပါ";
      $way->save();
    //   if($way->status_id!=3){
    //   $way->status_id = 3;
    //   $way->status_code = '003';
    //   // $way->refund_date = date('Y-m-d');
    //   $way->remark = $request->remark;
    //   $way->deleted_at=Null;
    //   $way->save();
    //   //$waynoti="reject";
    //   Notification::send($way,new RejectNotification($way));
    // //dd("ok");
    // event(new rejectitem($way));
    //   }
      //dd($way);
     
      
   return response()->json(['success'=>'successfully!']);
  }

  // for cancel list => client side
  public function cancel($value='')
  {
    $client_id=Auth::user()->client->id;
    // $ways = Way::where('status_id',3)->get();

    $ways =  Way::with('item.pickup.schedule')->whereHas('item.pickup.schedule', function($query) use ($client_id){
        $query->where('client_id', $client_id);
    })->where('status_code','003')->get();

    return view('dashboard.cancel',compact('ways'));
  }

  public function rejectnoti(){
    //$notidata=array();
    $cs=array();
    if(Auth::check()){
      $rejectways=Way::where('status_code','003')->orderBy('id','desc')->get();
     // dd($rejectways);
     foreach ($rejectways as $ways) {
        foreach ($ways->unreadNotifications as $notification) {
          if($notification->data["ways"]["status_code"]=="003"){
            array_push($cs, $notification->data);
          }
        }
       # code...
     }
    }
   // dd($cs);
    return $cs;

  /* for($i=0;$i<count($cs);$i++){
    array_push($notidata, $cs)
     
  }*/
   }

   /*public function clearrejectnoti($id){
   // dd($id);
    $mytime = Carbon\Carbon::now();
      $date=$mytime->toDateString();
      $userconfirm= DB::table('notifications')->where('id', $id)->update(array('read_at' => $date));
      return redirect()->route('reject_list');
   }*/


  
  public function getitembyway(Request $request)
  {
    $wayid = $request->wayid;
    $way = Way::find($wayid);
    $item =$way->item;
    return $item;
  }

  public function waysreport(Request $request){
    //dd($request->deliveryman);

    $start_date=$request->start_date;
    $end_date=$request->end_date;
    // dd($start_date);
    // $ways=DeliveryMan::with('ways')->whereHas('ways',function($query) use($start_date,$end_date){
    //   $query->whereBetween('delivery_date', [$start_date,$end_date])->where('status_code','001');
    // })
    // //->orWhereDoesntHave('ways')
    // ->with('pickups')->orwhereHas('pickups',function($query) use($start_date,$end_date){
    //   $query->whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('status','1');
    // })
    // // ->orWhereDoesntHave('pickups')
    // ->with('user')->with('ways.item')->get();


    $ways=DeliveryMan::with('ways')->whereHas('ways',function($query) use($start_date,$end_date){
      $query->whereBetween('delivery_date', [$start_date,$end_date])->where('status_code','001');
    })

   
    //->orWhereDoesntHave('ways')
    ->with('pickups')->orwhereHas('pickups',function($query) use($start_date,$end_date){
      $query->whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('status','1');
    })
    // ->orWhereDoesntHave('pickups')
    ->with('user')->with('ways.item')->get();

    // dd($ways);

    return Datatables::of($ways)->addIndexColumn()->toJson();
  }



  public function successreport(Request $request){
    $start_date=$request->start_date;
    $end_date=$request->end_date;
    $success_export=new SuccesslistExport($start_date,$end_date);
    return Excel::download($success_export,'success.xlsx');

  }


  public function editamountandqty(Request $request){
    $validator = $request->validate([
      'quantity'=>['required'],
      'amount'=>['required']
    ]);
    
    if($validator){
      $id=$request->schedule_id;
      $amount=$request->amount;
      $quantity=$request->quantity;

      $schedule=Schedule::find($id);
      $schedule->amount=$amount;
      $schedule->quantity=$quantity;
      $schedule->save();
      $pickup=Pickup::where('schedule_id',$id)->first();
      $pickup->status=1;
      $pickup->save();
      return response()->json(['success'=>'successfully!']);
    }
  }

  public function editprepaidamount(Request $request){
    $validator = $request->validate([
      'pickup_id'=>['required'],
      'prepaidamount'=>['required']
    ]);
    
    if($validator){
      $id=$request->pickup_id;
      $prepaidamount=$request->prepaidamount;

      $expense=Expense::where('pickup_id',$id)->first();
      $oldexpense = $expense->amount;
      $expense->amount=$prepaidamount;
      $expense->save();

      $transaction=Transaction::where('expense_id',$expense->id)->first();
      $transaction->amount=$prepaidamount;
      $transaction->save();

      $bank=$transaction->bank;
      $bank->amount += $oldexpense;
      $bank->amount -= $transaction->amount;
      $bank->save();

      return response()->json(['success'=>'successfully!']);
    }
  }

  public function normal($id){
    $way=Way::find($id);
    $way->status_code="005";
    $way->delivery_date=Null;
    $way->status_id=5;
    $way->save();

    $income = $way->income;
    $income->delete();

    return redirect()->route('success_ways')->with("successMsg",'edit successfully');
  }

  public function debt_history($value='')
  {
     $clients=DB::table('clients')
                ->join('users', 'users.id', '=', 'clients.user_id')
                ->select('clients.*', 'users.name as clientname')
                ->orderBy('users.name')
                ->get();
    return view('dashboard.debt_history',compact('clients'));
  }

  public function way_history($value='')
  {
    return view('dashboard.way_history');
  }


  public function getwayhistory(Request $request){
    $sdate = $request->sdate;
    $edate = $request->edate;
   // dd($sdate);
    $ways = Way::withTrashed()->with('item.pickup.schedule.client.user','delivery_man.user')->where('status_code','!=','005')->whereBetween('updated_at', [$sdate.' 00:00:00',$edate.' 23:59:59'])->get();
   // dd($ways);
    return Datatables::of($ways)->addIndexColumn()->toJson();
  }

  public function pickup_history(){
       // dd($pickups);
  $clients=DB::table('clients')
                ->join('users', 'users.id', '=', 'clients.user_id')
                ->select('clients.*', 'users.name as clientname')
                ->orderBy('users.name')
                ->get();
    $role=Auth::user()->roles()->first();
    $rolename=$role->name;
    $pickups="";
    if($rolename=="client"){
      $client_id=Auth::user()->client->id;
      $pickups=Pickup::with('schedule')->whereHas('schedule',function ($query) use ($client_id){
        $query->where('client_id', $client_id);
      })->where("status",1)->orderBy('id','desc')->get();
      //dd($pickups);
    }
      return view('dashboard.pickup_history',compact('clients','pickups'));
    }

  public function pickupbyclient(Request $request){
    $sdate = $request->sdate;
    $edate = $request->edate;
    $client_id=$request->client_id;
    $role=Auth::user()->roles()->first();
    $rolename=$role->name;
    $pickups="";

    if($rolename=="client"){
      $client_id=Auth::user()->client->id;
      $pickups=Pickup::with('schedule.client.user')->whereHas('schedule',function ($query) use ($client_id,$sdate,$edate){
        $query->where('client_id', $client_id)->whereBetween('pickup_date', [$sdate.' 00:00:00',$edate.' 23:59:59']);
      })->where("status",4)->get();
    }else if($rolename=="staff"){
      if($client_id==null){
        $pickups=Pickup::with('schedule.client.user')->whereHas('schedule',function ($query) use ($sdate,$edate){
          $query->whereBetween('pickup_date', [$sdate.' 00:00:00',$edate.' 23:59:59']);
        })->where("status",4)->with('items.expense')->get();
      }else if($sdate==null && $edate==null){
        $pickups=Pickup::with('schedule.client.user')->whereHas('schedule',function ($query) use ($client_id){
          $query->where('client_id', $client_id);
        })->where("status",4)->with('items.expense')->get();
      }else{
        $pickups=Pickup::with('schedule.client.user')->whereHas('schedule',function ($query) use ($client_id,$sdate,$edate){
          $query->where('client_id', $client_id)->whereBetween('pickup_date', [$sdate.' 00:00:00',$edate.' 23:59:59']);
        })->where("status",4)->with('items.expense')->get();
      }
    }
    return Datatables::of($pickups)->addIndexColumn()->toJson();
 }


  public function historydetails($id){
    //dd($id);
    $items=Item::with('way')->where('pickup_id',$id)->get();
    //dd($items);
    return view('dashboard.itembyclient',compact('items'));
  }

  public function banktransfer(){
    $banks=Bank::all();
    return view('dashboard.banktransfer',compact('banks'));
  }

  public function transfer(Request $request){
    $validator = $request->validate([
            'frombank'  => ['required'],
            'tobank'  => ['required'],
            'amount'  => ['required']
      ]);

       if($validator){
        $amount=$request->amount;
           $frombank=Bank::find($request->frombank);
           $fromamount=$frombank->amount;
           //dd($fromamount);
           $tobank=Bank::find($request->tobank);
           $toamount=$tobank->amount;

           if($amount<=$fromamount && $frombank->id!=$tobank->id ){

             $frombank->amount=$fromamount-$amount;
            
             $tobank->amount=$tobank->amount+$amount;
              $frombank->save();
             $tobank->save();
             $transaction=new Transaction;
             $transaction->bank_id=$request->frombank;
             $transaction->amount=$request->amount;
             $transaction->tobank_id=$request->tobank;
             $transaction->description="Transaction bank";
             $transaction->save();
            return redirect()->route('banktransfer')->with("successMsg",'transfer successfully');

           }else{
             return redirect()->route('banktransfer')->with("successMsg",'transfer not success try again!');
           }
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
  }


  public function waybydeliveryman(Request $request){

    // get delivery man id
    $id=$request->id;
    
    $deliveryman = DeliveryMan::find($id);
    if ($deliveryman->city_id != 1) {
      $ways = Way::where('delivery_man_id',$id)
            ->with('item.township')
            ->with('item.SenderGate')
            ->with('item.SenderPostoffice')
            ->where('status_code','!=',001)
            ->where('status_code','!=',002)
            ->where('deleted_at',null)
            ->orderBy('id','desc')
            ->with('item.pickup.schedule.client.user')
            ->with('delivery_man.user')
            ->with('item.township')->get();
    }else{
      $ways = Way::where('delivery_man_id',$id)
            ->whereHas('item',function ($query)
            {
              $query->whereDate('assign_date',Carbon\Carbon::today());
            })
            ->with('item.township')
            ->with('item.SenderGate')
            ->with('item.SenderPostoffice')
            ->where('status_code','!=',001)
            ->where('status_code','!=',002)
            ->where('deleted_at',null)
            ->orderBy('id','desc')
            ->with('item.pickup.schedule.client.user')
            ->with('delivery_man.user')
            ->with('item.township')->get();
    }
    
    // dd($ways);
    return Datatables::of($ways)->addIndexColumn()->toJson();
    // return $ways;
  }

  public function createpdf(Request $request){
    $id=$request->id;
    $deliveryman=DeliveryMan::find($id);
    $deliname=$deliveryman->user->name;

   // dd($id);
    $ways = Way::where('delivery_man_id',$id)->where('status_code','!=',001)->where('status_code','!=',002)->where('deleted_at',null)->orderBy('id','desc')->whereDate('created_at',Carbon\Carbon::today())->get();
      $data = array(
    'ways' => $ways,
    'deliveryman' => $deliveryman,
        );
      view()->share('data',$data);
      $pdf = PDF::loadView('dashboard.waypdf')->setPaper('a4', 'landscape');

      // download PDF file with download method
      return $pdf->download( $deliname.'.pdf');
      
  }

  public function pendingwaysbytownship(Request $request){
    $id=$request->id;
    //dd($id);
    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->where('status_code','!=',002)->where('deleted_at',null)->orderBy('id','desc')->with('item.pickup.schedule.client.user')->with('item.SenderGate')->with('item.SenderPostoffice')->with('item.township')->whereHas('item',function ($query) use ($id){
        $query->where('township_id', $id);
      })->get();
    //dd($ways);

    return $ways;

  }

  public function pendingwaysbygate(Request $request){
     $id=$request->id;
    //dd($id);
    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->where('status_code','!=',002)->where('deleted_at',null)->orderBy('id','desc')->with('item.pickup.schedule.client.user')->with('item.SenderGate')->with('item.SenderPostoffice')->with('item.township')->whereHas('item',function ($query) use ($id){
        $query->where('sender_gate_id', $id);
      })->get();
    //dd($ways);

    return $ways;
  }

  public function pendingwaysbyoffice(Request $request){
     $id=$request->id;
    //dd($id);
    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->where('status_code','!=',002)->where('deleted_at',null)->orderBy('id','desc')->with('item.pickup.schedule.client.user')->with('item.SenderGate')->with('item.SenderPostoffice')->with('item.township')->whereHas('item',function ($query) use ($id){
        $query->where('sender_postoffice_id', $id);
      })->get();
    //dd($ways);

    return $ways;
  }

  public function today_list()
  {
    if(Auth::user()->delivery_man->city_id == 1){
      $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)

      
      ->whereHas('item',function ($query)
      {
        $query->where('assign_date',Carbon\Carbon::today());
      })
      // return ကို list တစ်ခုထုတ်ပြပေးမယ်
      // ->whereDate('created_at',Carbon\Carbon::today())
      ->get();
    }else{
      $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->orderBy('id','desc')->get();
    }

    $paymenttypes = PaymentType::all();
    $banks = Bank::all();
    
    return view('dashboard.today_list',compact('ways','paymenttypes','banks'));
  }


  public function income_status_change(Request $request)
  {
    
    $d = implode(',', $request->id);
    $a = explode(',',$d);
    $array = array_unique($a);
    $way_array = array();
    
    
    foreach ($array as $data) {
      $way = Way::where('id',$data)->first();
      if($way){
        if($way->status_code == '002' && $way->remark){
          $way->delete();
        }else{
          array_push($way_array, $way);
        }
      }
    
    }
    // dd($way_array);
    foreach ($way_array as $value) {
     $income = Income::where('way_id',$value->id)->first();
     if($income){
       $income->status = 1;
       $income->save();


    if($income->payment_type_id == 1){
        $transaction = new Transaction;
        $transaction->bank_id = 1;
        $transaction->income_id = $income->id;
        $transaction->description = "Success Way";
        $transaction->amount = $income->cash_amount;
        $transaction->item_id = $income->way->item_id;
        $transaction->save();

        $bank = Bank::find(1);
        $bank->amount = $bank->amount+$income->cash_amount;
        $bank->save();
        
    }else if($income->payment_type_id == 2){

      if($income->bank_id != 1){
        $transaction = new Transaction;
        $transaction->bank_id = $income->bank_id;
        $transaction->income_id = $income->id;
        $transaction->amount = $income->bank_amount;
        $transaction->description = "Success Way";
        $transaction->item_id = $income->way->item_id;
        $transaction->save();

        $bank = Bank::find($income->bank_id);
        $bank->amount = $bank->amount + $income->bank_amount;
        $bank->save();
      }

     }else if($income->payment_type_id == 3){

      if($income->bank_id != 1){
          $transaction = new Transaction;
          $transaction->bank_id = $income->bank_id;
          $transaction->income_id = $income->id;
          $transaction->amount = $income->bank_amount;
          $transaction->description = "Success Way";
          $transaction->item_id = $income->way->item_id;
          $transaction->save();

          $bank = Bank::find($income->bank_id);
          $bank->amount = $bank->amount + $income->bank_amount;
          $bank->save();

          $transaction = new Transaction;
          $transaction->bank_id = 1;
          $transaction->income_id = $income->id;
          $transaction->amount = $income->bank_amount;
          $transaction->item_id = $income->way->item_id;
          $transaction->description = "Success Way";
          $transaction->save();

          $bank = Bank::find(1);
          $bank->amount = $bank->amount + $income->cash_amount;
          $bank->save();
      }

     }else if($income->payment_type_id == 5){

          $transaction = new Transaction;
          $transaction->bank_id = $income->bank_id;
          $transaction->income_id = $income->id;
          $transaction->amount = $income->way->item->delivery_fees;
          $transaction->description = "Only Delivery Fees";
          $transaction->item_id = $income->way->item_id;
          $transaction->save();

          $bank = Bank::find($income->bank_id);
          $bank->amount = $bank->amount + $income->way->item->delivery_fees;
          $bank->save();


     }else if($income->payment_type_id == 6){
          $transaction = new Transaction;
          $transaction->bank_id = $income->bank_id;
          $transaction->income_id = $income->id;
          $transaction->amount = $income->way->item->deposit;
          $transaction->item_id = $income->way->item_id;
          $transaction->description = "Only Item Price";
          $transaction->save();

          $bank = Bank::find($income->bank_id);
          $bank->amount = $bank->amount + $income->way->item->deposit;
          $bank->save();
     }
     }

     // insert into transaction and bank

    }
    return redirect()->route('incomes');
    
  }
}