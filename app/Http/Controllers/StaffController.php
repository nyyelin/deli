<?php

namespace App\Http\Controllers;

use App\Staff;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff=Staff::all();
        return view('staff.index',compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.create');
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
            'date'=>['required','date'],
            'designation'=>['required']
        ]);
        if($validator){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole('staff');
            $staff=new Staff;
            $staff->phone_no =$request->phone;
            $staff->address = $request->address;
            $staff->joined_date = $request->date;
            $staff->designation = $request->designation;
            $staff->user_id = $user->id;
            $staff->save();
           
            return redirect()->route('staff.index')->with("successMsg",'New Staff is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        $staff=$staff;
        return view('staff.edit',compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email'  => ['required','string','email','max:255'],
            'phone'  => ['required'],
            'address'  => ['required','string'],
            'date'=>['required','date'],
            'designation'=>['required']
        ]);
         //dd($request);
        if($validator){
            $staff=$staff;
            $user =User::find($staff->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password!=null){
              $user->password = Hash::make($request->password);   
          }else{
              $user->password = $request->oldpassword;
          }
           
            $user->save();
            
            $staff->phone_no =$request->phone;
            $staff->address = $request->address;
            $staff->joined_date = $request->date;
            $staff->designation = $request->designation;
            $staff->user_id = $user->id;
            $staff->save();
           
            return redirect()->route('staff.index')->with("successMsg",'Update Successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff=$staff;
        $user =User::find($staff->user_id);
        $user->delete();
        $staff->delete();
       return redirect()->route('staff.index')->with('successMsg','Existing Staff is DELETED in your data');
    }
}
