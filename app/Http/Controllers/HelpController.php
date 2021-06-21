<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Help;
use Session;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sortby = 'id', $filterby = 'desc')
    {
        $helps = Help::orderBy($sortby, $filterby)->where('status', '!=', 'deleted');
        if (isset($_GET['q'])) {
            $search = $_GET['q'];
            $helps->where(function ($query) use ($search) {
                $query
                    ->orWhere('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('quetion', 'LIKE', '%' . $search . '%')
                    ->orWhere('answer', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $search . '%');
            });
        }
        $helps = $helps->paginate(10);
        return view('backend.help.list', compact('helps'));
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $help = new Help;
        $help->quetion = $request->title;
        $help->answer = $request->description;
        $help->status = 'active';
        $help->created_by = $request->title;
        $help->created_at = date('Y-m-d H:i:s');
        $help->updated_at = date('Y-m-d H:i:s');
        if ($help->save()) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/help');
                $image->move($destinationPath, $proimage);
                $help->image = $proimage;
                $help->save();
            }
            Session::flash('success', 'help Created.');
        } else {
            Session::flash('error', 'Error Creating help.');
        }
        return redirect('/help');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $help = Help::find($id);
        return view('backend.help.details', compact('help'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $help = Help::find($request->id);
        return response()->json([
            'status' => '1',
            'msg' => 'Help.',
            'data' => $help
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
            'edit_title' => 'required',
            'edit_desctiption' => 'required'
        ]);

        $help = Help::find($request->id);
        $help->quetion = $request->edit_title;
        $help->answer = $request->edit_desctiption;
        $help->updated_at = date('Y-m-d H:i:s');
        if ($help->save()) {
            if ($request->hasFile('edit_image')) {
                $image = $request->file('edit_image');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/help');
                $image->move($destinationPath, $proimage);
                $help->image = $proimage;
                $help->save();
            }
            Session::flash('success', 'Help Updated.');
        } else {
            Session::flash('error', 'Error updating help.');
        }
        return redirect('/help');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $help = Help::find($request->delete_id);
        $help->status = 'deleted';
        $help->save();
        return response()->json([
            'status' => '1',
            'msg' => 'Help deleted.',
            'data' => ''
        ]);
    }
}
