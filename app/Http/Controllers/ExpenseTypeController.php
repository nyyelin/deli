<?php

namespace App\Http\Controllers;

use App\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expensetypes=ExpenseType::all();
        return view('ExpenseTypes.index',compact('expensetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ExpenseTypes.create');
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
            $expensetype=new ExpenseType;
            $expensetype->name=$request->name;
            $expensetype->save();
            return redirect()->route('expense_types.index')->with("successMsg",'New ExpenseType is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseType $expenseType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseType $expenseType)
    {
        $expenseType=$expenseType;
        return view('ExpenseTypes.edit',compact('expenseType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
         $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
        ]);

        if($validator){
            $expensetype=$expenseType;
            $expensetype->name=$request->name;
            $expensetype->save();
            return redirect()->route('expense_types.index')->with("successMsg",'Update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
         $expenseType=$expenseType;
        $expenseType->delete();
       return redirect()->route('expense_types.index')->with('successMsg','Existing ExpenseType is DELETED in your data');
    
    }
}
