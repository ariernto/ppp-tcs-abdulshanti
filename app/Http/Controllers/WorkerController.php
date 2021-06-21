<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Worker;
use App\Models\Job;
use Session;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sortby = 'id', $filterby = 'desc')
    {
        $workers = Worker::with('lastJob', 'activejobs', 'completedjobs')->where('status', "!=", 'deleted')->orderBy($sortby, $filterby);
        if (isset($_GET['q'])) {
            $search = $_GET['q'];
            $workers->where(function ($query) use ($search) {
                $query
                    ->orWhere('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('designation', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $search . '%');
            });
        }
        $workers = $workers->paginate(10);
        return view('backend.workers.list', compact('workers'));
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
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'profile' => 'required'
        ]);
        $worker = new Worker;
        $worker->name = $request->name;
        $worker->designation = $request->designation;
        $worker->status = 'active';
        $worker->created_by = auth()->user()->id;
        $worker->created_at = date('Y-m-d H:i:s');
        $worker->updated_at = date('Y-m-d H:i:s');
        if ($worker->save()) {
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users'.'/'. $worker->id);
                $image->move($destinationPath, $proimage);
                $worker->profile = $proimage;
                $worker->save();
            }
            Session::flash('success', 'Worker Created.');
        } else {
            Session::flash('error', 'Error Creating worker.');
        }
        return redirect('/workers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workers = Worker::with('hasJobs', 'lastJob', 'activejobs', 'completedjobs')->find($id);
        $completedJobs = Job::where('assign_id', $id)->where('status', 'resolved')->count();
        return view('backend.workers.details', compact('workers', 'completedJobs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $worker = Worker::find($id);
        return response()->json([
            'status' => '1',
            'msg' => 'Worker get.',
            'data' => $worker
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required'
        ]);
        $worker = Worker::find($request->id);
        $worker->name = $request->name;
        $worker->designation = $request->designation;
        $worker->status = 'active';
        $worker->updated_at = date('Y-m-d H:i:s');
        if ($worker->save()) {
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users'.'/'. $worker->id);
                $image->move($destinationPath, $proimage);
                $worker->profile = $proimage;
                $worker->save();
            }
            Session::flash('success', 'Worker Updated.');
        } else {
            Session::flash('error', 'Error updating worker.');
        }
        return redirect('/workers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $users = Worker::find($request->delete_id);
        $users->status = 'deleted';
        $users->save();
        return response()->json([
            'status' => '1',
            'msg' => 'Worker deleted.',
            'data' => ''
        ]);
    }

    public function deactivate(Request $request)
    {
        $users = Worker::find($request->id);
        $users->status = 'inactive';
        if ($users->save()) {
            return response()->json([
                'status' => '1',
                'msg' => 'Worker set inactive.',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'Error changing worker status.',
                'data' => ''
            ]);
        }
    }
    public function activate(Request $request)
    {
        $users = Worker::find($request->id);
        $users->status = 'active';
        if ($users->save()) {
            return response()->json([
                'status' => '1',
                'msg' => 'Worker set active.',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'Error changing worker status.',
                'data' => ''
            ]);
        }
    }
}
