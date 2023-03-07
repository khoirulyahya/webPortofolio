<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $categories = Category::all();
        $products = Product::all();
        return view('admin.product', compact('categories','products'));
    }

    public function addOrder()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('admin.product', compact('products'));
    }

    public function getProduct($id)
    {
        $products = Product::findOrFail($id);
        return response()->json($products, 200);
    }

    public function api(Request $request)
    {
        if ($request->date_start) {
            # code...
            $products = Product::with('category')->orderBy('created_at','DESC')->whereMonth('created_at', [$request->date_start])->get();

            $datatables = datatables()->of($products)
                                        ->addColumn('price_buy', function($products) {
                                            return convert_rupe($products->buy_price);
                                        })
                                        ->addColumn('price_member', function($products) {
                                            return convert_rupe($products->member_price);
                                        })
                                        ->addColumn('price_retail', function($products) {
                                            return convert_rupe($products->retail_price);
                                        })
                                        ->addColumn('category_name', function($products) {
                                            return $products->category->name;
                                        })
                                        ->addIndexColumn();
            return $datatables->make(true);
        } else {

            $products = Product::select('products.id','products.product_code','products.name','products.category_id','products.qty','products.unit','products.buy_price','products.member_price','products.retail_price','products.created_at','categories.name as category_name')
            ->join('categories','categories.id', '=','products.category_id')
            ->orderBy('created_at','DESC')
            ->get();
            // $products->name_product =

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($products)
                                        ->addColumn('price_buy', function($products) {
                                            return convert_rupe($products->buy_price);
                                        })
                                        ->addColumn('price_member', function($products) {
                                            return convert_rupe($products->member_price);
                                        })
                                        ->addColumn('price_retail', function($products) {
                                            return convert_rupe($products->retail_price);
                                        })
                                        ->addIndexColumn();
            return $datatables->make(true);
        }
        // $products = Product::with('category')->get();

        // return json_encode($products);
        // return json_encode($products);
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
            'category_id'  => ['required','numeric'],
            'qty'  => ['required','numeric'],
            'unit'  => ['required'],
            'buyPrice'  => ['required','numeric'],
            'memberPrice'  => ['required','numeric'],
            'retailPrice'  => ['required','numeric']
        ]);
        $products = Product::with('category')->orderBy('id','DESC')->Limit('1')->first();
        $char = date("Ym");
        $chare = time();
        $charslice = substr($char,2);
        $chareslice = substr($chare,6);

        $product = new Product;
        $product->name = $request->name;
        $product->product_code = 'BRG'.$charslice.$chareslice.sprintf("%04s",$products->id+1);
        $product->category_id = $request->category_id;
        $product->qty = $request->qty;
        $product->unit = $request->unit;
        $product->buy_price = $request->buyPrice;
        $product->member_price = $request->memberPrice;
        $product->retail_price = $request->retailPrice;
        $product->save();

        return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //validation of required
        $this->validate($request, [
            'name'  => ['required'],
            'qty'  => ['required','numeric'],
            'unit'  => ['required'],
            'buyPrice'  => ['required','numeric'],
            'memberPrice'  => ['required','numeric'],
            'retailPrice'  => ['required','numeric']
        ]);

        $product = Product::find($product->id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->qty = $request->qty;
        $product->unit = $request->unit;
        $product->buy_price = $request->buyPrice;
        $product->member_price = $request->memberPrice;
        $product->retail_price = $request->retailPrice;
        $product->save();

        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
         $product->delete();
    }
}
