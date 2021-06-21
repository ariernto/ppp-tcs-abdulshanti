<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;



use Session;

class AdminAuthController extends Controller
{

    public function login()
    {
      return view('admin.login');
    }

    public function postlogin(Request $request)
    {
    //print_r($request->input()); die;
      $identity = $request->email;
      $user = User::where('email', $identity)->first();
      if ($user) {
        if ($user->role == 'admin' || $user->role == 'agent') {
          if (Auth::attempt(['id' => $user->id, 'password' => $request['password']])) {
          	$data = session()->all();
          	//print_r($data); die;
						return redirect()->route('properties');
          } else {

				   Session::flash('password', 'Invalid password!');
            return redirect()->route('login');
          }
        } else {
          
            Session::flash('error', 'Invalid login credentials!');
            return redirect()->route('login');
        }
      } else {
        Session::flash('error', 'Invalid login credentials!');
        return redirect()->route('login');
      }
    }

    public function logout()
    {
      Auth::logout();
      return redirect()->route('login');
    }

    public function sended($email="")
    {
      
      return view('auth.passwords.linksended')->with('email',$email);
    }   
}
