<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use Session;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sortby = 'id', $filterby = 'desc')
    {
        $newses = News::orderBy($sortby, $filterby)->where('status', '!=', 'deleted');
        if (isset($_GET['q'])) {
            $search = $_GET['q'];
            $newses->where(function ($query) use ($search) {
                $query
                    ->orWhere('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhere('publish_date', 'LIKE', '%' . $search . '%');
            });
        }
        $newses = $newses->paginate(10);
        return view('backend.news.list', compact('newses'));
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
        $news = new News;
        $news->title = $request->title;
        $news->description = $request->description;
        $news->status = 'active';
        $news->publish_date = date('Y-m-d');
        $news->created_at = date('Y-m-d H:i:s');
        $news->updated_at = date('Y-m-d H:i:s');
        if ($news->save()) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/news') . '/' . $news->id;
                $image->move($destinationPath, $proimage);
                $news->news_images = $proimage;
                $news->save();
            }
            Session::flash('success', 'News Created.');
        } else {
            Session::flash('error', 'Error Creating news.');
        }
        return redirect('/news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);
        return view('backend.news.details', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $news = News::find($request->id);
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
        $validatedData = $request->validate([
            'edit_title' => 'required',
            'edit_desctiption' => 'required',
        ]);
        $news = News::find($request->id);
        $news->title = $request->edit_title;
        $news->description = $request->edit_desctiption;
        $news->updated_at = date('Y-m-d H:i:s');
        if ($news->save()) {
            if ($request->hasFile('edit_image')) {
                $image = $request->file('edit_image');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/news') . '/' . $news->id;
                $image->move($destinationPath, $proimage);
                $news->news_images = $proimage;
                $news->save();
            }
            Session::flash('success', 'News Updated.');
        } else {
            Session::flash('error', 'Error updating news.');
        }
        return redirect('/news');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $news = News::find($request->delete_id);
        $news->status = 'deleted';
        $news->save();
        return response()->json([
            'status' => '1',
            'msg' => 'News deleted.',
            'data' => ''
        ]);
    }
}
