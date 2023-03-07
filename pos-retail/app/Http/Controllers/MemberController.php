<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
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
        return view('admin.member');
    }

    public function api(Request $request)
    {
        if ($request->date_start) {
            # code...
            $members = Member::with('transaction_sale')->orderBy('created_at','DESC')->whereMonth('created_at', [$request->date_start])->get();

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($members)
                                        ->addIndexColumn();
            return $datatables->make(true);
        } else {

            $members = Member::with('transaction_sale')->orderBy('created_at','DESC')->get();

            //cara kedua(dari yajra) manggil function helpers di controller
            $datatables = datatables()->of($members)
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
            'phone_number'  => ['required','numeric']
        ]);
        $members = Member::with('transaction_sale')->orderBy('id','DESC')->Limit('1')->first();
        $char = date("Ym");
        $chare = time();
        $charslice = substr($char,2);
        $chareslice = substr($chare,6);
        // return 'CTG'.$charslice.$chareslice.sprintf("%04s",$categories[0]->id+1);

        $member = new Member;
        $member->name = $request->name;
        $member->member_code = 'MBR'.$charslice.$chareslice.sprintf("%04s",$members->id+1);
        $member->phone_number = $request->phone_number;
        $member->save();

        return redirect('members');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //validation of required
        $this->validate($request, [
            'name'  => ['required'],
            'phone_number'  => ['required','numeric']
        ]);

        $member = Member::find($member->id);
        $member->name = $request->name;
        $member->phone_number = $request->phone_number;
        $member->save();

        return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
