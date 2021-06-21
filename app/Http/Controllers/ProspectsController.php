<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application;
use DB;
use Session;

class ProspectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_post($sortby = '', $filterby = '', $pagination = '5', Request $request)
    {
        $search = $request->search;
        // dd($search);
        $prospects = DB::table('applications as a')
        ->select('a.id', 'a.date_leased', 'a.lease_due', 'a.uid', 't.name','t.surname', 't.email', 'p.deal_type', 'p.headline', 'p.type')
        ->leftJoin('users as t', 't.id', '=', 'a.uid')
        ->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')
        ->where(function($q) {
            $q
                ->orWhere('a.approve_status', "pending_review")
                ->orWhere('a.approve_status', "reviewed");
        })
        // ->orWhere('a.approve_status', 'reviewed')
        ->where(function ($q) use ($search) {
            $q
                ->orWhere('a.id', 'LIKE', '%' . $search . '%')
                ->orWhere('a.date_leased', 'LIKE', '%' . $search . '%')
                ->orWhere('a.lease_due', 'LIKE', '%' . $search . '%')
                ->orWhere('t.name', 'LIKE', '%' . $search . '%')
                ->orWhere('t.surname', 'LIKE', '%' . $search . '%')
                ->orWhere('t.email', 'LIKE', '%' . $search . '%')
                ->orWhere('p.deal_type', 'LIKE', '%' . $search . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $search . '%')
                ->orWhere('p.type', 'LIKE', '%' . $search . '%');
        })
        ->groupBy('a.uid');
        if ($sortby == '') { $prospects->orderBy('a.id', 'DESC'); }
        if ($sortby == 'id') { $prospects->orderBy('a.id', $filterby); }
        if ($sortby == 'leasedon') { $prospects->orderBy("a.date_leased", $filterby); }
        if ($sortby == 'leaseddue') { $prospects->orderBy("a.lease_due", $filterby); }
        if ($sortby == 'tenant') { $prospects->orderBy("t.name", $filterby); }
        if ($sortby == 'email') { $prospects->orderBy("t.email", $filterby); }
        if ($sortby == 'property') { $prospects->orderBy("p.headline", $filterby); }
        if ($sortby == 'listing') { $prospects->orderBy("p.deal_type", $filterby); }
        if ($sortby == 'type') { $prospects->orderBy("p.type", $filterby); }
        $prospects = $prospects->get();
        if (count($prospects) == 0) { Session::flash('norecord', 'No record found.'); }
        return view('backend.prospects.list', compact('prospects'));
    }
    public function index($sortby = '', $filterby = '', $pagination = '5')
    {
        $prospects = DB::table('applications as a')
        ->select('a.id', 'a.date_leased', 'a.lease_due', 'a.uid', 't.name','t.surname', 't.email', 'p.deal_type', 'p.headline', 'p.type')
        ->leftJoin('users as t', 't.id', '=', 'a.uid')
        ->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')
        ->groupBy('a.uid')
        ->where('a.approve_status', "pending_review")
        ->orWhere('a.approve_status', 'reviewed');
        if ($sortby == '') { $prospects->orderBy('a.id', 'DESC'); }
        if ($sortby == 'id') { $prospects->orderBy('a.id', $filterby); }
        if ($sortby == 'leasedon') { $prospects->orderBy("a.date_leased", $filterby); }
        if ($sortby == 'leaseddue') { $prospects->orderBy("a.lease_due", $filterby); }
        if ($sortby == 'tenant') { $prospects->orderBy("t.name", $filterby); }
        if ($sortby == 'email') { $prospects->orderBy("t.email", $filterby); }
        if ($sortby == 'property') { $prospects->orderBy("p.headline", $filterby); }
        if ($sortby == 'listing') { $prospects->orderBy("p.deal_type", $filterby); }
        if ($sortby == 'type') { $prospects->orderBy("p.type", $filterby); }
        $prospects = $prospects
        ->get();
        return view('backend.prospects.list', compact('prospects'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::with('hasProperty', 'assignedAgent', 'hasTenant')->find($id);
        return view('backend.prospects.details', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
