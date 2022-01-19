<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SenderPostoffice;

class SenderOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices=SenderPostoffice::all();
        return view('senderoffice.index',compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('senderoffice.create');
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
            $office=new SenderPostoffice;
            $office->name=$request->name;
            $office->save();
            return redirect()->route('senderoffice.index')->with("successMsg",'New Post Office is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $office=SenderPostoffice::find($id);
        //dd($city);
        return view('senderoffice.edit',compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
        ]);

        if($validator){
            $office=SenderPostoffice::find($id);
            $office->name=$request->name;
            $office->save();
            return redirect()->route('senderoffice.index')->with("successMsg",'update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $office=SenderPostoffice::find($id);
        $office->delete();
       return redirect()->route('senderoffice.index')->with('successMsg','Existing Post Office is DELETED in your data');
    }
}
