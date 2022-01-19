<?php

namespace App\Http\Controllers;

use App\SenderGate;
use Illuminate\Http\Request;

class SenderGateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gates=SenderGate::all();
        return view('sender_gate.index',compact('gates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sender_gate.create');
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
        ]);

        if($validator){
            $gate=new SenderGate;
            $gate->name=$request->name;
            $gate->save();
            return redirect()->route('sendergate.index')->with("successMsg",'New Gate is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SenderGate  $senderGate
     * @return \Illuminate\Http\Response
     */
    public function show(SenderGate $senderGate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SenderGate  $senderGate
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderGate $senderGate,$id)
    {
        ///dd($id);
        $gate=SenderGate::find($id);
        //dd($gate);
        return view('sender_gate.edit',compact('gate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SenderGate  $senderGate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderGate $senderGate,$id)
    {
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
        ]);

        if($validator){
            $gate=SenderGate::find($id);
            $gate->name=$request->name;
            $gate->save();
            return redirect()->route('sendergate.index')->with("successMsg",'update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SenderGate  $senderGate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SenderGate $senderGate,$id)
    {
        $gate=SenderGate::find($id);
        $gate->delete();
       return redirect()->route('sendergate.index')->with('successMsg','Existing Gate is DELETED in your data');
    }
}
