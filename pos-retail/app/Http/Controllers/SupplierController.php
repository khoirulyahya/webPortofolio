<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        return view('admin.supplier');
    }

    public function api(Request $request)
    {
        if ($request->date_start) {
            # code...
            $suppliers = Supplier::with('transaction_supplier')->orderBy('created_at','DESC')->whereMonth('created_at', [$request->date_start])->get();

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($suppliers)
                                        ->addIndexColumn();
            return $datatables->make(true);
        } else {

            $suppliers = Supplier::with('transaction_supplier')->orderBy('created_at','DESC')->get();

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($suppliers)
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
            'email'  => ['required','email'],
            'phone_number'  => ['required','numeric'],
            'address'  => ['required']
        ]);
        $suppliers = Supplier::with('transaction_supplier')->orderBy('id','DESC')->Limit('1')->first();
        $char = date("Ym");
        $chare = time();
        $charslice = substr($char,2);
        $chareslice = substr($chare,6);

        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->supplier_code = 'SPL'.$charslice.$chareslice.sprintf("%04s",$suppliers->id+1);
        $supplier->email = $request->email;
        $supplier->phone_number = $request->phone_number;
        $supplier->address = $request->address;
        $supplier->save();

        return redirect('suppliers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //validation of required
        $this->validate($request, [
            'name'  => ['required'],
            'email'  => ['required','email'],
            'phone_number'  => ['required','numeric'],
            'address'  => ['required']
        ]);

        $supplier = Supplier::find($supplier->id);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone_number = $request->phone_number;
        $supplier->address = $request->address;
        $supplier->save();

        return redirect('suppliers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    }
}
