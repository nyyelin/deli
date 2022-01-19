<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses=Status::all();
        return view('status.index',compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.create');
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
            'desc'  => ['required', 'string', 'max:255'],
        ]);

        if($validator){
            $codeno="";
            $mystatus=Status::latest()->first();
            $mycode=$mystatus->codeno;
            $ss=$mycode+1;
            if(!$mystatus){
                $codeno="001";
            }else{
                $codeno="00".$ss;
            }

            //dd($mystatus);
            $status=new Status;
            $status->description=$request->desc;
            $status->codeno=$codeno;
            $status->save();
            return redirect()->route('statuses.index')->with("successMsg",'New Status is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
         $status=$status;
        return view('status.edit',compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $validator = $request->validate([
            'desc'  => ['required', 'string', 'max:255'],
        ]);

        if($validator){
            $status=$status;
            $status->description=$request->desc;
            $status->save();
            return redirect()->route('statuses.index')->with("successMsg",'Update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
         $status=$status;
        $status->delete();
       return redirect()->route('statuses.index')->with('successMsg','Existing Status is DELETED in your data');
    }
}
