<?php

namespace App\Http\Controllers;

use App\Client;
use App\Township;
use Illuminate\Http\Request;
use Carbon;
use App\User;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients=Client::all();
        return view('client.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $townships=Township::all();
        return view('client.create',compact('townships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mytime = Carbon\Carbon::now();
        $array = explode('-', $mytime->toDateString());
        $codeno=$array[0].$array[1]."001";
        $latestdata=Client::whereMonth('created_at',Carbon\Carbon::today())->orderBy('id','desc')->first();
            //dd($latecodeno);
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email'  => ['required','string','email','max:255','unique:users'],
            'password'  => ['required','min:6','confirmed'],
            'phone'  => ['required'],
            'address'  => ['required','string'],
            'person'=>['required','string'],
            'township'=>['required'],
            // 'account'=>['required'],
            // 'owner'=>['required']
        ]);
        if($validator){
            
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole('client');
            $client=new Client;
            $client->phone_no =$request->phone;
            $client->address = $request->address;
            $client->account=$request->account;
            $client->owner=$request->owner;
            $client->contact_person = $request->person;
            if(!$latestdata){
                 $client->codeno=$codeno;   
            }else{
                $latecodeno=$latestdata->codeno;
                $client->codeno=$latecodeno+1;
            }
            
            $client->township_id = $request->township;
            $client->user_id = $user->id;
            $client->save();
           
            return redirect()->route('clients.index')->with("successMsg",'New Client is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $townships=Township::all();
        $client=$client;
        return view('client.edit',compact('client','townships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email'  => ['required','string','email','max:255'],
            'phone'  => ['required'],
            'address'  => ['required','string'],
            'person'=>['required','string'],
            'township'=>['required'],
            // 'account'=>['required'],
            // 'owner'=>['required']
        ]);
         //dd($request);
        if($validator){
            $client=$client;
            $user =User::find($client->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password!=null){
              $user->password = Hash::make($request->password);   
          }else{
              $user->password = $request->oldpassword;
          }
           
            $user->save();
            
            $client->phone_no =$request->phone;
            $client->address = $request->address;
            $client->account=$request->account;
            $client->owner=$request->owner;
            $client->contact_person = $request->person;
            $client->township_id = $request->township;
            $client->user_id = $user->id;
            $client->save();
           
            return redirect()->route('clients.index')->with("successMsg",'Update Successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client=$client;
        $user =User::find($client->user_id);
        $user->delete();
        $client->delete();
       return redirect()->route('clients.index')->with('successMsg','Existing Client is DELETED in your data');
    }
}
