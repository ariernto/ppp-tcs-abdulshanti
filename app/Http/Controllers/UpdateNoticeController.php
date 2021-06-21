<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UpdateAndNotice;
use Session;

class UpdateNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sortby = 'id', $filterby = 'desc')
    {
        $updateNotices = UpdateAndNotice::where('status', '!=', 'deleted')->orderBy($sortby, $filterby);
        if (isset($_GET['q'])) {
            $search = $_GET['q'];
            $updateNotices->where(function ($query) use ($search) {
                $query
                    ->orWhere('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('type', 'LIKE', '%' . $search . '%')
                    ->orWhere('publish_date', 'LIKE', '%' . $search . '%');
            });
        }
        $updateNotices = $updateNotices->paginate(10);
        // if (count($updateNotices) == 0) {

        // }
        return view('backend.update_notice.list', compact('updateNotices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $updateNotice = new UpdateAndNotice;
        $updateNotice->title = $request->title;
        $updateNotice->description = $request->description;
        $updateNotice->type = $request->category;
        $updateNotice->publish_date = date('Y-m-d H:i:s'); // date_format(date_create($request->booking_date),"Y-m-d H:i:s");;
        $updateNotice->status = 'active';
        $updateNotice->created_at = date('Y-m-d H:i:s');
        $updateNotice->created_by = auth()->user()->id;
        $updateNotice->updated_at = date('Y-m-d H:i:s');
        $updateNotice->updated_by = auth()->user()->id;
        if ($updateNotice->save()) {
            Session::flash('success', 'Update Created.');
        } else {
            Session::flash('error', 'Error Creating update.');
        }
        return redirect('/update-notice');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $updateNotice = UpdateAndNotice::find($id);
        return view('backend.update_notice.details', compact('updateNotice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $news = UpdateAndNotice::find($request->id);
        return response()->json([
            'status' => '1',
            'msg' => 'News.',
            'data' => $news
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
        $updateNotice = UpdateAndNotice::find($request->id);
        $updateNotice->title = $request->edit_title;
        $updateNotice->description = $request->edit_description;
        $updateNotice->type = $request->edit_category;
        $updateNotice->updated_at = date('Y-m-d H:i:s');
        $updateNotice->updated_by = auth()->user()->id;
        if ($updateNotice->save()) {
            Session::flash('success', 'Update Edited.');
        } else {
            Session::flash('error', 'Error editing update.');
        }
        return redirect('/update-notice');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $news = UpdateAndNotice::find($request->delete_id);
        $news->status = 'deleted';
        $news->save();
        return response()->json([
            'status' => '1',
            'msg' => 'Update And Notice deleted.',
            'data' => ''
        ]);
    }

}
