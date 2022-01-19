<?php

namespace App\Http\Controllers;

use App\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $paymenttypes=PaymentType::all();
        return view('PaymentType.index',compact('paymenttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('PaymentType.create');
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
            $PaymentType=new PaymentType;
            $PaymentType->name=$request->name;
            $PaymentType->save();
            return redirect()->route('payment_types.index')->with("successMsg",'New PaymentType is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymentType)
    {
        $paymentType=$paymentType;
        return view('PaymentType.edit',compact('paymentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
        ]);

        if($validator){
            $PaymentType=$paymentType;
            $PaymentType->name=$request->name;
            $PaymentType->save();
            return redirect()->route('payment_types.index')->with("successMsg",'Update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymentType)
    {
        $paymentType=$paymentType;
        $paymentType->delete();
       return redirect()->route('payment_types.index')->with('successMsg','Existing PaymentType is DELETED in your data');
    }
}
