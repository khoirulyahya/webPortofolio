<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; //import to use DB
use App\Models\Member;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\TransactionSale;
use App\Models\TransactionSupplier;
use App\Models\TransactionSaleDetail;
use App\Models\TransactionSupplierDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_members = Member::count();
        $total_products = Product::count();
        $total_transactionSales = TransactionSale::count();
        $total_suppliers = Supplier::count();
        $total_allStok = Product::sum('qty');
        $total_saleCash = TransactionSaleDetail::sum('total');
        $total_supplyCash = TransactionSupplierDetail::sum('total');

        $data_pie_transcationSales = TransactionSaleDetail::select(DB::raw("COUNT(product_id) as total"))
        ->groupBy('products.category_id')
        ->orderBy('category_id','asc')
        ->join('products','products.id', '=', 'transaction_sale_details.product_id')
        ->pluck('total');

        $label_pie_transcationSales = Product::orderBy('products.category_id','asc')
        ->groupBy('products.category_id')
        ->join('transaction_sale_details','transaction_sale_details.product_id', '=', 'products.id')
        ->join('categories','categories.id', '=', 'products.category_id')
        ->pluck('categories.name');

        $data_pie_transcationSuppliers = TransactionSupplierDetail::select(DB::raw("COUNT(product_id) as total"))
        ->groupBy('products.category_id')
        ->orderBy('category_id','asc')
        ->join('products','products.id', '=', 'transaction_supplier_details.product_id')
        ->pluck('total');

        $label_pie_transcationSuppliers = Product::orderBy('products.category_id','asc')
        ->groupBy('products.category_id')
        ->join('transaction_supplier_details','transaction_supplier_details.product_id', '=', 'products.id')
        ->join('categories','categories.id', '=', 'products.category_id')
        ->pluck('categories.name');

        $label_stackedBar = ['Sales','Suppliers'];
        $data_stackedBar = [];

        foreach ($label_stackedBar as $key => $value) {
            $data_stackedBar[$key]['label'] = $label_stackedBar[$key];
            $data_stackedBar[$key]['backgroundColor'] =  $key == 0 ? 'rgb(210,214,222,1)' : 'rgb(60,141,188,0.9)';
            $data_month = [];

            foreach (range(1,12) as $month) {
                if ($key == 0) {
                    $data_month[] = TransactionSale::select(DB::raw("COUNT(*) as total"))->whereMonth('created_at', $month)->first()->total;
                } else {
                    $data_month[] = TransactionSupplier::select(DB::raw("COUNT(*) as total"))->whereMonth('created_at', $month)->first()->total;
                }
            }
            $data_stackedBar[$key]['data'] = $data_month;
        }

        return view('home', compact('data_stackedBar','data_pie_transcationSuppliers','label_pie_transcationSuppliers','data_pie_transcationSales','label_pie_transcationSales','total_members','total_products','total_transactionSales','total_suppliers','total_allStok','total_saleCash','total_supplyCash'));
    }
}
