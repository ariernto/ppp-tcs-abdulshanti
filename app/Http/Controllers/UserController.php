<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Permission;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sortby = 'id', $filterby = 'desc')
    {
        $users = User::where('role', "!=", 'user')->where('id', '!=', auth()->user()->id)->where('status', "!=", 'deleted')->orderBy($sortby, $filterby);
        if (isset($_GET['q'])) {
            $search = $_GET['q'];
            $users->where(function ($query) use ($search) {
                $query
                    ->orWhere('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('position', 'LIKE', '%' . $search . '%')
                    ->orWhere('role', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $search . '%');
            });
        }
        $permissions = Permission::all();
        $users = $users->paginate(10);
        return view('backend.users.list', compact('users', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'status' => '0',
                'msg' => 'User already registered.',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'status' => '1',
                'msg' => 'User available.',
                'data' => ''
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'position' => 'required',
            'password' => 'required',
            'permission' => 'required',
        ]);
        $password = Hash::make($request->password);
        $users = new User;
        $proimage = '';
        $users->name = $request->first_name;
        $users->surname = $request->last_name;
        $users->email = $request->email;
        $users->password = $password;
        $users->position = $request->position;
        $users->role = 'admin';
        if ($users->save()) {
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users'.'/'. $users->id);
                $image->move($destinationPath, $proimage);
                $users->profile_image = $proimage;
                $users->save();
            }
            $users->hasPermission()->sync($request->permission);
            Session::flash('success', 'User Created.');
        } else {
            Session::flash('error', 'Error Creating user.');
        }
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('hasPermission')->where('id', $id)->first();
        return view('backend.users.details', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::with('hasPermission')->where('id', $id)->first();
        $hasPermission = [];
        foreach ($users->hasPermission as $userPermission) { array_push($hasPermission, $userPermission->id); }
        $permissions = Permission::all();
        return view('backend.users.edit', compact('users', 'permissions', 'hasPermission'));
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
            'position' => 'required',
            'permission' => 'required',
        ]);
        $users = User::find($id);
        $proimage = '';
        $users->name = $request->first_name;
        $users->surname = $request->last_name;
        $users->email = $request->email;
        $users->position = $request->position;
        if ($users->save()) {
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');
                $proimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users'.'/'. $users->id);
                $image->move($destinationPath, $proimage);
                $users->profile_image = $proimage;
                $users->save();
            }
            $users->hasPermission()->sync($request->permission);
            Session::flash('success', 'User Updated.');
        } else {
            Session::flash('error', 'Error updating user.');
        }
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $users = User::find($request->delete_id);
        $users->status = 'deleted';
        $users->save();
        return response()->json([
            'status' => '1',
            'msg' => 'User deleted.',
            'data' => ''
        ]);
    }

    public function deactivate(Request $request)
    {
        $users = User::find($request->id);
        $users->status = 'inactive';
        if ($users->save()) {
            return response()->json([
                'status' => '1',
                'msg' => 'User set inactive.',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'Error changing user status.',
                'data' => ''
            ]);
        }

    }

    public function activate(Request $request)
    {
        $users = User::find($request->id);
        $users->status = 'active';
        if ($users->save()) {
            return response()->json([
                'status' => '1',
                'msg' => 'User set active.',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'Error changing user status.',
                'data' => ''
            ]);
        }
    }
}
