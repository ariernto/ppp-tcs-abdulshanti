<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application;
use App\Models\Inspection;
use App\Models\Job;
use App\Enquiry;
use App\Property;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // applications
        $totalApplication = Application::where('status', '!=', 'deleted')->count();
        $pendingApplication = Application::where('approve_status', 'pending_review')->where('status', '!=', 'deleted')->count();
        $reviewedApplication = Application::where('approve_status', 'reviewed')->where('status', '!=', 'deleted')->count();
        $cancelledApplication = Application::where('approve_status', 'cancelled')->where('status', '!=', 'deleted')->count();
        $approvedApplication = Application::where('approve_status', 'approved')->where('status', '!=', 'deleted')->count();
        // Inspection
        $totalInspection = Inspection::where('status', '!=', 'deleted')->count();
        $closedInspection = Inspection::where('booked_status', 'closed')->where('status', '!=', 'deleted')->count();
        $openInspection = Inspection::where('booked_status', 'open')->where('status', '!=', 'deleted')->count();
        $cancelledInspection = Inspection::where('booked_status', 'cancelled')->where('status', '!=', 'deleted')->count();
        $bookedInspection = Inspection::where('booked_status', 'booked')->where('status', '!=', 'deleted')->count();
        // Job
        $totalJob = Job::where('status', '!=', 'deleted')->count();
        $newJob = Job::where('status', 'new')->count();
        $cancelledJob = Job::where('status', 'cancelled')->count();
        $inProgressJob = Job::where('status', 'in progress')->count();
        $resolvedJob = Job::where('status', 'resolved')->count();
        $closedJob = Job::where('status', 'closed')->count();
        // Enquiry
        $totalEnquiry = Enquiry::where('status', '!=', 'deleted')->count();
        $activeEnquiry = Enquiry::where('status', 'active')->count();
        $archiveEnquiry = Enquiry::where('status', 'archive')->count();
        $muteEnquiry = Enquiry::where('status', 'mute')->count();
        $cancelEnquiry = Enquiry::where('status', 'cancel')->count();
        // Clients
        $tenent = $tenants = DB::table('applications as a')->select('a.id')->leftJoin('users as t', 't.id', '=', 'a.uid')->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')->groupBy('a.uid')->where('a.approve_status', "approved")->get();
        $prospects = DB::table('applications as a')->select('a.id')->leftJoin('users as t', 't.id', '=', 'a.uid')->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')->groupBy('a.uid')->where('a.approve_status', "pending_review")->orWhere('a.approve_status', 'reviewed')->get();
        // Property
        $available = Property::where('status', 1)->count();
        $underOffer = Property::where('status', 2)->orWhere('status', 3)->count();
        $withdrawn = Property::where('status', 4)->count();
        $draft = Property::where('status', 5)->count();
        $offMarket = Property::where('status', 6)->count();
        $holidayLease = Property::where('status', 7)->count();
        $data = (object)[
            'property' => (object)[
                'totalProperty' => $available + $underOffer + $withdrawn + $draft + $offMarket + $holidayLease,
                'available' => $available,
                'underOffer' => $underOffer,
                'withdrawn' => $withdrawn,
                'draft' => $draft,
                'offMarket' => $offMarket,
                'holidayLease' => $holidayLease,
            ],
            'application' => (object)[
                'totalApplication' => $totalApplication,
                'pendingApplication' => $pendingApplication,
                'cancelledApplication' => $cancelledApplication,
                'approvedApplication' => $approvedApplication,
                'reviewedApplication' => $reviewedApplication
            ],
            'inspection' => (object)[
                'totalInspection' => $totalInspection,
                'closedInspection' => $closedInspection,
                'openInspection' => $openInspection,
                'cancelledInspection' => $cancelledInspection,
                'bookedInspection' => $bookedInspection
            ],
            'job' => (object)[
                "totalJob" => $totalJob,
                "newJob" => $newJob,
                "cancelledJob" => $cancelledJob,
                "inProgressJob" => $inProgressJob,
                "resolvedJob" => $resolvedJob,
                "closedJob" => $closedJob,
            ],
            'enquiry' => (object)[
                "totalEnquiry" => $totalEnquiry,
                "activeEnquiry" => $activeEnquiry,
                "archiveEnquiry" => $archiveEnquiry,
                "muteEnquiry" => $muteEnquiry,
                "cancelEnquiry" => $cancelEnquiry,
            ],
            'clients' => (object)[
                'totalClient' => count($prospects) + count($tenent),
                'tenants' => count($tenent),
                'prospects' => count($prospects),
            ]
        ];
        return view('backend.dashboard', compact('data'));
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
        //
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
