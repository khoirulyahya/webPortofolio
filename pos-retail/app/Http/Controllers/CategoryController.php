<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
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
        return view('admin.category');
    }

    public function api()
    {
        $categories = Category::with('products')->orderBy('created_at','DESC')->get();

        //cara kedua(dari yajra) manggil function helpers di controller
        $datatables = datatables()->of($categories)
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
        //validation of required
        $this->validate($request, [
            'name'  => ['required']
        ]);
        $categories = Category::with('products')->orderBy('id','DESC')->Limit('1')->first();
        $char = date("Ym");
        $chare = time();
        $charslice = substr($char,2);
        $chareslice = substr($chare,6);
        // return 'CTG'.$charslice.$chareslice.sprintf("%04s",$categories[0]->id+1);

        $category = new Category;
        $category->name = $request->name;
        $category->category_code = 'CTG'.$charslice.$chareslice.sprintf("%04s",$categories->id+1);
        $category->save();

        return redirect('categories');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //validation of required
        $this->validate($request, [
            'name'  => ['required'],
            'category_code'  => ['required']
        ]);

        $category = Category::find($category->id);
        $category->name = $request->name;
        $category->save();

        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
