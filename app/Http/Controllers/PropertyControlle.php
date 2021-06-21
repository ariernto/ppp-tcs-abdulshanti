<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Property;
use App\Property_detail;
use App\Enquiry;
use App\Models\Wishlist;
use App\Models\Enquiry_message;
use App\Application;
use App\Application_message;
use App\helper\Helper;
use App\Models\Inspection;
use App\Models\Inspection_message;
use App\Models\Job;
use App\Models\JobMessage;
use App\User;
use DB;
use Session;
use App\Worker;

class PropertyControlle extends Controller
{
    public function index($sortby = '', $filterby = '', $pagination = '1')
    {
        if (is_numeric($sortby)) { $pagination = $sortby; $sortby = ''; }
        $agent = auth()->user()->agent_id;
        $prop = [ 'sortby' => $sortby, 'filterby' => $filterby, 'pagination' => $pagination, 'q' => '' ];
        $limit = 20;
        $page = $limit * ($pagination - 1);
        $sort = ($sortby != '')?$sortby: 'id';
        $filter = ($filterby != '')?$filterby: 'desc';
        $proerties = Property::with('assignedTo');
        if ($sortby != '') { $sort = ($sortby == 'price')?'price_text': $sortby; }
        if ($sortby == 'id') { $sort = 'item_id'; }
        if ($sortby == 'listing') { $sort = 'type'; }
        if ($sort != 'suburb' && $sort != 'assigned_to') { $proerties->orderBy($sort, $filter); }
        if (auth()->user()->role != 'admin') { $proerties->where('agent_id_1', $agent); }
        $totalPages = ceil($proerties->count() / $limit);
        $proerties = $proerties->skip($page)->take($limit)->get();
        if ($sort == 'assigned_to') {
            if ($filterby == 'asc') {
                $proerties = $proerties->sortBy(function($query) { return $query->assignedTo->first_name; })->all();
            } else {
                $proerties = $proerties->sortByDesc(function($query) { return $query->assignedTo->first_name; })->all();
            }
        }
        if ($sort == 'suburb') {
            if ($filterby == 'asc') {
                $proerties = $proerties->sortBy(function($query) { return json_decode($query->address)->suburb; })->all();
            } else {
                $proerties = $proerties->sortByDesc(function($query) { return json_decode($query->address)->suburb; })->all();
            }
        }
        return view('backend.properties.properties', compact('proerties', 'prop', 'totalPages', 'pagination'));
    }

    public function indexPost(Request $request, $sortby = '', $filterby = '', $pagination = '1')
    {
        if (is_numeric($sortby)) { $pagination = $sortby; $sortby = ''; }
        $agent = auth()->user()->agent_id;
        $query = $request->q;
        $prop = [
          'sortby' => $request->sortby,
          'filterby' => $request->filterby,
          'pagination' => $request->pagination,
          'q' => $request->q
        ];
        $totalPages = 1;
        $sort = ($request->sortby != '')?$request->sortby: 'updated_at';
        $filter = ($request->filterby != '')?$request->filterby: 'desc';
        if (auth()->user()->role == 'admin') {
            $proerties = Property::where(function ($q) use ($query)
            {
              $q
                ->orWhere('headline', 'LIKE', '%' . $query . '%')
                ->orWhere('item_id', 'LIKE', '%' . $query . '%')
                ->orWhere('property_type', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $filter)->with('assignedTo')->paginate($request->pagination);
        } else {
            $proerties = Property::where('agent_id_1', $agent)->where(function ($q) use ($query)
            {
              $q
                ->orWhere('headline', 'LIKE', '%' . $query . '%')
                ->orWhere('item_id', 'LIKE', '%' . $query . '%')
                ->orWhere('property_type', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $filter)->with('assignedTo')->paginate($request->pagination);
        }
        if (count($proerties) == 0) { Session::flash('norecord', 'No result found.'); }

        return view('backend.properties.properties', compact('proerties', 'prop', 'totalPages', 'pagination'));
    }

    public function show($id)
    {
        $proertyDetails = Property_detail::where('item_id', $id)->with('assignedToAgent' )->first();
        $application = Application::where('property_id', $id)->with('assignedAgent', 'hasTenant')->first();
        $images = json_decode($proertyDetails->photos);
        return view('backend.properties.property', compact('proertyDetails', 'application', 'images'));
    }

    public function maintanances($sortby = '', $filterby = '', $pagination = '5')
    {
        $agent = auth()->user()->agent_id;
        $prop = [
            'sortby' => $sortby,
            'filterby' => $filterby,
            'pagination' => $pagination,
            'q' => ''
        ];
        $sort = ($sortby != '')?$sortby: 'updated_at';
        $filter = ($filterby != '')?$filterby: 'desc';
        if ($sortby == "issue") { $sort = "title";}
        $jobs = Job::where('status','!=','deleted')->with('assignedTo', 'hasProperty', 'hasRating');
        if ($sortby == "loggedon") { $sort = "created_at"; }
        if ($sortby == "rectifyingTime") { $sort = "hours"; }
        if ($sortby == "issue" || $sortby == "id" || $sortby == "mantinance_type" || $sortby == "loggedon" || $sortby == "rectifyingTime" || $sortby == "status") { $jobs->orderBy($sort, $filter); }
        if (auth()->user()->role != 'admin') { $jobs->where('agent_id', $agent); }
        $jobs = $jobs->get();
        if ($sortby == "property") {
            if ($filterby == 'asc') {
                $jobs = $jobs->sortBy(function($query) { return $query->hasProperty->headline; })->all();
            } else {
                $jobs = $jobs->sortByDesc(function($query) { return $query->hasProperty->headline; })->all();
            }
        }
        if ($sortby == "assignee") {
            if ($filterby == 'asc') {
                $jobs = $jobs->sortBy(function($query) { return $query->assignedTo->first_name; })->all();
            } else {
                $jobs = $jobs->sortByDesc(function($query) { return $query->assignedTo->first_name; })->all();
            }
        }
        return view('backend.maintanances.maintanances', compact('jobs', 'prop'));
    }


    public function maintanancesPost(Request $request)
    {
        $agent = auth()->user()->agent_id;
        $query = $request->q;
        $prop = [
          'sortby' => $request->sortby,
          'filterby' => $request->filterby,
          'pagination' => $request->pagination,
          'q' => $request->q
        ];
        $sort = ($request->sortby != '')?$request->sortby: 'updated_at';
        $filter = ($request->filterby != '')?$request->filterby: 'desc';
        if (auth()->user()->role == 'admin') {
            $jobs = Job::where('status','!=','deleted')->where(function ($q) use ($query)
            {
              $q
                ->orWhere('id', 'LIKE', '%' . $query . '%')
                ->orWhere('title', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $filter)->with('assignedTo', 'hasProperty', 'hasRating')->get();
        } else {
            $jobs = Job::where('status','!=','deleted')->where(function ($q) use ($query)
            {
              $q
                ->orWhere('id', 'LIKE', '%' . $query . '%')
                ->orWhere('title', 'LIKE', '%' . $query . '%');
            })->where('agent_id', $agent)->orderBy($sort, $filter)->with('assignedTo', 'hasProperty', 'hasRating')->get();
        }
        if (count($jobs) == 0) { Session::flash('norecord', 'No result found.'); }
        return view('backend.maintanances.maintanances', compact('jobs', 'prop'));
    }

    public function maintananceDetails($id)
    {
        $job = Job::where('id', $id)->with('assignedWorker', 'assignedTo', 'hasProperty', 'hasTenant','hasRating')->first();
        $jobMessage = JobMessage::where('job_id', $id)->get();
        $workers = Worker::where('status', 'active')->get();
        return view('backend.maintanances.maintanance', compact('job', 'jobMessage', 'workers'));
    }

    public function maintananceChat(Request $request)
    {
        $chat = new JobMessage;
        $chat->job_id = $request->application;
        $chat->sender_id = $request->sender;
        $chat->receiver_id = $request->reciever;
        $chat->message = $request->message;
        $chat->status = 'active';
        $chat->created_at = date('Y-m-d H:i:s');
        $chat->updated_at = date('Y-m-d H:i:s');
        if ($chat->save()) {
            return response()->json(['status' => '1', 'data' => $chat, 'time' => date_format(date_create($chat->created_at), 'F dS Y, h:i: A')]);
        } else {
            return response()->json(['status' => '0', 'data' => []]);
        }
    }

    public function enquiries($sortby = '', $filterby = '', $pagination = '100')
    {
        $agent = auth()->user()->agent_id;
        $prop = [
            'sortby' => $sortby,
            'filterby' => $filterby,
            'pagination' => $pagination,
            'q' => ''
        ];
        $sort = ($sortby != '')?$sortby: 'updated_at';
        $filter = ($filterby != '')?$filterby: 'desc';

        if ($sort == "enquiry") { $sort = 'subjects'; }
        if ($sort == "lodged") { $sort = 'created_at'; }
        if ($sort == "agent") { $sort = 'created_at'; }
        $enquiries = Enquiry::with([
            'hasProperty',
            'hasTenant',
            'assignedAgent'
        ]);
        if ($sortby != "agent" && $sortby != "lodgedby") { $enquiries->orderBy($sort, $filter); }

        if (auth()->user()->role != 'admin') { $enquiries->where('agent_id', $agent); }
        $enquiries = $enquiries->get();
        // dd($enquiries[0]);
        if ($sortby == 'agent') {
            if ($filterby == 'asc') {
                $enquiries = $enquiries->sortBy(function($query) { return $query->assignedAgent->first_name; })->all();
            } else {
                $enquiries = $enquiries->sortByDesc(function($query) { return $query->assignedAgent->first_name; })->all();
            }
        }
        if ($sortby == 'lodgedby') {
            if ($filterby == 'asc') {
                $enquiries = $enquiries->sortBy(function($query) { return $query->hasTenant->name; })->all();
            } else {
                $enquiries = $enquiries->sortByDesc(function($query) { return $query->hasTenant->name; })->all();
            }
        }
        return view('backend.enquiries.enquiries', compact('enquiries', 'prop'));
    }

    public function enquiriesPost(Request $request)
    {
        $agent = auth()->user()->agent_id;
        $query = $request->q;
        $prop = [
          'sortby' => $request->sortby,
          'filterby' => $request->filterby,
          'pagination' => $request->pagination,
          'q' => $request->q
        ];
        $sort = ($request->sortby != '')?$request->sortby: 'updated_at';
        $filter = ($request->filterby != '')?$request->filterby: 'desc';

        if (auth()->user()->role == 'admin') {
            $enquiries = Enquiry::where(function ($q) use ($query)
            {
              $q
                ->orWhere('id', 'LIKE', '%' . $query . '%')
                ->orWhere('property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('subjects', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->paginate($request->pagination);
        } else {
            $enquiries = Enquiry::where('agent_id', $agent)->where(function ($q) use ($query)
            {
              $q
                ->orWhere('id', 'LIKE', '%' . $query . '%')
                ->orWhere('property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('subjects', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->paginate($request->pagination);
        }
        if (count($enquiries) == 0) { Session::flash('norecord', 'No result found.'); }
        return view('backend.enquiries.enquiries', compact('enquiries', 'prop'));
    }

    public function enquiry($id)
    {
        $enquiry = Enquiry::where('id',$id)->with('hasProperty', 'assignedAgent', 'hasTenant')->first();
        $enquiry_message = Enquiry_message::where('enquiry_id',$id)->get();
        return view('backend.enquiries.enquiry', compact('enquiry', 'enquiry_message'));
    }

    public function enquiryUpdate(Request $request)
    {
       // dd($request->input()); die;
        $eid =$request->input('enqId');
        $enquiry = Enquiry::where('id', $eid)->first();
        $enquiry->status = $request->input('status');
        $enquiry->updated_at = date('Y-m-d H:i:s');
       /* if ($enquiry->save()) {
            return response()->json(['status' => '1', 'data' => $enquiry]);
        } else {
            return response()->json(['status' => '0', 'data' => []]);
        }*/
          if($enquiry->save()){
            Session::flash('success', 'Enquiry saved.');
        }
        else{
            Session::flash('error', 'There is some technical isseu.');
        }
        if ($request->saveandclose == null) {
            return redirect('/enquiry/'.$eid);
        } else {
            return redirect('/enquiries');
        }

    }

    public function enquiryChat(Request $request)
    {
        $chat = new Enquiry_message;
        $chat->enquiry_id = $request->application;
        $chat->sender_id = $request->sender;
        $chat->receiver_id = $request->reciever;
        $chat->message = $request->message;
        $chat->status = 'active';
        $chat->created_at = date('Y-m-d H:i:s');
        $chat->updated_at = date('Y-m-d H:i:s');
        if ($chat->save()) {
            return response()->json(['status' => '1', 'data' => $chat, 'time' => date_format(date_create($chat->created_at), 'F dS Y, h:i: A')]);
        } else {
            return response()->json(['status' => '0', 'data' => []]);
        }
    }

    public function applications($sortby = '', $filterby = '', $pagination = '5')
    {
        $agent = auth()->user()->agent_id;
        $prop = [
            'sortby' => $sortby,
            'filterby' => $filterby,
            'pagination' => $pagination,
            'q' => ''
        ];
        $sort = ($sortby != '')?$sortby: 'a.updated_at';
        $filter = ($filterby != '')?$filterby: 'desc';

        if ($sort == "agent") { $sort = 'ag.first_name'; }
        if ($sort == "lodged") { $sort = 'a.date_applied'; }
        if ($sort == "id") { $sort = 'a.property_id'; }
        if ($sort == "lodged_by") { $sort = 'u.name'; }
        if ($sort == "status") { $sort = 'a.approve_status'; }

        if (auth()->user()->role == 'admin') {
            //$applicatios = Application::orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->paginate($pagination);
            $applicatios = DB::table('applications as a')
                ->select('a.id','a.property_id','a.agent_id','a.communication_method','a.communication_method','a.approve_status','a.date_applied','ag.first_name','ag.last_name','p.headline','u.name','u.surname')
                ->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'a.agent_id')
                ->leftJoin('users as u', 'u.id', '=', 'a.uid')
                ->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')
                ->where('a.status','!=','deleted')
                ->distinct('a.id')
                ->orderBy($sort, $filter)
                ->get();
           //echo '<pre>'; print_r($applicatios); die;
        } else {
            //$applicatios = Application::where('agent_id', $agent)->orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->paginate($pagination);
            $applicatios = Application::where('agent_id', $agent)->orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->get();
        }
        return view('backend.applicatios.applicatios', compact('applicatios', 'prop'));
    }

    public function applicationsPost(Request $request)
    {
        $agent = auth()->user()->agent_id;
        $query = $request->q;
        $prop = [
          'sortby' => $request->sortby,
          'filterby' => $request->filterby,
          'pagination' => $request->pagination,
          'q' => $request->q
        ];
        $sort = ($request->sortby != '')?$request->sortby: 'a.updated_at';
        $filter = ($request->filterby != '')?$request->filterby: 'desc';

        if(auth()->user()->role == 'admin') {

             $applicatios = DB::table('applications as a')->select('a.id','a.property_id','a.agent_id','a.communication_method','a.communication_method','a.approve_status','a.date_applied','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'a.agent_id')->leftJoin('users as u', 'u.id', '=', 'a.uid')->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')->where(function ($q) use ($query)
            {
              $q
                ->orWhere('a.property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('a.approve_status', 'LIKE', '%' . $query . '%')
                ->orWhere('a.communication_method', 'LIKE', '%' . $query . '%')
                ->orWhere('u.name', 'LIKE', '%' . $query . '%')
                ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $query . '%');
            })->distinct('a.id')->orderBy($sort, $filter)->get();

            //print_r($applicatios); die;

        } else {

              $applicatios = DB::table('applications as a')->select('a.id','a.property_id','a.agent_id','a.communication_method','a.communication_method','a.approve_status','a.date_applied','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'a.agent_id')->leftJoin('users as u', 'u.id', '=', 'a.uid')->leftJoin('properties as p', 'p.item_id', '=', 'a.property_id')->where('a.agent_id', $agent)->where(function ($q) use ($query)
            {
              $q
                ->orWhere('a.property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('a.approve_status', 'LIKE', '%' . $query . '%')
                ->orWhere('a.communication_method', 'LIKE', '%' . $query . '%')
                ->orWhere('u.name', 'LIKE', '%' . $query . '%')
                ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $query . '%');
            })->distinct('a.id')->orderBy($sort, $filter)->get();
        }
        if (count($applicatios) == 0) { Session::flash('norecord', 'No result found.'); }
        // dd($prop);
        return view('backend.applicatios.applicatios', compact('applicatios', 'prop'));
    }

    public function applicationDetails($id)
    {
        $application = Application::where('id', $id)->with('hasProperty', 'assignedAgent', 'hasTenant')->first();
        $application_message = Application_message::where('application_id', $id)->get();
        $agent = auth()->user()->agent_id;
        $tenant = $application->hasTenant->uid;

        return view('backend.applicatios.application', compact('application', 'application_message'));
    }

    public function applicationChat(Request $request)
    {
        $chat = new Application_message;
        $chat->application_id = $request->application;
        $chat->sender_id = $request->sender;
        $chat->receiver_id = $request->reciever;
        $chat->message = $request->message;
        $chat->status = 'active';
        $chat->created_at = date('Y-m-d H:i:s');
        $chat->updated_at = date('Y-m-d H:i:s');
        if ($chat->save()) {
            return response()->json(['status' => '1', 'data' => $chat, 'time' => date_format(date_create($chat->created_at), 'F dS Y, h:i: A')]);
        } else {
            return response()->json(['status' => '0', 'data' => []]);
        }
    }

    public function inspections($sortby = '', $filterby = '', $pagination = '5')
    {
        $agent = auth()->user()->agent_id;
        $prop = [
            'sortby' => $sortby,
            'filterby' => $filterby,
            'pagination' => $pagination,
            'q' => ''
        ];
        $sort = ($sortby != '')?$sortby: 'i.updated_at';
        $filter = ($filterby != '')?$filterby: 'desc';

        if ($sort == "agent") { $sort = 'ag.first_name'; }
        if ($sort == "lodged") { $sort = 'i.created_at'; }
        if ($sort == "lodged_by") { $sort = 'u.name'; }
        if ($sort == "status") { $sort = 'i.booked_status'; }
        if ($sort == "id") { $sort = 'i.property_id'; }
        if ($sort == "bookedfor") { $sort = 'i.booked_date'; }

        if (auth()->user()->role == 'admin') {
            //$inspections = Inspection::orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->paginate($pagination);
          /*  $inspections = Inspection::orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->get();*/

          $inspections = DB::table('inspections as i')->select('i.id','i.property_id','i.agent_id','i.inspect_dates','i.booked_date','i.communication_method','i.booked_status','i.status','i.created_at','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'i.agent_id')->leftJoin('users as u', 'u.id', '=', 'i.uid')->leftJoin('properties as p', 'p.item_id', '=', 'i.property_id')->where('i.status','!=','deleted')->distinct('i.id')->orderBy($sort, $filter)->get();
        //  echo '<pre>'; print_r($inspections); die;

            /* $applicatios = DB::table('inspections as i')->select('i.id','i.property_id','i.agent_id','i.inspect_dates','i.communication_method','i.booked_status','i.status','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'i.agent_id')->leftJoin('users as u', 'u.id', '=', 'i.uid')->leftJoin('properties as p', 'p.item_id', '=', 'i.property_id')->where(function ($q) use ($query)
            {
              $q
                ->orWhere('i.property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('i.approve_status', 'LIKE', '%' . $query . '%')
                ->orWhere('i.communication_method', 'LIKE', '%' . $query . '%')
                ->orWhere('u.name', 'LIKE', '%' . $query . '%')
                ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $query . '%');
            })->distinct('i.id')->orderBy($sort, $filter)->get();*/

        } else {
           // $inspections = Inspection::where('agent_id', $agent)->orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->paginate($pagination);
            /* $inspections = Inspection::where('agent_id', $agent)->orderBy($sort, $filter)->with('hasProperty', 'assignedAgent', 'hasTenant')->get();*/
            $inspections = DB::table('inspections as i')->select('i.id','i.property_id','i.agent_id','i.inspect_dates','i.booked_date','i.communication_method','i.booked_status','i.status','i.created_at','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'i.agent_id')->leftJoin('users as u', 'u.id', '=', 'i.uid')->leftJoin('properties as p', 'p.item_id', '=', 'i.property_id')->where('i.agent_id', $agent)->where('i.status','!=','deleted')->distinct('i.id')->orderBy($sort, $filter)->get();
        }
        return view('backend.inspections.inspections', compact('inspections', 'prop'));
    }

    public function inspectionsPost(Request $request)
    {
        $agent = auth()->user()->agent_id;
        $query = $request->q;
        $prop = [
          'sortby' => $request->sortby,
          'filterby' => $request->filterby,
          'pagination' => $request->pagination,
          'q' => $request->q
        ];
        $sort = ($request->sortby != '')?$request->sortby: 'i.updated_at';
        $filter = ($request->filterby != '')?$request->filterby: 'desc';
        if ($sort == "agent") { $sort = 'ag.first_name'; }
        if ($sort == "lodged") { $sort = 'i.created_at'; }
        if ($sort == "lodged_by") { $sort = 'u.name'; }
        if ($sort == "status") { $sort = 'i.booked_status'; }
        if (auth()->user()->role == 'admin') {
            $inspections = DB::table('inspections as i')->select('i.id','i.property_id','i.agent_id','i.inspect_dates','i.booked_date','i.communication_method','i.booked_status','i.status','i.created_at','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'i.agent_id')->leftJoin('users as u', 'u.id', '=', 'i.uid')->leftJoin('properties as p', 'p.item_id', '=', 'i.property_id')->where(function ($q) use ($query)
            {
              $q
                ->orWhere('i.property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('i.communication_method', 'LIKE', '%' . $query . '%')
                ->orWhere('u.name', 'LIKE', '%' . $query . '%')
                ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $query . '%');
            })->distinct('i.id')->orderBy($sort, $filter)->get();
        } else {
           $inspections = DB::table('inspections as i')->select('i.id','i.property_id','i.agent_id','i.inspect_dates','i.booked_date','i.communication_method','i.booked_status','i.status','i.created_at','ag.first_name','ag.last_name','p.headline','u.name','u.surname')->leftJoin('agent_details as ag', 'ag.agent_id', '=', 'i.agent_id')->leftJoin('users as u', 'u.id', '=', 'i.uid')->leftJoin('properties as p', 'p.item_id', '=', 'i.property_id')->where('i.agent_id', $agent)->where('status','!=','deleted')->where(function ($q) use ($query)
            {
              $q
                ->orWhere('i.property_id', 'LIKE', '%' . $query . '%')
                ->orWhere('i.communication_method', 'LIKE', '%' . $query . '%')
                ->orWhere('u.name', 'LIKE', '%' . $query . '%')
                ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('ag.last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $query . '%');
            })->distinct('i.id')->orderBy($sort, $filter)->get();
        }

        if (count($inspections) == 0) { Session::flash('norecord', 'No result found.'); }

        return view('backend.inspections.inspections', compact('inspections', 'prop'));

    }

    public function inspectionDetails($id)
    {
        $inspection = Inspection::where('id', $id)->with('hasProperty', 'assignedAgent', 'hasTenant')->first();
        $inspection_message = Inspection_message::where('inspection_id', $id)->get();
        return view('backend.inspections.inspection', compact('inspection', 'inspection_message'));
    }

    public function inspectionChat(Request $request)
    {
        $chat = new Inspection_message;
        $chat->inspection_id = $request->application;
        $chat->sender_id = $request->sender;
        $chat->receiver_id = $request->reciever;
        $chat->message = $request->message;
        $chat->status = 'active';
        $chat->created_at = date('Y-m-d H:i:s');
        $chat->updated_at = date('Y-m-d H:i:s');
        if ($chat->save()) {
            return response()->json(['status' => '1', 'data' => $chat, 'time' => date_format(date_create($chat->created_at), 'F dS Y, h:i: A')]);
        } else {
            return response()->json(['status' => '0', 'data' => []]);
        }
    }

   public function wishlist_list($sortby = '', $filterby = '', $pagination = '100')
    {
        $agent = auth()->user()->agent_id;
        $prop = [
            'sortby' => $sortby,
            'filterby' => $filterby,
            'pagination' => $pagination,
            'q' => ''
        ];
        $sort = ($sortby != '')?$sortby: 'w.updated_at';
        $filter = ($filterby != '')?$filterby: 'desc';
        if ($sortby == 'property') { $sort = 'p.headline'; }
        if ($sortby == 'savedby') { $sort = 'u.name'; }
        if ($sortby == 'suburb') { $sort = 'w.updated_at'; }
        if ($sortby == 'id') { $sort = 'w.property_id'; }
        if ($sortby == 'listing') { $sort = 'p.type'; }
        if ($sortby == 'addedon') { $sort = 'w.created_at'; }
        if ($sortby == 'propertytype') { $sort = 'p.property_type'; }
        if ($sortby == 'client') { $sort = 'approvedCount'; }
        //$wishlist = Wishlist::where('status','active')->orderBy($sort, $filter)->with('hasProperty','hasTenant')->get();
        if(auth()->user()->role == 'admin') {
            $wishlist = DB::table('wishlists as w')
                ->select('w.id', 'w.uid','w.property_id','w.status','w.created_at','p.type','p.address','p.headline', 'p.property_type','u.name','u.surname', \DB::raw("(SELECT count(id) FROM applications WHERE property_id = w.property_id AND uid = w.uid) as approvedCount"))
                ->leftJoin('users as u', 'u.id', '=', 'w.uid')
                ->leftJoin('properties as p', 'p.item_id', '=', 'w.property_id')
                ->where('w.status','!=','deleted')
                ->distinct('w.id')
                ->orderBy($sort, $filter)
                ->get();
                // dd($wishlist);
        }else{
            $wishlist = DB::table('wishlists as w')
                ->select('w.id','w.property_id','w.status','w.created_at','p.type','p.address','p.headline','u.name','u.surname', \DB::raw("(SELECT count(id) FROM applications WHERE property_id = w.property_id AND uid = w.uid) as approvedCount"))
                ->leftJoin('users as u', 'u.id', '=', 'w.uid')
                ->leftJoin('properties as p', 'p.item_id', '=', 'w.property_id')
                ->where('w.status','!=','deleted')
                ->where(function ($q) use ($agent) {
                    $q->orWhere('p.agent_id_1',$agent)->orWhere('p.agent_id_2',$agent);
                })->distinct('w.id')->orderBy($sort, $filter)->get();
        }

        if ($sortby == 'suburb') {
            if ($filterby == 'asc') {
                $wishlist = $wishlist->sortBy(function($query) { return json_decode($query->address)->suburb; })->all();
            } else {
                $wishlist = $wishlist->sortByDesc(function($query) { return json_decode($query->address)->suburb; })->all();
            }
        }

        return view('backend.wishlist.wishlist', compact('wishlist', 'prop'));
    }
public function wishlistPost(Request $request)
    {
       /* $agent = auth()->user()->agent_id;
        $prop = [
            'sortby' => $sortby,
            'filterby' => $filterby,
            'pagination' => $pagination,
            'q' => ''
        ];
        $sort = ($sortby != '')?$sortby: 'updated_at';
        $filter = ($filterby != '')?$filterby: 'desc';
        $wishlist = Wishlist::where('status','active')->orderBy($sort, $filter)->with('hasProperty','hasTenant')->paginate($pagination);
        //echo '<pre>'; print_r($wishlist); die;
        return view('backend.wishlist.wishlist', compact('wishlist', 'prop'));*/

        $agent = auth()->user()->agent_id;
        $query = $request->q;
        $prop = [
          'sortby' => $request->sortby,
          'filterby' => $request->filterby,
          'pagination' => $request->pagination,
          'q' => $request->q
        ];
        $sort = ($request->sortby != '')?$request->sortby: 'w.updated_at';
        $filter = ($request->filterby != '')?$request->filterby: 'desc';
        /*$wishlist = Wishlist::where('status','active')->where(function ($q) use ($query)
        {
          $q
            ->orWhere('property_id', 'LIKE', '%' . $query . '%');
        })->orderBy($sort, $filter)->with('hasProperty', 'hasTenant')->paginate($request->pagination);*/
        if(auth()->user()->role == 'admin') {
      $wishlist = DB::table('wishlists as w')
        ->select('w.id','w.property_id','w.status','w.created_at','p.type','p.address','p.headline','u.name','u.surname', \DB::raw("(SELECT count(id) FROM applications WHERE property_id = w.property_id AND uid = w.uid) as approvedCount"))
        ->leftJoin('users as u', 'u.id', '=', 'w.uid')
        ->leftJoin('properties as p', 'p.item_id', '=', 'w.property_id')
        ->where('w.status','!=','deleted')
        ->where(function ($q) use ($query) {
          $q
            ->orWhere('w.id', 'LIKE', '%' . $query . '%')
            ->orWhere('u.name', 'LIKE', '%' . $query . '%')
            ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
            ->orWhere('p.headline', 'LIKE', '%' . $query . '%')
            ->orWhere('p.type', 'LIKE', '%' . $query . '%');
        })
        ->distinct('w.id')
        ->orderBy($sort, $filter)
        ->get();
    }
    else{

       $wishlist = DB::table('wishlists as w')
        ->select('w.id','w.property_id','w.status','w.created_at','p.type','p.address','p.headline','u.name','u.surname', \DB::raw("(SELECT count(id) FROM applications WHERE property_id = w.property_id AND uid = w.uid) as approvedCount"))
        ->leftJoin('users as u', 'u.id', '=', 'w.uid')
        ->leftJoin('properties as p', 'p.item_id', '=', 'w.property_id')
        ->where('w.status','!=','deleted')->where(function ($agent) use ($a)
            {
              $q
                ->orWhere('p.agent_id_1',$a)
                ->orWhere('p.agent_id_2',$a);
            })->where(function ($q) use ($query)
            {
              $q
                ->orWhere('w.id', 'LIKE', '%' . $query . '%')
                ->orWhere('u.name', 'LIKE', '%' . $query . '%')
                ->orWhere('u.surname', 'LIKE', '%' . $query . '%')
                ->orWhere('p.headline', 'LIKE', '%' . $query . '%')
                ->orWhere('p.type', 'LIKE', '%' . $query . '%');
            })->distinct('w.id')->orderBy($sort, $filter)->get();
     }
     if (count($wishlist) == 0) { Session::flash('norecord', 'No result found.'); }
        // dd($prop);
         return view('backend.wishlist.wishlist', compact('wishlist', 'prop'));
    }

    public function inspection_status(Request $request)
    {
        // dd($request->all());
        $communication_method = implode(',', $request->for);
        $iid =$request->input('inspection_id');
        $ins = Inspection::find($iid);
        $booked_status = $ins->booked_status;
        $inspections = DB::table('inspections')
            ->where('id', $iid)
            ->update(
                array(
                    'booked_status' => $request->input('status'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'booked_date'=>date('Y-m-d H:i:s', strtotime($request->input('booked_date') . ' ' . $request->input('booked_time')))
                )
            );
        if($inspections){
            if ($booked_status != 'booked' && $request->input('status') == 'booked') {
                $user = User::find($ins->uid);
                $chat = new Inspection_message;
                $chat->inspection_id = $iid;
                $chat->sender_id = auth()->user()->agent_id;
                $chat->receiver_id = $ins->uid;
                $chat->message = "Dear " . $user->name . ", we're happy to confirm that your inspection has been successfully booked for " . date('M d Y h:iA') . ".";
                $chat->status = 'active';
                $chat->created_at = date('Y-m-d H:i:s');
                $chat->updated_at = date('Y-m-d H:i:s');
                $chat->save();
                $data=array(
                    'title' =>'Inspection booked',
                    'body'=>"Dear " . $user->name . ", we're happy to confirm that your inspection has been successfully booked for " . date('M d Y h:iA') . ".",
                    'type'=>'application',
                    'id'=>$ins->uid
                );
                $helper = new \App\Helper\helper;
                $helper->pushNotification($ins->uid,$data);
            }
            Session::flash('success', 'Inspection saved.');
        }
        else{
            Session::flash('error', 'There is some technical isseu.');
        }
        if ($request->saveandclose == null) {
            return redirect('/inspection/'.$iid);
        } else {
            return redirect('/inspections');
        }

    }

    public function inspection_delete(Request $request)
    {
        $dataDeleted = date('Y-m-d H:i:s');
        $ins = Inspection::find($request->delete_id);
        $ins->status = 'deleted';
        $ins->updated_at = $dataDeleted;
        if ($ins->save()) {
            return response()->json([
                'status' => '1',
                'msg' => 'Inspection deleted.',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'Inspection delete fail.',
                'data' => ''
            ]);
        }

    }

    public function delete_message()
    {
        Session::flash('error', 'Inspection deleted.');
        return redirect('/inspections');
    }


 public function job_status(Request $request)
    {
        $iid =$request->input('job_id');
        $job = DB::table('jobs')->where('id', $iid)->update(
            array(
                'status'=>$request->input('status'),
                'assign_id'=>$request->input('assignedWorker'),
                'updated_at'=>date('Y-m-d H:i:s')
            )
        );
        if($job){
            Session::flash('success', 'Maintenance saved.');
        }
        else{
            Session::flash('error', 'There is some technical isseu.');
        }
        if ($request->saveandclose == null) {
            return redirect('/maintanance/'.$iid);
        } else {
            return redirect('/maintanances');
        }
    }

 public function application_status(Request $request)
    {
        $iid =$request->input('application_id');
        $ins = DB::table('applications')->where('id', $iid)->first();
        $jobCheker = DB::table('applications')->where('id', '!=', $iid)->where('property_id', $ins->property_id)->where('approve_status', "approved")->first();
        if ($jobCheker && $request->input('status') == 'approved') {
            Session::flash('error', 'Application with same property has been already approved.');
            if ($request->saveandclose == null) {
                return redirect('/application/'.$iid);
            } else {
                return redirect('/applications');
            }
        }
        $booked_status = $ins->approve_status;
        $job = DB::table('applications')->where('id', $iid)->update(array('approve_status'=>$request->input('status'),'updated_at'=>date('Y-m-d H:i:s')));
        if($job){
            // dd($booked_status, $request->input('status'));
            if ($booked_status != 'approved' && $request->input('status') == 'approved') {
                $user = User::find($ins->uid);
                $chat = new Application_message;
                $chat->application_id = $iid;
                $chat->sender_id = auth()->user()->agent_id;
                $chat->receiver_id = $ins->uid;
                $chat->message = "Dear " . $user->name . ",  we're happy to confirm that your application has been successfully reviewd and approved. One of our staff will be in touch with you soon to discuss the next steps.";
                $chat->status = 'active';
                $chat->created_at = date('Y-m-d H:i:s');
                $chat->updated_at = date('Y-m-d H:i:s');
                $chat->save();
                $data=array(
                    'title' =>'Application approved',
                    'body'=>"Dear " . $user->name . ",  we're happy to confirm that your application has been successfully reviewd and approved. One of our staff will be in touch with you soon to discuss the next steps.",
                    'type'=>'application',
                    'id'=>$ins->uid
                );
                $helper = new \App\Helper\helper;
                $helper->pushNotification($ins->uid,$data);
            }
            Session::flash('success', 'Application saved.');
        }
        else{
            Session::flash('error', 'There is some technical isseu.');
        }
        if ($request->saveandclose == null) {
            return redirect('/application/'.$iid);
        } else {
            return redirect('/applications');
        }

    }

    public function notification()
    {
        $data=array('title' =>'test','body'=>'test machine','type'=>'application','id'=>'12');
        $helper = new \App\Helper\helper;
        $helper->pushNotification('1',$data);
    }
}
