<?php

namespace App\Http\Controllers;

use App\DeliveryMan;
use App\User;
use App\Township;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\City;

class DeliveryMenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $DeliveryMen=DeliveryMan::all();
        return view('deliveryman.index',compact('DeliveryMen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $townships=Township::orderBy('name','asc')->get();
        return view('deliveryman.create',compact('townships','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email'  => ['required','string','email','max:255','unique:users'],
            'password'  => ['required','min:6','confirmed'],
            'phone'  => ['required'],
            'address'  => ['required','string'],
            // 'township'=>['required'],
        ]);
        if($validator){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole('delivery_man');
            $delivery_man=new DeliveryMan;
            $delivery_man->phone_no =$request->phone;
            $delivery_man->address = $request->address;
            $delivery_man->user_id = $user->id;

            if($request->agent){
                $delivery_man->city_id = $request->city;
            }else{
                $delivery_man->city_id = 1;
            }

            if($request->car){
                $delivery_man->status = 1; // for car
            }else{
                $delivery_man->status = 0;
            }

            $delivery_man->save();
            $delivery_man->townships()->attach($request->township);
            return redirect()->route('delivery_men.index')->with("successMsg",'New Delivery Man is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryMan $deliveryMan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryMan $deliveryMan)
    {
        $cities = City::all();
        $townships=Township::orderBy('name','asc')->get();
        $deliveryMan=$deliveryMan;
        return view('deliveryman.edit',compact('deliveryMan','townships','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryMan $deliveryMan)
    {
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email'  => ['required','string','email','max:255'],
            'phone'  => ['required'],
            'address'  => ['required','string'],
            // 'township'=>['required'],
        ]);
        if($validator){
            $deliveryMan=$deliveryMan;
            $user =User::find($deliveryMan->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password!=null){
              $user->password = Hash::make($request->password);   
             }else{
              $user->password = $request->oldpassword;
             }
            $user->save();
            $deliveryMan->phone_no =$request->phone;
            $deliveryMan->address = $request->address;
            $deliveryMan->user_id = $user->id;

            if($request->agent){
                $deliveryMan->city_id = $request->city;
            }else{
                $deliveryMan->city_id = 1;
            }

            if($request->car){
                $delivery_man->status = 1; // for car
            }else{
                $delivery_man->status = 0;
            }
            
            $deliveryMan->save();
            if($request->township!=null){
                 $deliveryMan->townships()->detach();
                 $deliveryMan->townships()->attach($request->township);
            }
           
           
            return redirect()->route('delivery_men.index')->with("successMsg",'Updated successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryMan $deliveryMan)
    {
        $deliveryMan=$deliveryMan;
        $user =User::find($deliveryMan->user_id);
        $user->delete();
        $deliveryMan->townships()->detach();
        $deliveryMan->delete();
       return redirect()->route('delivery_men.index')->with('successMsg','Existing Delivery Man is DELETED in your data');
    }
}
