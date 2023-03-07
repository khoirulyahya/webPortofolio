<?php

namespace App\Http\Controllers;

use App\Models\TransactionSaleDetail;
use App\Models\TransactionSale;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionSaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function api()
    {
        $transactionSaleDetail = TransactionSaleDetail::with('product','transaction_sale')->get();

        //cara kedua(dari yajra) manggil function helpers di controller
        $datatables = datatables()->of($transactionSaleDetail)
                                    ->addIndexColumn();
        return $datatables->make(true);
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
        $this->validate($request, [
            'product_id'  => ['required','numeric'],
            'qty'  => ['required','numeric'],
            'price'  => ['required','numeric']
        ]);
        $transaction_id = TransactionSale::with('transaction_sale_details')->orderBy('id','DESC')->Limit('1')->first();

        $transactionSaleDetail = new TransactionSaleDetail();
        $transactionSaleDetail->transaction_id = $transaction_id->id;
        $transactionSaleDetail->product_id = $request->product_id;
        $transactionSaleDetail->qty = $request->qty;
        $transactionSaleDetail->total = $request->price*$request->qty;
        $transactionSaleDetail->save();
        $productStock = Product::find($request->product_id);
        $productStock->decrement('qty');
        return redirect('transactionSales/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionSaleDetail  $transactionSaleDetail
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionSaleDetail $transactionSaleDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionSaleDetail  $transactionSaleDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionSaleDetail $transactionSaleDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionSaleDetail  $transactionSaleDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionSaleDetail $transactionSaleDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionSaleDetail  $transactionSaleDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionSaleDetail $transactionSaleDetail)
    {
        $transactionSaleDetail->delete();
        $productStock = Product::find($transactionSaleDetail->product_id);
        $productStock->increment('qty');
    }
}
