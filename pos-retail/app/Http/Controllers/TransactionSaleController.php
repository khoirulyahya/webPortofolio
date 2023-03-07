<?php

namespace App\Http\Controllers;

use App\Models\TransactionSale;
use App\Models\Product;
use App\Models\Officer;
use App\Models\Member;
use App\Models\TransactionSaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //import use DB

class TransactionSaleController extends Controller
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
        $officer_name = Officer::select('officers.name')->where('id','=',auth()->user()->officer_id)->first();
        return view('admin.transactionSale', compact('officer_name'));
    }

    public function getProduct($id)
    {
        $transactionSale = TransactionSale::select('transaction_sales.member_id')->orderBy('id','DESC')->Limit('1')->first();
        if ($transactionSale == null) {
            # code...
            $products = Product::select('products.id','products.product_code','products.name','products.unit','products.retail_price as price')->where('id','=',$id)->first();
            return response()->json($products, 200);
        } else {
            # code...
            $products = Product::select('products.id','products.product_code','products.name','products.unit','products.member_price as price')->where('id','=',$id)->first();
            return response()->json($products, 200);
        }
    }

    public function detailsProduct()
    {
        $transaction_id = TransactionSale::with('transaction_sale_details')->orderBy('id','DESC')->Limit('1')->first();
        // $transactionProducts = TransactionSaleDetail::with('transaction_sale','product')->where('transaction_id','=',$transaction_id->id)->get();
        $transactionProducts = TransactionSaleDetail::select('transaction_sale_details.id','transaction_sale_details.transaction_id','transaction_sale_details.product_id','transaction_sale_details.qty','transaction_sale_details.total','transaction_sales.invoice_code','products.name','products.unit','products.retail_price as price')
        ->join('transaction_sales','transaction_sales.id', '=','transaction_sale_details.transaction_id')
        ->join('products','products.id', '=','transaction_sale_details.product_id')
        ->where('transaction_sale_details.transaction_id','=',$transaction_id->id)
        ->get();
        return json_encode($transactionProducts);
    }

    public function selectProduct()
    {
        $products = Product::all();
        return json_encode($products);
    }


    public function api(Request $request)
    {
        if ($request->date_start) {
            # code...
            // $transactionSales = TransactionSale::with('member','officer','transaction_sale_details')->orderBy('created_at','DESC')->whereMonth('created_at', [$request->date_start])->get();
            // $transactionSales = TransactionSale::select('transaction_sales.id','transaction_sales.invoice_code','transaction_sales.officer_id','transaction_sales.member_id','members.name as members_name')
            // ->join('members','members.id', '=','transaction_sales.member_id')
            // ->get();
            $transactionSales = TransactionSale::select('transaction_sales.id','transaction_sales.invoice_code','transaction_sales.officer_id','transaction_sales.member_id','transaction_sales.created_at','transaction_sales.updated_at','officers.name as officer_name','officers.officer_code')
            ->orderBy('transaction_sales.created_at','DESC')->whereMonth('transaction_sales.created_at', [$request->date_start])
            ->join('officers','officers.id', '=','transaction_sales.officer_id')
            ->leftjoin('members','members.id', '=','transaction_sales.member_id') //if this active, data just show where have member
            ->get();

            foreach ($transactionSales as $key => $transactionsaleDetail) {
                if ($transactionsaleDetail->member_id == null) {
                    # code...
                    $transactionsaleDetail->details = DB::table('transaction_sale_details')
                                        ->select('transaction_sale_details.id', 'transaction_sale_details.transaction_id','transaction_sale_details.product_id', 'transaction_sale_details.qty', 'products.retail_price as price', DB::raw("products.retail_price*transaction_sale_details.qty as total"), 'products.product_code', 'products.name as product_name', 'products.unit', 'products.buy_price', 'products.member_price', 'products.retail_price')
                                        ->where('transaction_id', $transactionsaleDetail->id)
                                        ->join('products', 'products.id', '=', 'transaction_sale_details.product_id')
                                        ->get();
                    $transactionsaleDetail->total_item =  count($transactionsaleDetail->details);

                } else {
                    $transactionsaleDetail->details = DB::table('transaction_sale_details')
                                        ->select('transaction_sale_details.id', 'transaction_sale_details.transaction_id','transaction_sale_details.product_id', 'transaction_sale_details.qty', 'products.member_price as price', DB::raw("products.member_price*transaction_sale_details.qty as total"), 'products.product_code', 'products.name as product_name', 'products.unit', 'products.buy_price', 'products.member_price', 'products.retail_price')
                                        ->where('transaction_id', $transactionsaleDetail->id)
                                        ->join('products', 'products.id', '=', 'transaction_sale_details.product_id')
                                        ->get();
                    $transactionsaleDetail->total_item =  count($transactionsaleDetail->details);

                }

            }

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($transactionSales)
                                        ->addColumn('dateBy_yajra', function($transactionSales) {
                                            return convert_date($transactionSales->created_at);
                                        })
                                        ->addColumn('member_null', function($transactionSales) {
                                            return data_null($transactionSales->member);
                                        })
                                        ->addColumn('name_officer', function($transactionSales) {
                                            return data_mitra($transactionSales->officer);
                                        })
                                        ->addColumn('total_item', function($transactionSales) {
                                            return $transactionSales->transaction_sale_details->count();
                                        })
                                        ->addIndexColumn();
            return $datatables->make(true);
        } else {

            // $transactionSales = TransactionSale::with('member','officer','transaction_sale_details')->orderBy('created_at','DESC')->get();
            $transactionSales = TransactionSale::select('transaction_sales.id','transaction_sales.invoice_code','transaction_sales.officer_id','transaction_sales.member_id','transaction_sales.created_at','transaction_sales.updated_at','officers.name as officer_name','officers.officer_code')
            ->orderBy('transaction_sales.created_at','DESC')
            ->join('officers','officers.id', '=','transaction_sales.officer_id')
            ->leftjoin('members','members.id', '=','transaction_sales.member_id') //if this active, data just show where have member
            ->get();

            foreach ($transactionSales as $key => $transactionsaleDetail) {
                if ($transactionsaleDetail->member_id == null) {
                    # code...
                    $transactionsaleDetail->details = DB::table('transaction_sale_details')
                                        ->select('transaction_sale_details.id', 'transaction_sale_details.transaction_id','transaction_sale_details.product_id', 'transaction_sale_details.qty', 'products.retail_price as price', DB::raw("products.retail_price*transaction_sale_details.qty as total"), 'products.product_code', 'products.name as product_name', 'products.unit', 'products.buy_price', 'products.member_price', 'products.retail_price')
                                        ->where('transaction_id', $transactionsaleDetail->id)
                                        ->join('products', 'products.id', '=', 'transaction_sale_details.product_id')
                                        ->get();
                    $transactionsaleDetail->total_item =  count($transactionsaleDetail->details);

                } else {
                    $transactionsaleDetail->details = DB::table('transaction_sale_details')
                                        ->select('transaction_sale_details.id', 'transaction_sale_details.transaction_id','transaction_sale_details.product_id', 'transaction_sale_details.qty', 'products.member_price as price', DB::raw("products.member_price*transaction_sale_details.qty as total"), 'products.product_code', 'products.name as product_name', 'products.unit', 'products.buy_price', 'products.member_price', 'products.retail_price')
                                        ->where('transaction_id', $transactionsaleDetail->id)
                                        ->join('products', 'products.id', '=', 'transaction_sale_details.product_id')
                                        ->get();
                    $transactionsaleDetail->total_item =  count($transactionsaleDetail->details);

                }

            }
            // return $transactionSales;

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($transactionSales)
                                        ->addColumn('dateBy_yajra', function($transactionSales) {
                                            return convert_date($transactionSales->created_at);
                                        })
                                        ->addColumn('member_null', function($transactionSales) {
                                            return data_null($transactionSales->member);
                                        })
                                        ->addColumn('name_officer', function($transactionSales) {
                                            return data_mitra($transactionSales->officer);
                                        })
                                        ->addColumn('total_item', function($transactionSales) {
                                            return $transactionSales->transaction_sale_details->count();
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
        $products = Product::all();
        $officer_name = Officer::select('officers.name')->where('id','=',auth()->user()->officer_id)->first();
        $transactionSale = TransactionSale::with('officer','member')->orderBy('id','DESC')->Limit('1')->first();
        $transactionSaleDetails = TransactionSaleDetail::with('transaction_sale')->where('transaction_id','=',$transactionSale->id)->get();
        // return $transactionSaleDetails;
        return view('admin.transactionsale.create', compact('products','officer_name','transactionSale','transactionSaleDetails'));
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
            'officer_id'  => ['required','numeric']
        ]);
        $transactionSales = TransactionSale::with('officer')->orderBy('id','DESC')->Limit('1')->first();
        $char = date("Ym"); //6 digit
        $chare = time(); //10 digit
        $charslice = substr($char,2); //dikurangi 2 digit dari 6
        $chareslice = substr($chare,6); //dikurangi 6 digit dari 10

        if ($request->member_id == null) {
            # code...
            $transactionSale = new TransactionSale;
            $transactionSale->invoice_code = 'INV'.$charslice.$chareslice.sprintf("%04s",$transactionSales->id+1);
            $transactionSale->officer_id = $request->officer_id;
            $transactionSale->member_id = $request->member_id;
            $transactionSale->save();

        } else {
            # code...
            $id_member = Member::select('members.id')->where('member_code','=',$request->member_id)->first();
            if ($id_member == null) {
                # code...
                return abort(403, 'Member ID not found');
            } else {
                # code...
                $transactionSale = new TransactionSale;
                $transactionSale->invoice_code = 'INV'.$charslice.$chareslice.sprintf("%04s",$transactionSales->id+1);
                $transactionSale->officer_id = $request->officer_id;
                $transactionSale->member_id = $id_member->id;
                $transactionSale->save();
            }

        }
        return redirect('transactionSales/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionSale  $transactionSale
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionSale $transactionSale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionSale  $transactionSale
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionSale $transactionSale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionSale  $transactionSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionSale $transactionSale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionSale  $transactionSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionSale $transactionSale)
    {
        $transactionSale->delete();
    }
}
