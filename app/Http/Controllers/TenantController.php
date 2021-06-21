<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Application;
use App\Property;
use App\Agent;
use App\EmploymentDetail;
use App\Mail\NewTanent;
use DB;
use Session;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_post($sortby = '', $filterby = '', $pagination = '5', Request $request)
    {
        $search = $request->search;
        $tenants = DB::table('applications as a')
        ->select('a.id', 'a.date_leased', 'a.lease_due', 't.name','t.surname', 't.email', 'p.deal_type', 'p.headline', 'p.type', \DB::raw("(SELECT GROUP_CONCAT(p.headline)) as userproperties"))
        ->leftJoin('users as t', 't.id', '=', 'a.uid')
        ->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')
        ->where('a.approve_status', 'approved')
        ->groupBy('a.uid')
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
        });
        if ($sortby == '') { $tenants->orderBy('id', 'DESC'); }
        if ($sortby == 'id') { $tenants->orderBy('a.id', $filterby); }
        if ($sortby == 'leasedon') { $tenants->orderBy("a.date_leased", $filterby); }
        if ($sortby == 'leaseddue') { $tenants->orderBy("a.lease_due", $filterby); }
        if ($sortby == 'tenant') { $tenants->orderBy("t.name", $filterby); }
        if ($sortby == 'email') { $tenants->orderBy("t.email", $filterby); }
        if ($sortby == 'property') { $tenants->orderBy("p.headline", $filterby); }
        if ($sortby == 'listing') { $tenants->orderBy("p.deal_type", $filterby); }
        if ($sortby == 'type') { $tenants->orderBy("p.type", $filterby); }
        $tenants = $tenants->get();
        if (count($tenants) == 0) { Session::flash('norecord', 'No record found.'); }
        return view('backend.tenants.list', compact('tenants'));
    }
    public function index($sortby = '', $filterby = '', $pagination = '5')
    {
        $tenants = DB::table('applications as a')
        ->select('a.id', 'a.date_leased', 'a.lease_due', 'a.uid', 't.name','t.surname', 't.email', 'p.deal_type', 'p.headline', 'p.type', \DB::raw("(SELECT GROUP_CONCAT(p.headline)) as userproperties"))
        ->leftJoin('users as t', 't.id', '=', 'a.uid')
        ->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')
        ->groupBy('a.uid')
        ->where('a.approve_status', "approved");
        if ($sortby == '') { $tenants->orderBy('a.id', 'DESC'); }
        if ($sortby == 'id') { $tenants->orderBy('a.id', $filterby); }
        if ($sortby == 'leasedon') { $tenants->orderBy("a.date_leased", $filterby); }
        if ($sortby == 'leaseddue') { $tenants->orderBy("a.lease_due", $filterby); }
        if ($sortby == 'tenant') { $tenants->orderBy("t.name", $filterby); }
        if ($sortby == 'email') { $tenants->orderBy("t.email", $filterby); }
        if ($sortby == 'property') { $tenants->orderBy("p.headline", $filterby); }
        if ($sortby == 'listing') { $tenants->orderBy("p.deal_type", $filterby); }
        if ($sortby == 'type') { $tenants->orderBy("p.type", $filterby); }
        $tenants = $tenants
        ->get();
        // dd($tenants);
        return view('backend.tenants.list', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $properties = Property::all();
        $properties = DB::table('properties')
            ->leftJoin('applications', 'properties.item_id', '=', 'applications.property_id')
            ->select('properties.*')
            ->where('applications.approve_status', '!=', 'approved')
            ->where('applications.status', 'active')
            ->groupBy('properties.item_id')
            ->get();
        return view('backend.tenants.form', compact('properties'));
    }

    public function agent(Request $request)
    {
        $property = Property::where('item_id', $request->property_id)->first();
        $agent1 = $property->agent_id_1;
        $agent2 = $property->agent_id_2;
        $agents = Agent::select('id', 'agent_id', 'first_name', 'last_name')->whereIn('agent_id', array($agent1, $agent2))->get();
        return response()->json([
            'status' => '1',
            'msg' => 'Agent found.',
            'data' => $agents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            // 'phone' => 'required|unique:users',
            'address' => 'required',
            'profession' => 'required',
            'employeer' => 'required',
            'position' => 'required',
            'employedon' => 'required|date',
            'employmentDue' => 'required|date',
            'employerAddress' => 'required',
            'property' => 'required',
            'agent' => 'required',
            'appliedOn' => 'required|date',
            'leasedOn' => 'required|date',
            'leasedDue' => 'required|date',
            'deposit' => 'required|integer',
        ]);
        // create tanent

        $generatedPassword = Str::random(32);
        $password = Hash::make($generatedPassword);
        $tanent = new User;
        $tanent->name = $request->first_name;
        $tanent->surname = $request->last_name;
        $tanent->email = $request->email;
        $tanent->mobile = $request->mobile;
        $tanent->phone = $request->phone;
        $tanent->address = $request->address;
        $tanent->password = $password;
        $tanent->role = 'user';
        $tanent->created_at = date('Y-m-d H:i:s');
        $tanent->updated_at = date('Y-m-d H:i:s');
        $tanent->save();
        $employeement = new EmploymentDetail;
        // create employeement
        $employeement->user_id = $tanent->id;
        $employeement->profession = $request->profession;
        $employeement->employer = $request->employeer;
        $employeement->position = $request->position;
        $employeement->employed_on = $request->employedon;
        $employeement->employment_due = $request->employmentDue;
        $employeement->employer_address = $request->employerAddress;
        $employeement->created_at = date('Y-m-d H:i:s');
        $employeement->updated_at = date('Y-m-d H:i:s');
        $employeement->save();
        // create application
        $application = new Application;
        $application->uid = $tanent->id;
        $application->property_id = $request->property;
        $application->agent_id = $request->agent;
        $application->approve_status = 'approved';
        $application->status = 'active';
        $application->security_diposit = $request->deposit;
        $application->date_applied = $request->appliedOn;
        $application->date_leased = $request->leasedOn;
        $application->lease_due = $request->leasedDue;
        $application->created_at = date('Y-m-d H:i:s');
        $application->updated_at = date('Y-m-d H:i:s');
        $application->save();
        // mail
        $data = array(
            'name' => $request->first_name,
            'email' => $request->email,
            'password' => $generatedPassword,
            'base_url' => config('app.url')
        );
        Mail::to($request->email)->send(new NewTanent($data));
        return redirect()->route('tenants');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::with('hasProperty', 'assignedAgent', 'hasTenant', 'hasEmployeement')->find($id);
        return view('backend.tenants.details', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $properties = Property::all();
        $application = Application::with('hasProperty', 'assignedAgent', 'hasTenant', 'hasEmployeement')->find($id);
        $property = Property::where('item_id', $application->property_id)->first();
        // dd($application->assignedAgent);
        return view('backend.tenants.form', compact('properties', 'application', 'property'));
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
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'profession' => 'required',
            'employeer' => 'required',
            'position' => 'required',
            'employedon' => 'required|date',
            'employmentDue' => 'required|date',
            'employerAddress' => 'required',
            'property' => 'required',
            'agent' => 'required',
            'appliedOn' => 'required|date',
            'leasedOn' => 'required|date',
            'leasedDue' => 'required|date',
            'deposit' => 'required',
        ]);
        $application = Application::find($id);
        $tanent_id = $application->uid;
        $employeement_id = EmploymentDetail::where('user_id', $tanent_id)->first();
        if ($employeement_id) {
            $employeement_detail_id = $employeement_id->id;
            $employeement = EmploymentDetail::find($employeement_detail_id);
        } else {
            $employeement = new EmploymentDetail;
        }
        // Update tanent
        $tanent = User::find($tanent_id);
        $tanent->name = $request->first_name;
        $tanent->surname = $request->last_name;
        $tanent->email = $request->email;
        $tanent->mobile = $request->mobile;
        $tanent->phone = $request->phone;
        $tanent->address = $request->address;
        $tanent->updated_at = date('Y-m-d H:i:s');
        $tanent->save();

        // Update employeement
        $employeement->user_id = $tanent->id;
        $employeement->profession = $request->profession;
        $employeement->employer = $request->employeer;
        $employeement->position = $request->position;
        $employeement->employed_on = $request->employedon;
        $employeement->employment_due = $request->employmentDue;
        $employeement->employer_address = $request->employerAddress;
        $employeement->updated_at = date('Y-m-d H:i:s');
        $employeement->save();
        // Update application
        $application = Application::find($id);
        $application->uid = $tanent->id;
        $application->property_id = $request->property;
        $application->agent_id = $request->agent;
        $application->security_diposit = $request->deposit;
        $application->date_applied = $request->appliedOn;
        $application->date_leased = $request->leasedOn;
        $application->lease_due = $request->leasedDue;
        $application->updated_at = date('Y-m-d H:i:s');
        $application->save();
        return redirect()->route('tenants');
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
