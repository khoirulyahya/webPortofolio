<?php

namespace App\Http\Controllers;

use App\Models\TransactionSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //import use DB

class TransactionSupplierController extends Controller
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
        return view('admin.transactionSupplier');
    }

    public function api(Request $request)
    {
        if ($request->date_start) {

            // $transactionSuppliers = TransactionSupplier::with('officer','supplier','transaction_supplier_details')->orderBy('created_at','DESC')->whereMonth('created_at', [$request->date_start])->get();
            $transactionSuppliers = TransactionSupplier::select('transaction_suppliers.id','transaction_suppliers.invoice_code','transaction_suppliers.officer_id','transaction_suppliers.supplier_id','transaction_suppliers.created_at','transaction_suppliers.updated_at','officers.name as officer_name','officers.officer_code')
            ->orderBy('transaction_suppliers.created_at','DESC')->whereMonth('transaction_suppliers.created_at', [$request->date_start])
            ->join('officers','officers.id', '=','transaction_suppliers.officer_id')
            ->leftjoin('suppliers','suppliers.id', '=','transaction_suppliers.supplier_id') //if this active, data just show where have member
            ->get();

            foreach ($transactionSuppliers as $key => $transactionsupplierDetail) {
                    # code...
                    $transactionsupplierDetail->details = DB::table('transaction_supplier_details')
                                        ->select('transaction_supplier_details.id', 'transaction_supplier_details.transaction_id','transaction_supplier_details.product_id', 'transaction_supplier_details.qty', 'products.buy_price as price', DB::raw("products.buy_price*transaction_supplier_details.qty as total"), 'products.product_code', 'products.name as product_name', 'products.unit', 'products.buy_price', 'products.member_price', 'products.retail_price')
                                        ->where('transaction_id', $transactionsupplierDetail->id)
                                        ->join('products', 'products.id', '=', 'transaction_supplier_details.product_id')
                                        ->get();
                    $transactionsupplierDetail->total_item =  count($transactionsupplierDetail->details);

            }

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($transactionSuppliers)
                                        ->addColumn('dateBy_yajra', function($transactionSuppliers) {
                                            return convert_date($transactionSuppliers->created_at);
                                        })
                                        ->addColumn('supplier_null', function($transactionSuppliers) {
                                            return data_mitra($transactionSuppliers->supplier);
                                        })
                                        ->addColumn('supplier_code', function($transactionSuppliers) {
                                            return $transactionSuppliers->supplier->supplier_code;
                                        })
                                        ->addColumn('name_officer', function($transactionSuppliers) {
                                            return $transactionSuppliers->officer->name;
                                        })
                                        ->addColumn('total_item', function($transactionSuppliers) {
                                            return $transactionSuppliers->transaction_supplier_details->count();
                                        })
                                        ->addIndexColumn();
            return $datatables->make(true);
        } else {

            // $transactionSuppliers = TransactionSupplier::with('officer','supplier','transaction_supplier_details')->orderBy('created_at','DESC')->get();
            $transactionSuppliers = TransactionSupplier::select('transaction_suppliers.id','transaction_suppliers.invoice_code','transaction_suppliers.officer_id','transaction_suppliers.supplier_id','transaction_suppliers.created_at','transaction_suppliers.updated_at','officers.name as officer_name','officers.officer_code')
            ->orderBy('transaction_suppliers.created_at','DESC')
            ->join('officers','officers.id', '=','transaction_suppliers.officer_id')
            ->leftjoin('suppliers','suppliers.id', '=','transaction_suppliers.supplier_id') //if this active, data just show where have member
            ->get();

            foreach ($transactionSuppliers as $key => $transactionsupplierDetail) {
                    # code...
                    $transactionsupplierDetail->details = DB::table('transaction_supplier_details')
                                        ->select('transaction_supplier_details.id', 'transaction_supplier_details.transaction_id','transaction_supplier_details.product_id', 'transaction_supplier_details.qty', 'products.buy_price as price', DB::raw("products.buy_price*transaction_supplier_details.qty as total"), 'products.product_code', 'products.name as product_name', 'products.unit', 'products.buy_price', 'products.member_price', 'products.retail_price')
                                        ->where('transaction_id', $transactionsupplierDetail->id)
                                        ->join('products', 'products.id', '=', 'transaction_supplier_details.product_id')
                                        ->get();
                    $transactionsupplierDetail->total_item =  count($transactionsupplierDetail->details);

            }

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($transactionSuppliers)
                                        ->addColumn('dateBy_yajra', function($transactionSuppliers) {
                                            return convert_date($transactionSuppliers->created_at);
                                        })
                                        ->addColumn('supplier_null', function($transactionSuppliers) {
                                            return $transactionSuppliers->supplier->name;
                                        })
                                        ->addColumn('supplier_code', function($transactionSuppliers) {
                                            return $transactionSuppliers->supplier->supplier_code;
                                        })
                                        ->addColumn('name_officer', function($transactionSuppliers) {
                                            return $transactionSuppliers->officer->name;
                                        })
                                        ->addColumn('total_item', function($transactionSuppliers) {
                                            return $transactionSuppliers->transaction_supplier_details->count();
                                        })
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionSupplier  $transactionSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionSupplier $transactionSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionSupplier  $transactionSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionSupplier $transactionSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionSupplier  $transactionSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionSupplier $transactionSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionSupplier  $transactionSupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionSupplier $transactionSupplier)
    {
        $transactionSupplier->delete();
    }
}
