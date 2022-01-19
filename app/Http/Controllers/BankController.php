<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $banks=Bank::all();
        return view('bank.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank.create');
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
            'amount'=>['required']
        ]);

        if($validator){
            $bank=new Bank;
            $bank->name=$request->name;
            $bank->amount=$request->amount;
            $bank->save();
            return redirect()->route('banks.index')->with("successMsg",'New Bank is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        $city=$bank;
        return view('bank.edit',compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'amount'=>['required']
        ]);

        if($validator){
            $bank=$bank;
            $bank->name=$request->name;
            $bank->amount=$request->amount;
            $bank->save();
            return redirect()->route('banks.index')->with("successMsg",'update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank=$bank;
        $bank->delete();
       return redirect()->route('banks.index')->with('successMsg','Existing Bank is DELETED in your data');
    }


    public function addamount(Request $request )
    {
       $bank = Bank::find($request->id);
       $amount = $bank->amount;
       $bank->amount = $amount+$request->amount;
       $bank->save();
       return back();
    }
}
