<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    /**
     * Class constructor, optional security.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.officer');
    }

    public function api(Request $request)
    {
        if ($request->date_start) {
            # code...
            $officers = Officer::with('transaction_sale','transaction_supplier')->orderBy('created_at','DESC')->whereMonth('created_at', [$request->date_start])->get();

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($officers)
                                        ->addIndexColumn();
            return $datatables->make(true);
        } else {

            $officers = Officer::with('transaction_sale','transaction_supplier')->orderBy('created_at','DESC')->get();

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($officers)
                                        ->addIndexColumn();
            return $datatables->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation of required
        $this->validate($request, [
            'name'  => ['required'],
            'phone_number'  => ['required','numeric'],
            'address'  => ['required']
        ]);
        $officers = Officer::with('transaction_sale','transaction_supplier')->orderBy('id','DESC')->Limit('1')->first();
        $char = date("Ym");
        $chare = time();
        $charslice = substr($char,2);
        $chareslice = substr($chare,6);

        $officer = new Officer;
        $officer->name = $request->name;
        $officer->officer_code = 'OFC'.$charslice.$chareslice.sprintf("%04s",$officers->id+1);
        $officer->phone_number = $request->phone_number;
        $officer->address = $request->address;
        $officer->save();

        return redirect('officers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Officer  $officer
     * @return \Illuminate\Http\Response
     */
    public function show(Officer $officer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Officer  $officer
     * @return \Illuminate\Http\Response
     */
    public function edit(Officer $officer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Officer  $officer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Officer $officer)
    {
        //validation of required
        $this->validate($request, [
            'name'  => ['required'],
            'phone_number'  => ['required','numeric'],
            'address'  => ['required']
        ]);

        $officer = Officer::find($officer->id);
        $officer->name = $request->name;
        $officer->phone_number = $request->phone_number;
        $officer->address = $request->address;
        $officer->save();

        return redirect('officers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Officer  $officer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Officer $officer)
    {
        $officer->delete();
    }
}
