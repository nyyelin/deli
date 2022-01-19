<?php

namespace App\Http\Controllers;

use App\Item;
use App\Client;
use App\Pickup;
use App\Township;
use App\DeliveryMan;
use App\Way;
use App\Expense;
use Carbon;
use Auth;
use App\SenderGate;
use App\SenderPostoffice;
use Session;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use App\Bank;
use App\Transaction;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\DeliveryManResource;
use App\Notifications\RejectNotification;
use Notification;
use App\Events\rejectitem;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$items=Item::doesntHave('way')->get();
      // $items=Item::whereHas('pickup',function($query){
      //         $query->where('status',4);
      //       })->with(array('way'=>function($q){
      //         $q->where('remark','==',null)->where('deleted_at','==',null)->get();
      //       }))->get();

      $items=Item::whereHas('pickup',function($query){
              $query->where('status',4);
            })->doesntHave('way')->get();
      // dd($items);
    
      $deliverymen = DeliveryMan::with(['townships'=> function($q){
                     $q->orderBy('name','asc');
                      }])->get();

      //dd($deliverymen);
      $ways = Way::orderBy('id', 'desc')->get();

      $notifications=DB::table('notifications')->select('data')->where('notifiable_type','App\Way')->get();
      $data=[];
      foreach ($notifications as $noti) {
        $notiway=json_decode($noti->data);
        if($notiway->ways->status_code=="005"){
          array_push($data, $notiway->ways);
        }
      }
      // dd($items);
      return view('item.index',compact('items','deliverymen','ways','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $deliverymen = DeliveryMan::all();
      return view('item.create',compact('deliverymen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $qty=$request->qty;
       // dd($qty);
      $myqty=$request->myqty;
      $damount=$request->depositamount;

      //dd($damount);
      $validator = $request->validate([
        'receiver_name'  => ['required','string'],
        // 'receiver_phoneno'=>['required','string'],
        // 'receiver_address'=>['required','string'],
        // 'expired_date'=>['required','date'],
        'assign_date'=>['required','date'],
        'deliveryman'=>['required'],
        'delivery_fees'=>['required'],
        // 'amount'=>['required'],
      ]);

      if($request->rcity==1){
        $validator = $request->validate([
            'receiver_township'=> ["required"],
        ]);
      }elseif($request->rcity==2){
        $validator = $request->validate([
            'mygate' => ["required"],
            
        ]);
      }elseif($request->rcity==3){
        $validator = $request->validate([
           
            'myoffice'=> ["required"],
        ]);
      }
      // dd($request->receiver_township);
      

      if($validator){
        $item=new Item;
        $item->codeno=$request->codeno;
        $item->receiver_name=$request->receiver_name;
        $item->receiver_address=$request->receiver_address;
        $item->receiver_phone_no=$request->receiver_phoneno;

        if($request->receiver_township != 0){
        $item->township_id=$request->receiver_township;
        }

        $item->expired_date=$request->expired_date;
        // $item->expired_date=$request->expired_date;
        $item->assign_date=$request->assign_date;
        $item->deposit=$request->deposit;
        $item->delivery_fees=$request->delivery_fees;
        // $item->other_fees=$request->othercharges;
        if($request->amount == 0){
          $item->amount = $request->deposit + $request->delivery_fees;
        }else{
          $item->amount =$request->amount;
        }
        $item->paystatus=$request->amountstatus;
        $item->remark=$request->remark;
        $item->pickup_id=$request->pickup_id;

        if($request->mygate!=0){
          $item->sender_gate_id=$request->mygate;
        }

        if($request->myoffice!=0){
          $item->sender_postoffice_id=$request->myoffice;
        }

        $role=Auth::user()->roles()->first();
        $rolename=$role->name;
        if($rolename=="staff"){
          $user=Auth::user();
          $staffid=$user->staff->id;
          $item->staff_id=$staffid;
        }
        $item->save();

        ///////////////// assign way directly ////////////////
        $way=new Way;
        $way->status_code="005";
        $way->item_id=$item->id;
        $way->delivery_man_id=$request->deliveryman;
        $role=Auth::user()->roles()->first();
        $rolename=$role->name;
          if($rolename=="staff"){
            $user=Auth::user();
            $staffid=$user->staff->id;
            $way->staff_id=$staffid;
        }
        $way->status_id=5;
        $way->save();
        ////////////// end assign ways /////////////

        // if($request->paystatus == 1 && $request->paidamount != null){
        //   $expense = new Expense;
        //   $expense->amount=$request->paidamount;
        //   $expense->client_id=$request->client_id;
        //   if($rolename=="staff"){
        //     $user=Auth::user();
        //     $staffid=$user->staff->id;
        //     $expense->staff_id=$staffid;
        //   }
        //   $expense->status=$request->paystatus;
        //   $expense->description="Client Deposit";
        //   $expense->pickup_id = $request->pickup_id;
        //   $expense->city_id=1;
        //   $expense->expense_type_id=1;
        //   $expense->save();

        //   // transaction
        //   $transaction = new Transaction;
        //   $transaction->bank_id = $request->payment_method;
        //   $transaction->expense_id = $expense->id;
        //   if($request->paidamount!=null){
        //      $transaction->amount = $request->paidamount;
        //   }else{
        //     $transaction->amount = $request->depositamount;
        //   }
        //   $transaction->description = "Client Deposit";
        //   $transaction->save();

        //   $bank = Bank::find($request->payment_method);
        //    if($request->paidamount!=null){
        //     $bank->amount=$bank->amount-$request->paidamount;
        //    }else{
        //      $bank->amount = $bank->amount-$request->depositamount;
        //    }
        //   $bank->save();
        // }
        
        // $pickup = Pickup::find($item->pickup_id);
        // if (($pickup->schedule->quantity - count($pickup->items)) > 0) {
          return redirect()->back()->with("successMsg",'New Item is ADDED');
        // }else{
        //   $pickup->status = 1;
        //   $pickup->save();
        //   return redirect()->route('items.index')->with("successMsg",'New Item is ADDED in your data');
        // }
      }
      else
      {
        return redirect::back()->withErrors($validator);
      }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $item=$item;
        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $item=$item;
        $townships=Township::orderBy('name','asc')->get();
        $sendergates=SenderGate::orderBy('name','asc')->get();
        $senderoffice=SenderPostoffice::orderBy('name','asc')->get();
        $deliverymen = DeliveryMan::all();

        return view('item.edit',compact('item','townships','sendergates','senderoffice','deliverymen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
      // dd($request);
      $validator = $request->validate([
        'receiver_name'  => ['required','string'],
        // 'receiver_phoneno'=>['required','string'],
        // 'receiver_address'=>['required','string'],
        // 'receiver_township'=>['required'],
        'assign_date'=>['required','date'],
        // 'expired_date'=>['required','date'],
        'deposit'=>['required'],
        'delivery_fees'=>['required'],
        // 'amount'=>['required'],
      ]);

      if($request->rcity==1){
        $validator = $request->validate([
            'receiver_township'=> ["required"],
        ]);
      }elseif($request->rcity==2){
        $validator = $request->validate([
            'mygate' => ["required"],
            
        ]);
      }elseif($request->rcity==3){
        $validator = $request->validate([
           
            'myoffice'=> ["required"],
        ]);
      }

      if($validator){
        $item->codeno=$request->codeno;
        $item->receiver_name=$request->receiver_name;
        $item->receiver_address=$request->receiver_address;
        $item->receiver_phone_no=$request->receiver_phoneno;
        // $item->township_id=$request->receiver_township;
        if($request->receiver_township != 0){
        $item->township_id=$request->receiver_township;
        }

        // $item->expired_date=$request->expired_date;
        $item->assign_date=$request->assign_date;
        $item->deposit=$request->deposit;
        $item->delivery_fees=$request->delivery_fees;
        // $item->other_fees=$request->othercharges;
        if($request->amount == 0){
          $item->amount = $request->deposit + $request->delivery_fees;
        }else{
          $item->amount =$request->amount;
        }
        $item->paystatus=$request->amountstatus;
        $item->remark=$request->remark;

        if($request->mygate!= 0){
          $item->sender_gate_id=$request->mygate;
        }
        if($request->myoffice!=0 ){
          $item->sender_postoffice_id=$request->myoffice;
        }
        $role=Auth::user()->roles()->first();
        $rolename=$role->name;
        if($rolename=="staff"){
          $user=Auth::user();
          $staffid=$user->staff->id;
          $item->staff_id=$staffid;
        }
        $item->save();

        ///////////////// update assign way directly ////////////////
        $way=Way::where('item_id',$item->id)->first();
        $way->delivery_man_id=$request->delivery_man;
        $way->save();
        ////////////// end assign ways /////////////

        return redirect()->route('items.index')->with("successMsg",'Updatesuccessfully');
      }else{
        return redirect::back()->withErrors($validator);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item=$item;
        $item->delete();
       return redirect()->route('items.index')->with('successMsg','Existing Item is DELETED in your data');
    }

    // here accept client id
    public function collectitem($cid, $pid)
    {

        $itemcode="";
        $client = Client::find($cid);
        $codeno=$client->codeno;
        // dd($codeno);
        $mytime = Carbon\Carbon::now();
        //dd($checktime);
        $array = explode('-', $mytime->toDateString());
        $datecode=$array[2]."001";
        
        // dd($datecode);
        // $items=Item::all();
        $item=Item::whereDate('created_at',Carbon\Carbon::today())->orderBy('id','desc')->first();
        //dd($item);
        if(!$item){
           $itemcode=$codeno.$datecode;
           // dd($itemcode);
        }else{
        $code=$item->codeno;
        $mycode=substr($code, 11,14);
        //dd($mycode);
        $itemcode=$codeno.$array[2].$mycode+1;
            
        }
        //dd($itemcode);
        //dd($datecode);
        $pickup = Pickup::find($pid);
        // $townships=Township::all();
        $townships = Township::orderBy('name','asc')->get();

        $sendergates=SenderGate::orderBy('name','asc')->get();
        $senderoffice=SenderPostoffice::orderBy('name','asc')->get();

        $pickupeditem = Item::where('pickup_id',$pickup->id)->orderBy('id','desc')->first();
        $banks = Bank::orderBy('name','asc')->get();
        $deliverymen = DeliveryMan::all();

        return view('item.create',compact('banks','client','pickup','townships','itemcode','pickupeditem','sendergates','senderoffice','deliverymen'));
    }


    public function delichargebytown(Request $request){
       $id=$request->id;
       //dd($id);
       $township=Township::find($id);
       $deliveryman = DeliveryMan::with('user')->with('townships')->get();
       // $value = $township->delivery_men;

       $value = DeliveryMan::with('townships')->whereHas('townships',function ($query) use ($id)
       {
         $query->where('township_id',$id);
       })->orWhere('status',1)->get();

       $data = DeliveryManResource::collection($value);

       $deliverycharge=$township->delivery_fees;
       $array = [ 'deliverycharge' => $deliverycharge,
                  'delivery_men' => $data,
                  'alldelivery_man' => $deliveryman];
       return $array;
    }

    public function getdeliveryman(Request $request)
    {
      // $township = Township::find($request->id);
      // $deliverymen = $township->with('delivery_men')->get();
      $deliverymen = DeliveryMan::with('user')->get();
      return $deliverymen;
    }

    public function itemdetail(Request $request){
        $id=$request->id;
        $item=Item::find($id);
        return $item;
    }

    public function assignWays(Request $request)
    {
        //dd($request);
        $myways=$request->ways;
        //dd($myways);
        foreach($myways as $myway){

            // $ways = Way::where('item_id',$myway)->withTrashed()->get();
            // foreach ($ways as $value) {
            //   $value->deleted_at = null;
            //   $value->save();
            // }

            // $ways = Way::where('item_id',$myway)->withTrashed()->get();
            // foreach ($ways as $value) {
            //   $value->deleted_at = null;
            //   $value->save();
            // }

            $item = Item::find($myway);
            $item->assign_date = $request->assign_date;
            $item->save();

            $way=new Way;
            $way->status_code="005";
            $way->item_id=$myway;
            $way->delivery_man_id=$request->delivery_man;
            $role=Auth::user()->roles()->first();
            $rolename=$role->name;
              if($rolename=="staff"){
                $user=Auth::user();
                $staffid=$user->staff->id;
                $way->staff_id=$staffid;
            }
            $way->status_id=5;
            $way->save();
        }
      return redirect()->route('items.index')->with("successMsg",'way assign successfully');
    }


    public function updatewayassign(Request $request){
        $id=$request->wayid;

        $way=Way::find($id);
        $way->delivery_man_id=$request->delivery_man;
        $role=Auth::user()->roles()->first();
        $rolename=$role->name;
          if($rolename=="staff"){
            $user=Auth::user();
            $staffid=$user->staff->id;
            $way->staff_id=$staffid;
        }
        $way->save();
        return redirect()->route('items.index')->with("successMsg",'way assign update successfully');
    }

    public function deletewayassign($id){
        $way=Way::find($id);
        $way->delete();
        
        $item = $way->item;
        $item->delete();

        $pickup = Pickup::find($item->pickup_id);
        $pickup->status = 1;
        $pickup->save();

        return redirect()->route('items.index')->with("successMsg",'way assign delete successfully');
    }

    // public function townshipbystatus(Request $request){
    //     $id=$request->id;
    //     $township=Township::where('status',$id)->get();
    //     return $township;
    // }

    public function checkitem($pickupid){
    

    $checkitems=Item::where('pickup_id',$pickupid)->get();
    $banks = Bank::all();
    return view('dashboard.checkitem',compact('checkitems','banks'))->with("successMsg",'items amount are wrong');
      //dd($pickupid);
      
    }

    public function updateamount(Request $request){
      $checkitemarray=$request->myarray;
      foreach ($checkitemarray as $value) {

       $item=Item::find($value["id"]);
       $deliveryfee=$item->delivery_fees;
       $item->deposit=$value["amount"];
       $item->amount=$value["amount"]+$deliveryfee;
       $item->save();

       $pickup=Pickup::find($item->pickup_id);
       $pickup->status=1;
       $pickup->save();
      }

      $expense=new Expense;
      $expense->amount=$request->totaldeposit;
      $expense->client_id=$pickup->schedule->client_id;
      $role=Auth::user()->roles()->first();
      $rolename=$role->name;
      
      if($rolename=="staff"){
        $user=Auth::user();
        $staffid=$user->staff->id;
        $expense->staff_id=$staffid;
      }
      $expense->status=$request->paystatus;
      $expense->description="Client Deposit";
      $expense->city_id=1;
      $expense->expense_type_id=1;
      $expense->save();

      // insert into transaction if paid
      if($request->paystatus == 1){
        $transaction = new Transaction;
        $transaction->bank_id = $request->payment_method;
        $transaction->expense_id = $expense->id;
        $transaction->amount = $request->totaldeposit;
        $transaction->description = "Client Deposit";
        $transaction->save();

        $bank = Bank::find($request->payment_method);
        $bank->amount = $bank->amount-$request->totaldeposit;
        $bank->save();
      }

      return "success";
    }

    // public function lastitem(Request $request){
    //   $myqty=$request->myqty;
    //  // dd($myqty);
    //   $checkitems = Item::orderBy('id', 'desc')->take($myqty)->get();
    //   $lastamount=$checkitems->sum('deposit');

    //  return $lastamount;

    // }

    public function lastitem(Request $request){
      $id = $request->pickup_id;
      $allpaid_delivery_fees = Item::where('pickup_id', $id)->where('paystatus','2')->sum('delivery_fees');
      $notallpaid_deposit = Item::where('pickup_id', $id)->where('paystatus','<>','2')->sum('deposit');
      $depositamount = $notallpaid_deposit-$allpaid_delivery_fees;
      return $depositamount;
    }

    

    public function onway(){
       $ways = Way::orderBy('id', 'desc')->with('item.township')->with('item.SenderGate')->with('item.SenderPostoffice')->with('item.pickup.schedule.client.user')->with("delivery_man.user")->whereHas('item',function ($query)
       {
         $query->whereDate('assign_date',Carbon\Carbon::today());
       })->get();

       return Datatables::of($ways)->addIndexColumn()->toJson();
    }

    public function rejectwaybystaff(Request $request)
    {

      $id = $request->wayid;
      $way = Way::where('id',$id)->withTrashed()->first();

      if($way->status_id!=3){
      $way->status_id = 3;
      $way->status_code = '003';
      // $way->refund_date = date('Y-m-d');
      $way->remark = $request->remark;
      $way->deleted_at=Null;
      $way->save();
      //$waynoti="reject";
      Notification::send($way,new RejectNotification($way));
    //dd("ok");
      event(new rejectitem($way));
      }
      return response()->json(['success'=>'successfully!']);
    }

   
}
