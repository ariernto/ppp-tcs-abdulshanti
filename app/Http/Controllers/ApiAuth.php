<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\ForgotPasswordMailer;
use Auth;
use DB;


class ApiAuth extends Controller
{

  // register a user	
  protected function create(Request $request)
  {
  	//  echo $request->name; die;
    $check = User::where("email","=",$request->email)
    ->where("status","!=","deleted")
    ->get(); // get user if exists
    if (count($check) > 0) 
    { // output if user exists
      return [
        "status" => 0,
        "msg" => "This email already registered."
      ];
    } 
    else 
    {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'confirm_password' => 'required|min:6|max:20|same:password',
      ]);
     
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
      ]);
     
      if($user->id)
      { 
        $token = bin2hex(random_bytes(20));
        $devices['uid'] = $user->id;
        $devices['access_token'] = $token;
        $devices['device_id'] = $request->device_id;
        $devices['device_type'] = $request->device_type;
        $devices['created_at'] = date('Y-m-d H:i:s');
        $devices['updated_at'] = date('Y-m-d H:i:s');
        DB::table('devices')->insert($devices);
        $notify['uid'] = $user->id;
        $notify['created_at'] = date('Y-m-d H:i:s');
        $notify['updated_at'] = date('Y-m-d H:i:s');
        DB::table('notifications')->insert($notify);
        
         $email =$request->email;
         $data['data'] = array('name'=> $request->name,'base_url'=>env('APP_URL'));
     $res = Mail::send('email/register', $data, function($message) use ($email) {
         $message->to($email, 'Pacificpalmsproperty')->subject
            ('Pacificpalmsproperty - registration');
         $message->from('no-reply@pacificpalmsproperty.com','Pacificpalmsproperty');
      });
       
        // output if user creation is successful
        return [
          "status" => 1,
          "msg" => "User registered",
          "access_token"=> $token,
          "data" => $user
        ];
      }
      else
      { // output if user creation is unsuccessful
        return [
          "status" => 0,
          "msg" => "Error occured registering user."
        ];
      }
    }
  }

  // login api
  protected function login(Request $request)
  {
    $this->validate($request, [      
      'email' => 'required|email',
      'password' => 'required',     
    ]);

   if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
    {
      $user = User::where('email' ,"=", $request->email)->first();
      if($user != "" && $user->status == 'inactive')
      { // if user is not active resend otp        
        return [
          "status" => 0,
          "msg" => "Account is inactive",
          "data" => ""
        ];
      }
     else
      {
        $token = bin2hex(random_bytes(20));      
        $devices['uid'] = $user->id;
        $devices['access_token'] = $token;
        $devices['device_id'] = $request->device_id;
        $devices['device_type'] = $request->device_type;
        $devices['created_at'] = date('Y-m-d H:i:s');
        $devices['updated_at'] = date('Y-m-d H:i:s');
        DB::table('devices')->insert($devices);
             
        $currentdate =date('Y-m-d H:i:s');
        $users = User::where("id","=",$user->id)->update(['last_login'=>$currentdate]);
       
        return [
          "status" => 1,
          "msg"=>"User loggedin",
          "data" => $user,
          "access_token"=>$token
        ];
      }
    }
     else
    {
      return [
        "status" => 0,
        "msg" => "Invalid credentials"
      ];
    }
  }


  // forget password
  protected function forgot(Request $request)
  {
    // return [$request->email]; 
    // $otp = rand(1000,9999);

    $this->validate($request, [      
      'email' => 'required|email',          
    ]);
    $otp = mt_rand(100000,999999);;
    $user = User::where('email' ,"=", $request->email)
    ->where('status','!=','deleted')
    ->first();
    if($user){
      $data = array(
        'name' => $user->name,
        'email' => $user->email,
        'otp' => $otp,
        'base_url' => config('app.url')
      );
      $token = bin2hex(random_bytes(10));
      $user->otp = $otp;
      $user->forgot_token = $token;
      $user->save();
      Mail::to($user->email)->send(new ForgotPasswordMailer($data));

      $resuser=array('forget_token'=>$token,'uid'=>$user->id);

      return [
        "status" => 1,
        "msg" => "OTP sent to your email.",
        "data" => $resuser
      ];
    }else{
      return [
        "status" => 0,
        "msg" => "User is not registered."
      ];
    }
  }

  // reset password
  public function updatePassword(Request $request)
  {
    // $this->validate($request, [      
    //   'password' => 'required|min:6',
    //   'confirm_password' => 'required|min:6|max:20|same:password',
    // ]);
    $this->validate($request, [      
      'password' => 'required|min:6'
    ]);
    $user = User::where("id","=",$request->input('uid'))
    ->where('status','!=','deleted')
    ->first();
    if($user->otp!=$request->input('otp')){
      return [
        "status" => 0,
        "msg" => "Please enter valid otp."
      ];
    }
    else if($user->forgot_token != $request->input('forgot_token')){
      return [
        "status" => 0,
        "msg" => "Invalid request try again."
      ];  
    }
    else{
      $user->password = bcrypt($request->input('password'));
      $user->forgot_token = "";
      $user->otp = "";
      $user->save();
      return [
        "status" => 1,
        "msg" => "Password changed successfully.",
        "data" => ""
      ];
    }
  }
  // user details
  public function get_details(Request $request)
  {
    $user = User::select('name','surname','email','mobile','phone','profile_image','address','role','latitude','longitude','last_login',\DB::raw("(SELECT count(id) FROM inspections WHERE uid =".$request->input('uid')." AND status !='deleted') as totalinspection"),\DB::raw("(SELECT count(id) FROM applications WHERE uid =".$request->input('uid')." AND status !='deleted') as totalapplication"),\DB::raw("(SELECT count(id) FROM wishlists WHERE uid =".$request->input('uid')." AND status !='deleted') as totalsaved"))->where("id","=",$request->input('uid'))->first();
    if(isset($user)){
    return [
      "status" => 1,
      "msg" => "User details.",
      "data" => $user
    ];
    }
  }
  // update profile
  public function update_profile(Request $request)
  {
    $check = User::where("email","=",$request->email)
    ->where("status","!=","deleted")
    ->where('id',"!=",$request->input('uid'))
    ->get(); // get user if exists
    if (count($check) > 0) 
    { // output if user exists
      return [
        "status" => 0,
        "msg" => "This email already registered."
      ];
    } 
    else 
    {
      $uid  = $request->input('uid');
      $name = $request->input('name');
      $surname = $request->input('surname');  
      $mobile = $request->input('mobile');
      $phone = $request->input('phone');
      $email = $request->input('email');
      $address = $request->input('address');
      $this->validate($request, [
        'name' => 'required',
        'mobile' => 'required',
        'email' => 'required|email',    
        ]);

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $proimage = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/users'.'/'. $uid);
            $image->move($destinationPath, $proimage);
          
        }
      if(!empty($proimage)){  
        $user = User::where("id","=",$request->input('uid'))->update(['name'=>$name,'profile_image'=>$proimage,'surname'=>$surname,'mobile'=>$mobile,'phone'=>$phone,'email'=>$email,'address'=>$address]);
       }else{
          $user = User::where("id","=",$request->input('uid'))->update(['name'=>$name,'surname'=>$surname,'mobile'=>$mobile,'phone'=>$phone,'email'=>$email,'address'=>$address]);
       }
      if(isset($user)){
        return [
          "status" => 1,
          "msg" => "Profile details saved.",
          "data" => ""
        ];
      }
    }
  }
  // chage password  
  public function change_password(Request $request)
  {  
        
   if(Auth::attempt(['id' => $request->uid,'password' => $request->input('oldpassword')]))
    {  
      $password =  bcrypt($request->input('newpassword'));   
      $this->validate($request, [
        'newpassword' => 'required|min:6',
        'confirm_password' => 'required|min:6|max:20|same:newpassword',
      ]);
      $user = User::where("id","=",$request->input('uid'))->update(['password'=>$password]);
      if(isset($user)){
        return [
          "status" => 1,
          "msg" => "Password changed successfully.",
          "data" => ""    
        ];
      }
    }else{
      return [
        "status" => 0,
        "msg" => "OldPassword not  matched.",
        "data" => ""    
      ];

    }
  }
  // create notification
  public function create_notification($title,$description,$type)
  {  
    $notify['title'] = $title;
    $notify['description'] = $description;
    $notify['type'] = $type;
    $notify['status'] = 'active';
    $notify['created_at'] = date('Y-m-d H:i:s');
    $notify['updated_at'] = date('Y-m-d H:i:s');
    $result = DB::table('creat_notifications')->insert($notify);
   if(isset($result)){
    return [
      "status" => 1,
      "msg" => "Notification create successfully.",
      "data" => ""    
    ];
   }
  }
  // notification setting
  public function setings_notification(Request $request)
  {    
    $result = DB::table('notifications')->where("uid","=",$request->input('uid'))->first();
    if(isset($result)){
      return [
        "status" => 1,
        "msg" => "Notification one on and zero off.",
        "data" =>  $result 
      ];
    }
  }


  // notification on off
  public function update_notification(Request $request)
  {  
   
    $notify['uid'] = $request->input('uid');
    $notify['newlisting'] = $request->input('newlisting');
    $notify['interest'] = $request->input('interest');
    $notify['news'] = $request->input('news');
    $notify['event'] = $request->input('event');
    $notify['maintenance'] = $request->input('maintenance');
    $notify['message'] = $request->input('message');
    $notify['update_status'] = $request->input('update_status');  
    $notify['updated_at'] = date('Y-m-d H:i:s');
    $result = DB::table('notifications')->where("uid","=",$request->input('uid'))->update($notify);
   if(isset($result)){
    return [
      "status" => 1,
      "msg" => "Notification changed successfully.",
      "data" => ""    
    ];
   }
  }
   // get notification
  public function get_notification(Request $request)
  {      
    $result = DB::table('creat_notifications')->where('status','active')->get();
    if(isset($result)){
      return [
        "status" => 1,
        "msg" => "Notification get successfully.",
        "data" => $result 
      ];
    }
  }


  // logout
  public function logout(Request $request)
  {
    $device_id = $request->input('device_id');
    $uid = $request->input('uid');
    $logout = DB::table('devices')->where('uid', $uid)->where('device_id', $device_id)->delete();
    if(isset($logout)){
      return [
        "status" => 1,
        "msg" => "Logout successfully."      
      ];
    }
  }

  // latest news list
  public function latest_news(Request $request)
  {   
    $result = DB::table('news')->where('status', 'active')->orderBy('id', 'DESC')->get();
    if(isset($result)){
      return [
        "status" => 1,
        "msg" => "News List.",
        "data" =>$result   
      ];
    }
  }
  // news details
  public function news_details(Request $request)
  {   
    $news_id = $request->input('news_id');
    $result = DB::table('news')->where('id', $news_id)->first();
    if(isset($result)){

     $bookmark = DB::table('news_bookmark')->where('uid',$request->input('uid'))->where('news_id',$request->input('news_id'))->where('status','active')->first();

    if(!empty($bookmark->news_id)){
        $result->bookmark = 1;
      }else{
        $result->bookmark = 0;
      }

      return [
        "status" => 1,
        "msg" => "News Details",
        "data" =>$result   
      ];
    }
  }


// news add to bookmark
public function news_bookmark(Request $request)
     {
        $list = DB::table('news_bookmark')->where('uid',$request->input('uid'))->where('news_id', $request->input('news_id'))->first();

        if(!empty($list)){

            $status = DB::table('news_bookmark')->where('uid',$request->input('uid'))->where('news_id', $request->input('news_id'))->where('status', 'deleted')->first();

         if(!empty($status)){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['status'] = 'active';
            $result = DB::table('news_bookmark')->where('uid',$request->input('uid'))->where('news_id', $request->input('news_id'))->where('status','deleted')->update($data);
           if($result){
              return [
                "status" => 1,
                "msg" => "News has been bookmarked successfully.",
                "data" =>""
              ];
          }
         }else{
          return [
            "status" => 0,
            "msg" => "already added to bookmark.",
            "data" =>""
          ];
         }
        }else{
            $data['uid'] =  $request->input('uid');
            $data['news_id'] =  $request->input('news_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $result = DB::table('news_bookmark')->insert($data);
            if(isset($result)){
            return [
                "status" => 1,
                "msg" => "News has been bookmarked successfully.",
                "data" =>""
            ];
            }
        }
    }
    
 public function news_bookmark_list(Request $request)
     {
      

      $data = DB::table('news_bookmark')->select('news_bookmark.id','news_bookmark.news_id','news.news_images','news.title','news.description','news.publish_date')->where('news_bookmark.uid',$request->input('uid'))->where('news_bookmark.status','!=','deleted')->leftJoin('news', 'news.id', '=', 'news_bookmark.news_id')->orderBy('news_bookmark.updated_at','desc')->get();
                 
       if(!empty($data[0])){
          return [
            "status" => 1,
            "msg" => "News bookmaked list.",
            "data" => $data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "You have not bookmarked any news yet.",
            "data" =>array()
          ];
        }
    }

   //  wishlist deleted
 public function bookmark_delete(Request $request)
      {
        $bookmark = DB::table('news_bookmark')->where('uid',$request->input('uid'))->where('news_id',$request->input('news_id'))->first();
        if(isset($bookmark->id)){
          $data['updated_at'] = date('Y-m-d H:i:s');
          $data['status'] = 'deleted';
          $update = DB::table('news_bookmark')->where('id',$bookmark->id)->update($data);
          if($update){
            return [
              "status" => 1,
              "msg" => "News deleted from bookmark.",
              "data" =>""
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "Record not found.",
              "data" =>""
             ];
            }
          }else{
            return [
              "status" => 0,
              "msg" => "Record not found.",
              "data" =>""
             ];
          }
      }
  // Event list
  public function latest_event(Request $request)
  {   
    $result = DB::table('events')->where('status', 'active')->orderBy('id', 'DESC')->get();
    if(!empty($result[0])){
      return [
        "status" => 1,
        "msg" => "Event List.",
        "data" =>$result   
      ];
    }
  else
     {

        return [
        "status" => 0,
        "msg" => "Pacific Palms Property has cleared out all events for the 2020 calendar due to COVID-19. We shall update this page accordingly when PPP confirms any future events for the year.",
        "data" =>array()   
      ];
     }
  }

    // event details
  public function event_details(Request $request)
  {   
    $event_id = $request->input('event_id');
    $result = DB::table('events')->where('id', $event_id)->first();
    if(isset($result)){
      $eventRegister = DB::table('user_events')->where('uid', $request->input('uid'))->where('event_id', $request->input('event_id'))->first();
      if(!empty($eventRegister->event_id))
         {
           $result->register =1;
         }
       else{
          $result->register =0;
       }
      return [
        "status" => 1,
        "msg" => "event Details",
        "data" =>$result   
      ];
    }
  }

  // event register
  public function register_event(Request $request)
  {   

      $eventdata = DB::table('user_events')->where('uid',$request->input('uid'))->where('event_id',$request->input('event_id'))->get();
  
    if(isset($eventdata) && $eventdata =='[]'){

      $event['uid'] = $request->input('uid');
      $event['event_id'] = $request->input('event_id');
      //$event['event_type'] = $request->input('event_type');
      $event['created_at'] = date('Y-m-d H:i:s');
      $event['updated_at'] = date('Y-m-d H:i:s');
      $result = DB::table('user_events')->insert($event);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" => "You have been successfully registered for the event.",
          "data" =>""  
        ];
      }       
    
    }else{
      $eventid = $request->input('event_id');
      $uid = $request->input('uid');
      $result = DB::table('user_events')->where('uid',$uid)->where('event_id',$eventid)->delete();
      if(isset($result)){
        return [
          "status" => 1,
          "msg" => "Event Cancelled successfully.",
          "data" =>""  
        ];
      }
      
      }

    
  } 

   // MyEvent list
  public function myevents(Request $request)
  {   
    $result = DB::table('user_events')->select('user_events.id','user_events.event_id','events.event_images','events.title','events.description','events.entry_type','events.event_location','events.event_time')->where('user_events.uid',$request->input('uid'))->leftJoin('events', 'events.id', '=', 'user_events.event_id')->orderBy('user_events.id', 'desc')->get();
    if(!empty($result[0])){
      return [
        "status" => 1,
        "msg" => "My event List.",
        "data" =>$result   
      ];
    }
  else
     {

        return [
        "status" => 0,
        "msg" => "You have not participated in any event.",
        "data" =>array()   
      ];
     }
  }
  
    // event register
  public function enquire_event(Request $request)
  {   

    $eventdata = DB::table('user_events')->where('uid',$request->input('uid'))->where('event_id',$request->input('event_id'))->where('event_type', $request->input('event_type'))->get();
  
    if(isset($eventdata) && $eventdata =='[]'){
      $event['uid'] = $request->input('uid');
      $event['event_id'] = $request->input('event_id');
      $event['event_type'] = $request->input('event_type');
      $event['event_message'] = $request->input('message');
      $event['created_at'] = date('Y-m-d H:i:s');
      $event['updated_at'] = date('Y-m-d H:i:s');
      $result = DB::table('user_events')->insert($event);        
      if(isset($result)){
        return [
          "status" => 1,
          "msg" => "Event enquire successfully",
          "data" =>""  
        ];
      }       
    
    }else{
      $eventid = $request->input('event_id');
      $uid = $request->input('uid');
      $result = DB::table('user_events')->where('uid',$uid)->where('event_id',$eventid)->where('event_type',$request->input('event_type'))->delete();
      if(isset($result)){
        return [
          "status" => 1,
          "msg" => "Deleted successfully",
          "data" =>""  
        ];
      }
      
    }

  
  }  
 

   // event register
public function updates_and_notice(Request $request)
  {   

      $updates = DB::table('update_and_notice')->where('status','active')->get();
  
    if(!empty($updates[0])){
    
        return [
          "status" => 1,
          "msg" => "Updates and notice list",
          "data" =>$updates
        ];
           
    
    }else{
    	 return [
          "status" => 0,
          "msg" => "Record not found",
          "data" =>array()
        ];
    }
  } 

 // event register
  public function send_feedback(Request $request)
  {   

      $feddback['uid'] = $request->input('uid');
      $feddback['rate'] = $request->input('rate');
      $feddback['message'] = $request->input('message');
      $feddback['created_at'] = date('Y-m-d H:i:s');
      $feddback['updated_at'] = date('Y-m-d H:i:s');
      $feddbackt = DB::table('feedback')->insert($feddback);        
      if(isset($feddbackt)){
        return [
          "status" => 1,
          "msg" => "Thank you for submitting your feedback!",
          "data" =>""  
        ];
      }else{
            return [
          "status" => 0,
          "msg" => "There is some technical error.",
          "data"=>""  
        ];
      }       
    
  
  }

// Help listing
 public function helps(Request $request)
  {    
    $result = DB::table('helps')->select('id','quetion','answer','image','status','created_by','created_at','updated_at',\DB::raw("IFNULL((SELECT feedback FROM help_feedback WHERE uid =".$request->input('uid')." AND help_id=helps.id),'') as feedback"))->where("status",'active')->get();
    if(!empty($result[0])){
      return [
        "status" => 1,
        "msg" => "Helps list.",
        "data" =>  $result 
      ];
    }else{
      return [
        "status" => 0,
        "msg" => "Record not found.",
        "data" =>array()
      ];
    }
  }

// Help details
 public function help_details(Request $request)
  {    
    $result = DB::table('helps')->where("id",$request->input('help_id'))->where("status",'active')->first();
    if(!empty($result)){
      $res = DB::table('help_feedback')->where("help_id",$request->input('help_id'))->where("uid",$request->input('uid'))->first();
      if(!empty($res->help_id)){
       $result->feedback = $res->feedback;
      }else{
        $result->feedback ="";
      }
      return [
        "status" => 1,
        "msg" => "Helps details.",
        "data" =>  $result 
      ];
    }else{
      return [
        "status" => 0,
        "msg" => "Record not found.",
        "data" =>""
      ];
    }
  }

 // event register
  public function help_feedback(Request $request)
  { 

    $result = DB::table('help_feedback')->where("uid",$request->input('uid'))->where("help_id",$request->input('help_id'))->first();

    if(!empty($result->id))
     {

      $feddback['feedback'] = $request->input('feedback');
      $feddback['updated_at'] = date('Y-m-d H:i:s');
      
      $result12 = DB::table('help_feedback')->where("uid",$request->input('uid'))->where("help_id",$request->input('help_id'))->update($feddback);

        if(isset($result12)){
        return [
          "status" => 1,
          "msg" => "Your feedback was successfully submitted. Thank you!",
          "data" =>""  
        ];
      }else{
            return [
          "status" => 0,
          "msg" => "There is some technical error.",
          "data"=>""  
        ];
       }   
     }
   else{
      $feddback['uid'] = $request->input('uid');
      $feddback['feedback'] = $request->input('feedback');
      $feddback['help_id'] = $request->input('help_id');
      $feddback['created_at'] = date('Y-m-d H:i:s');
      $feddback['updated_at'] = date('Y-m-d H:i:s');
      $feddbackt = DB::table('help_feedback')->insert($feddback);        
      if(isset($feddbackt)){
        return [
          "status" => 1,
          "msg" => "Your feedback was successfully submitted. Thank you!",
          "data" =>""  
        ];
      }else{
            return [
          "status" => 0,
          "msg" => "There is some technical error.",
          "data"=>""  
        ];
      }       
    }
  
  } 

}
