<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Job;
use App\Models\Category;
use App\Models\Property_features;
use Illuminate\Support\Facades\Http;

use App\Property;
use App\Agent;
use App\Property_detail;
use App\Agent_detail;
use App\Application;
use App\Models\Inspection;
use App\Models\Wishlist;
use Auth;
use DB;
use Illuminate\Support\Facades\File;

class ApiProperties extends Controller
{



   // create enquiry
   public function create_enquiry(Request $request)
   {

     if(!empty($request->input('agent_id'))){
       $agentId = $request->input('agent_id');
     }
     else{
         $agentId = 304003;
     }
    if(!empty($request->input('property_id'))){
      $data['property_id'] = $request->input('property_id');

     }
     if(!empty($request->input('type'))){
      $data['type'] = $request->input('type');
     }
     $data['uid'] =  $request->input('uid');
     $data['agent_id'] =  $agentId;
     $data['subjects'] =  $request->input('subject');
     $data['message'] =  $request->input('message');
     $data['created_at'] = date('Y-m-d H:i:s');
     $data['updated_at'] = date('Y-m-d H:i:s');



     $result = DB::table('enquiries')->insert($data);
     if($result){
      $result1 = DB::table('enquiries')->orderby('id','desc')->first();
        $data1['sender_id'] =  $request->input('uid');
        $data1['receiver_id'] = $agentId;
        $data1['enquiry_id'] = $result1->id;
        $data1['message'] = $request->input('message');
        $data1['created_at'] = date('Y-m-d H:i:s');
        $data1['updated_at'] = date('Y-m-d H:i:s');
        DB::table('enquiry_messages')->insert($data1);
      if(isset($result)){

      	if(!empty($request->input('type')) && $request->input('type')=='contact'){
            $resMsg ="Your enquiry has been successfully sent. One of our staff will be in touch with you in the next 24 hours.";
      	}
      	else{

      		$resMsg ="Your enquiry has been successfully sent. One of our staff will be in touch with you in the next 24 hours.";
      	}

        return [
          "status" => 1,
          "msg" => $resMsg,
          "data" =>""
        ];
      }
    }
  }

    //  enquiries list
  public function enquiries_list(Request $request)
    {
      if($request->input('search') !=''){
       $serch = $request->input('search');
        $result = DB::table('enquiries')->select('enquiries.id','enquiries.agent_id','agent_details.first_name','agent_details.last_name','agent_details.photos_landscape','agent_details.photos_portrait','enquiries.subjects','enquiries.message','enquiries.status','enquiries.created_at','enquiries.updated_at',\DB::raw("(SELECT message FROM enquiry_messages WHERE enquiry_messages.enquiry_id = enquiries.id ORDER BY id DESC LIMIT 1) as last_message"))->leftJoin('agent_details', 'agent_details.agent_id', '=', 'enquiries.agent_id')->where('uid',$request->input('uid'))->where('enquiries.status','active')->where(function($q) use($serch) {
         return $q->where('agent_details.first_name', 'LIKE', "%$serch%")
           ->orWhere('agent_details.first_name', 'LIKE', "%$serch%")->orWhere('enquiries.subjects', 'LIKE', "%$serch%");
      })->orderBy('enquiries.id', 'DESC')->distinct()->get();
      }else{
        $result = DB::table('enquiries')->select('enquiries.id','enquiries.agent_id','agent_details.first_name','agent_details.last_name','agent_details.photos_landscape','agent_details.photos_portrait','enquiries.subjects','enquiries.message','enquiries.status','enquiries.created_at','enquiries.updated_at',\DB::raw("(SELECT message FROM enquiry_messages WHERE enquiry_messages.enquiry_id = enquiries.id ORDER BY id DESC LIMIT 1) as last_message"))->leftJoin('agent_details', 'agent_details.agent_id', '=', 'enquiries.agent_id')->where('uid',$request->input('uid'))->where('enquiries.status','active')->orderBy('enquiries.id', 'DESC')->distinct()->get();
      }

      if(isset($result)){




        return [
          "status" => 1,
          "msg" => "List of enquiries.",
          "data" =>$result
        ];
      }
    }
    //  send message
    public function enquiries_message(Request $request)
    {
          // $data['property_id'] =  $request->input('property_id');
          $data['sender_id'] =  $request->input('uid');
          $data['receiver_id'] =  $request->input('receiver_id');
          $data['enquiry_id'] =  $request->input('enquiry_id');
          $data['message'] =  $request->input('message');

          $data['created_at'] = date('Y-m-d H:i:s');
          $data['updated_at'] = date('Y-m-d H:i:s');

          $result = DB::table('enquiry_messages')->insert($data);
          if(isset($result)){
            return [
              "status" => 1,
              "msg" =>"Send mesage successfully .",
              "data" =>""
            ];
          }
    }

     //  enquiry  message list
     public function enquiries_message_list(Request $request)
     {
      $result = DB::table('enquiry_messages')->where('enquiry_id', $request->input('enquiry_id'))->where('status','active')->get();
      if(isset($result)){
         $agentdata = array();
        if(!empty($result)){
             if($result[0]->sender_id==$request->input('uid'))
               {
                $agent_id = $result[0]->receiver_id;
               }
            else{
                 $agent_id = $result[0]->sender_id;
              }
           $agentdata = DB::table('agent_details')->select('first_name','last_name','photos_landscape')->where('agent_id', $agent_id)->first();
        }
        return [
          "status" => 1,
          "msg" =>"enquiry mesage list .",
          "data" => $result,
          "agentdata"=>$agentdata
        ];
      }

     }
      // inspect status update
    public function enquiries_status(Request $request)
    {

      $data['status'] =  $request->input('status');
      if($request->input('status') =='deleted'){
      $msg = "Deleted successfully.";
      }
      if($request->input('status') =='archive'){
      $msg = "Archived successfully.";
      }
      if($request->input('status') =='cancel'){
      $msg = "Cancelled successfully.";
      }
      if($request->input('status') =='mute'){
      $msg = "Mute successfully.";
      }
      $data['updated_at'] = date('Y-m-d H:i:s');
      $result = DB::table('enquiries')->where('uid', $request->input('uid'))->where('id', $request->input('enquery_id'))->update($data);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" =>$msg,
          "data" =>""
        ];
      }

    }

  public function wishlist(Request $request)
     {


      $data = Wishlist::select('property_details.item_id','property_details.type','property_details.property_type','property_details.property_type2','property_details.deal_type','property_details.photos','property_details.garage_spaces','property_details.bedrooms','property_details.number_of_floors','property_details.bathrooms','property_details.headline','property_details.description','property_details.authority','property_details.current_rent','property_details.price_text','property_details.features','property_details.address','property_details.rent_type','land_area','land_area_metric','floor_area','floor_area_metric','warehouse_area','warehouse_area_metric','retail_area','retail_area_metric','carport_spaces','wishlists.status','wishlists.id','wishlists.created_at','wishlists.updated_at')->where('wishlists.uid',$request->input('uid'))->where('wishlists.status','!=','deleted')->leftJoin('property_details', 'property_details.item_id', '=', 'wishlists.property_id')->orderBy('wishlists.updated_at','desc')->get();

       if(isset($data)){
          return [
            "status" => 1,
            "msg" => "wishlist list",
            "data" => $data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "wishlist not found. ",
            "data" =>array()
          ];
        }
    }

    // wishlist add
     public function wishlist_add(Request $request)
     {
        $list = DB::table('wishlists')->where('uid',$request->input('uid'))->where('property_id', $request->input('property_id'))->get();
        if(isset($list) && $list  !='[]'){
            $status = DB::table('wishlists')->where('uid',$request->input('uid'))->where('status', 'deleted')->get();
         if($status !='[]'){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['status'] = 'active';
            $result = DB::table('wishlists')->where('uid',$request->input('uid'))->where('property_id', $request->input('property_id'))->where('status','deleted')->update($data);
           if($result){
              return [
                "status" => 1,
                "msg" => "Property added to wishlist.",
                "data" =>""
              ];
          }
         }else{
          return [
            "status" => 0,
            "msg" => "already added to wishlist.",
            "data" =>""
          ];
         }
        }else{
            $data['uid'] =  $request->input('uid');
            $data['property_id'] =  $request->input('property_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $result = DB::table('wishlists')->insert($data);
            if(isset($result)){
            return [
                "status" => 1,
                "msg" => "Property added to the wishlist.",
                "data" =>""
            ];
            }
        }
    }

    //  wishlist clear
    public function wishlist_clear(Request $request)
    {
       $wishlist = DB::table('wishlists')->where('uid',$request->input('uid'))->get();
       if(isset( $wishlist)) {
         $update ='';
         $data['updated_at'] = date('Y-m-d H:i:s');
         $data['status'] = 'deleted';
           $update = DB::table('wishlists')->where('uid',$request->input('uid'))->update($data);
         if($update){
           return [
             "status" => 1,
             "msg" => "Wishlist cleared.",
             "data" =>""
           ];
         }else{
           return [
             "status" => 0,
             "msg" => "Wishlist not found.",
             "data" =>""
           ];
          }
        }
    }
      //  wishlist deleted
      public function wishlist_delete(Request $request)
      {
        $wishlist = DB::table('wishlists')->where('uid',$request->input('uid'))->where('property_id',$request->input('wishlist_id'))->first();
        if(isset($wishlist->id)) {
          $data['updated_at'] = date('Y-m-d H:i:s');
          $data['status'] = 'deleted';
          $update = DB::table('wishlists')->where('id',$wishlist->id)->update($data);
          if($update){
            return [
              "status" => 1,
              "msg" => "Property deleted from wishlist.",
              "data" =>""
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "Wishlist not found.",
              "data" =>""
            ];
            }
          }
      }
       //  wishlist undo
      public function wishlist_undo(Request $request)
      {
        $wishlist = DB::table('wishlists')->where('uid',$request->input('uid'))->where('id',$request->input('wishlist_id'))->first();
        if(isset($wishlist->id)) {
          $data['updated_at'] = date('Y-m-d H:i:s');
          $data['status'] = 'active';
          $update = DB::table('wishlists')->where('id',$wishlist->id)->update($data);
          if($update){
            return [
              "status" => 1,
              "msg" => "Property added to the wishlist.",
              "data" =>""
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "Wishlist not found.",
              "data" =>""
            ];
            }
          }
      }
       //  create job
      public function job_create(Request $request)
      {
         //print_r($request->input()); die;
            $data =array();
           if($request->hasfile('filepath'))
            {

             $files= $request->file('filepath');
                foreach($files as $file)
                {
                    $name=time().$file->getClientOriginalName();
                    File::makeDirectory(public_path().'/uploads/job'.'/'.$request->input('uid'), $mode = 0777, true, true);
                    $file->move(public_path().'/uploads/job'.'/'.$request->input('uid'), $name);
                    $data[] = $name;
                }

            }
          $agentId = 304003;

          $job= new Job();
          $job->uid =  $request->input('uid');
          $job->agent_id =  $agentId;
          $job->property_id =  $request->input('property_id');
          $job->mantinance_type =  $request->input('job_type');
          $job->title =  $request->input('title');
          $job->description =  $request->input('description');
          $job->hours =  $request->input('hours');
          $job->created_at =  date('Y-m-d H:i:s');
          $job->updated_at =  date('Y-m-d H:i:s');
          $job->filepath =json_encode($data);

        if($job->save()){

        $data1['sender_id'] =  $request->input('uid');
        $data1['receiver_id'] = $agentId;
        $data1['job_id'] = $job->id;
        $data1['message'] = $request->input('description');
        $data1['created_at'] = date('Y-m-d H:i:s');
        $data1['updated_at'] = date('Y-m-d H:i:s');
        DB::table('jobs_messages')->insert($data1);
            return [
              "status" => 1,
              "msg" => "Your maintenance request has been successfully lodged. Our maintenance team will be in touch with you within 24 hours to schedule an appropriate time to attend to this issue.",
              "data" =>""
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "job create error.",
              "data" =>""
            ];
          }

      }
       //  job list
      public function job_list(Request $request)
      {

        $job= DB::table('jobs')->select('jobs.id','jobs.agent_id','jobs.assign_id','jobs.property_id','jobs.mantinance_type','jobs.title','jobs.description','jobs.hours','jobs.status','jobs.created_at','property_details.address')->where('uid',$request->input('uid'))->where('jobs.status','!=','deleted')->leftJoin('property_details', 'property_details.item_id', '=', 'jobs.property_id')->orderBy('jobs.id','desc')->get();
        if(!empty($job)){
           return [
              "status" => 1,
              "msg" => "All your maintenance requests will appear here, in your jobs list. Maintenance requests are job cards you can raise for any maintenance-related issue on your property. This ensures PPP is adequately notified to immediately resolve the issue. To raise a job card, simply tap on the plus icon located on the bottom-righ of this screen, select your property, fill in the required fields, and hit submit.",
              "data" => $job
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "All your maintenance requests will appear here, in your jobs list. Maintenance requests are job cards you can raise for any maintenance-related issue on your property. This ensures PPP is adequately notified to immediately resolve the issue. To raise a job card, simply tap on the plus icon located on the bottom-righ of this screen, select your property, fill in the required fields, and hit submit.",
              "data" =>array()
            ];

          }
      }

        //  job list
      public function job_details(Request $request)
      {

        $job= DB::table('jobs')->select('jobs.id','jobs.assign_id','jobs.property_id','jobs.mantinance_type','jobs.title','jobs.description','jobs.hours','jobs.status','jobs.created_at','jobs.filepath','property_details.address')->where('uid',$request->input('uid'))->where('jobs.status','!=','deleted')->where('jobs.id',$request->input('job_id'))->leftJoin('property_details', 'property_details.item_id', '=', 'jobs.property_id')->first();
        if(isset($job)){
           return [
              "status" => 1,
              "msg" => "Job list",
              "data" => $job
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "job not found.",
              "data" =>array()
            ];

          }
      }


       //  job cancel delete archive mute
      public function job_status(Request $request)
      {

      	if($request->input('status')=='deleted')
      	   {
             $msg = "Maintenance request deleted successfully.";
      	   }
      	else{
             $msg = "Maintenance request cancelled successfully.";
         	}

        $job= DB::table('jobs')->where('uid',$request->input('uid'))->where('id',$request->input('job_id'))->update(['status'=>$request->input('status')]);
        if(isset($job)) {
           return [
              "status" => 1,
              "msg" => $msg,
              "data" =>""
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "job not found.",
              "data" =>""
            ];

          }
      }


 public function job_message_list(Request $request)
        {
          $result = DB::table('jobs_messages')->where('job_id', $request->input('job_id'))->where('status','active')->get();
          if(isset($result)){
             $agentdata = array();
            if(!empty($result)){
                 if($result[0]->sender_id==$request->input('uid'))
                   {
                    $agent_id = $result[0]->receiver_id;
                   }
                else{
                     $agent_id = $result[0]->sender_id;
                  }
               $agentdata = DB::table('agent_details')->select('first_name','last_name','photos_landscape')->where('agent_id', $agent_id)->first();
            }
            return [
              "status" => 1,
              "msg" =>"Job mesage list.",
              "data" => $result,
              "agentdata"=>$agentdata
            ];
          }
     }


public function job_message_send(Request $request)
    {

      //$data['property_id'] =  $request->input('property_id');
      $data['sender_id'] =  $request->input('uid');
      $data['receiver_id'] =  $request->input('receiver_id');
      $data['job_id'] =  $request->input('job_id');
      $data['message'] =  $request->input('message');

      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');

      $result = DB::table('jobs_messages')->insert($data);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" =>"Message sent successfully.",
          "data" =>""
        ];
      }

    }


public function job_review_rating(Request $request)
    {

      //$data['property_id'] =  $request->input('property_id');

      $data['job_id'] =  $request->input('job_id');
      $data['rating'] =  $request->input('rating');
      $data['review'] =  $request->input('review');
      $data['created_by'] =  $request->input('uid');
      $data['updated_by'] =  $request->input('uid');
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');

      $result = DB::table('job_ratings')->insert($data);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" =>"Message sent successfully.",
          "data" =>""
        ];
      }

    }

      // category base job list
      public function explore_property(Request $request)
      {

        $data['commercial'] = Property::select('item_id','headline','address','deal_type','photos','authority','price_text','display_price','current_rent')->where('type','Commercial')->where('property_type','!=','Retail')->where('property_type','!=','Industrial')->where('status','1')->take(10)->get();
        $data['residental'] = Property::select('item_id','headline','address','deal_type','photos','authority','price_text','display_price','current_rent')->where('type','ResidentialLease')->where('property_type','!=','Retail')->where('property_type','!=','Industrial')->where('status','1')->take(10)->get();
        $data['industrial'] = Property::select('item_id','headline','address','deal_type','photos','authority','price_text','display_price','current_rent')->where('property_type','Industrial')->where('status','1')->take(10)->get();
        $data['retail'] = Property::select('item_id','headline','address','deal_type','photos','authority','price_text','display_price','current_rent')->where('property_type','Retail')->where('status','1')->take(10)->get();

        if(isset($data)) {
           return [
              "status" => 1,
              "msg" => "Succesfully",
              "data" =>$data
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "Property not found.",
              "data" =>""
            ];

          }
      }




      // create property
      public function create_property(Request $request)
      {

          $endpoint ="https://api2.agentaccount.com/properties";
          $client = new \GuzzleHttp\Client();
          $token = '4de1a0d5afbf7b9789198037c34293a83e04eb51';
          $response = $client->request('GET', $endpoint, ['query' => [
              'token' => $token,
              'per_page'=>100
          ]]);


          $statusCode = $response->getStatusCode();
           $data = (string) $response->getBody();

           $d =json_decode($data);
            //echo count($d->results); die;
          $itemid= [];
          $itemp=[];
            foreach($d->results as $arr){

            $res  =array();
            $res2 =array();

              $itemid[] = $arr->id;
              $res['item_id'] =$arr->id;

              if(!empty($arr->office_id)){
                $res['office_id'] = $arr->office_id;
              }
              if(!empty($arr->agent_id_1)){
                $res['agent_id_1'] = $arr->agent_id_1;
              }
              if(!empty($arr->agent_id_2)){
                $res['agent_id_2'] = $arr->agent_id_2;
              }
              if(!empty($arr->type)){
                $res['type'] = $arr->type;
              }
              if(!empty($arr->property_type)){
                $res['property_type'] = $arr->property_type;
              }
              if(!empty($arr->deal_type)){
                $res['deal_type'] = $arr->deal_type;
              }
              if(!empty($arr->rent_type)){
                $res['rent_type'] = $arr->rent_type;
              }
              if(!empty($arr->property_type2)){
                $res['property_type2'] = $arr->property_type2;
              }
              if(!empty($arr->property_type3)){
                $res['property_type3'] = $arr->property_type3;
              }
              if(!empty($arr->photos)){
                $res['photos'] = json_encode($arr->photos);
              }
              if(!empty($arr->headline)){
                $res['headline'] = $arr->headline;
              }
              if(!empty($arr->description)){
                $res['description'] = $arr->description;
              }
              if(!empty($arr->authority)){
                $res['authority'] = $arr->authority;
              }
              if(!empty($arr->current_rent)){
                $res['current_rent'] = $arr->current_rent;
              }
              if(!empty($arr->current_rent_include_tax)){
                $res['current_rent_include_tax'] = $arr->current_rent_include_tax;
              }
              if(!empty($arr->address)){
                $res['address'] = json_encode($arr->address);
                $lat = json_encode($arr->address);

                $res['latitude'] = json_decode($lat)->latitude;
                $res['longitude'] = json_decode($lat)->longitude;
              }

              if(!empty($arr->display_address)){
                $res['display_address'] = $arr->display_address;
              }
              if(!empty($arr->price_text)){
                $res['price_text'] = $arr->price_text;
              }
              if(!empty($arr->display_price)){
                $res['display_price'] = $arr->display_price;
              }
              if(!empty($arr->price_include_tax)){
                $res['price_include_tax'] = $arr->price_include_tax;
              }
              if(!empty($arr->rental_yield)){
                $res['rental_yield'] = $arr->rental_yield;
              }
              if(!empty($arr->zoning)){
                $res['zoning'] = $arr->zoning;
              }
              if(!empty($arr->parking)){
                $res['parking'] = $arr->parking;
              }
              if(!empty($arr->current_leased)){
                $res['current_leased'] = $arr->current_leased;
              }
              if(!empty($arr->tenancy_option)){
                $res['tenancy_option'] = $arr->tenancy_option;
              }
              if(!empty($arr->lease_further_option)){
                $res['lease_further_option'] = $arr->lease_further_option;
              }
              if(!empty($arr->land_area)){
                $res['land_area'] = $arr->land_area;
              }
              if(!empty($arr->land_area_to)){
                $res['land_area_to'] = $arr->land_area_to;
              }
              if(!empty($arr->land_area_metric)){
                $res['land_area_metric'] = $arr->land_area_metric;
              }
              if(!empty($arr->floor_area)){
                $res['floor_area'] = $arr->floor_area;
              }
              if(!empty($arr->floor_area_metric)){
                $res['floor_area_metric'] = $arr->floor_area_metric;
              }
              if(!empty($arr->area_range)){
                $res['area_range'] = $arr->area_range;
              }
              if(!empty($arr->area_range_to)){
                $res['area_range_to'] = $arr->area_range_to;
              }
              if(!empty($arr->land_frontage_metric)){
                $res['land_frontage_metric'] = $arr->land_frontage_metric;
              }
              if(!empty($arr->land_depth_left_metric)){
                $res['land_depth_left_metric'] = $arr->land_depth_left_metric;
              }
              if(!empty($arr->land_depth_right_metric)){
                $res['land_depth_right_metric'] = $arr->land_depth_right_metric;
              }
              if(!empty($arr->land_depth_rear_metric)){
                $res['land_depth_rear_metric'] = $arr->land_depth_rear_metric;
              }
              if(!empty($arr->land_crossover)){
                $res['land_crossover'] = $arr->land_crossover;
              }
              if(!empty($arr->energy_efficiency_rating)){
                $res['energy_efficiency_rating'] = $arr->energy_efficiency_rating;
              }
              if(!empty($arr->energy_efficiency_rating)){
                $res['energy_efficiency_rating'] = $arr->energy_efficiency_rating;
              }
              if(!empty($arr->energy_efficiency_rating)){
                $res['energy_efficiency_rating'] = $arr->energy_efficiency_rating;
              }
              if(!empty($arr->all_the_floor)){
                $res['all_the_floor'] = $arr->all_the_floor;
              }
              if(!empty($arr->all_the_building)){
                $res['all_the_building'] = $arr->all_the_building;
              }
              if(!empty($arr->forthcoming_auction)){
                $res['forthcoming_auction'] = $arr->forthcoming_auction;
              }
              if(!empty($arr->office_area_metric)){
                $res['office_area_metric'] = $arr->office_area_metric;
              }
              if(!empty($arr->warehouse_area_metric)){
                $res['warehouse_area_metric'] = $arr->warehouse_area_metric;
              }
              if(!empty($arr->retail_area_metric)){
                $res['retail_area_metric'] = $arr->retail_area_metric;
              }
              if(!empty($arr->other_area_metric)){
                $res['other_area_metric'] = $arr->other_area_metric;
              }
              if(!empty($arr->outgoings_paid_by_tenant)){
                $res['outgoings_paid_by_tenant'] = $arr->outgoings_paid_by_tenant;
              }
              if(!empty($arr->listings_this_address)){
                $res['listings_this_address'] = $arr->listings_this_address;
              }
              if(!empty($arr->method_of_sale)){
                $res['method_of_sale'] = $arr->method_of_sale;
              }
              if(!empty($arr->status)){
                $res['status'] = $arr->status;
              }


              if(!empty($arr->opentimes)){
                $res['opentimes'] = $arr->opentimes;
              }
              if(!empty($arr->exports_old)){
                $res['exports_old'] = $arr->exports_old;
              }
              if(!empty($arr->translations)){
                $res['translations'] = $arr->translations;
              }

              $res['created_at'] =$arr->created_at;
              $res['updated_at'] =$arr->updated_at;

               $endpoint2 ="https://api2.agentaccount.com/properties/".$arr->id;
               $client2 = new \GuzzleHttp\Client();
              $token2 = '4de1a0d5afbf7b9789198037c34293a83e04eb51';
              $response2 = $client2->request('GET', $endpoint2, ['query' => [
                  'token' => $token2
              ]]);
              $statusCode = $response->getStatusCode();
              $data2 = (string) $response2->getBody();

               $d2 =json_decode($data2);
               $res2['item_id'] = $d2->id;

               if(!empty($d2->office_id)){
                $res2['office_id'] = $d2->office_id;
              }
              if(!empty($d2->agent_id_1)){
                $res2['agent_id_1'] = $d2->agent_id_1;
              }
              if(!empty($d2->agent_id_2)){
                $res2['agent_id_2'] = $d2->agent_id_2;
              }
              if(!empty($d2->type)){
                $res2['type'] = $d2->type;
              }
              if(!empty($d2->property_type)){
                $res2['property_type'] = $d2->property_type;
              }
              if(!empty($d2->deal_type)){
                $res2['deal_type'] = $d2->deal_type;
              }
              if(!empty($d2->rent_type)){
                $res2['rent_type'] = $d2->rent_type;
              }
              if(!empty($d2->property_type2)){
                $res2['property_type2'] = $d2->property_type2;
              }
              if(!empty($d2->property_type3)){
                $res2['property_type3'] = $d2->property_type3;
              }
              if(!empty($d2->photos)){
                $res2['photos'] = json_encode($d2->photos);
              }
              if(!empty($d2->headline)){
                $res2['headline'] = $d2->headline;
              }
              if(!empty($d2->description)){
                $res2['description'] = $d2->description;
              }
              if(!empty($d2->authority)){
                $res2['authority'] = $d2->authority;
              }
              if(!empty($d2->current_rent)){
                $res2['current_rent'] = $d2->current_rent;
              }
              if(!empty($d2->current_rent_include_tax)){
                $res2['current_rent_include_tax'] = $d2->current_rent_include_tax;
              }
              if(!empty($d2->address)){
                $res2['address'] = json_encode($d2->address);
                $lat = json_encode($d2->address);

                $res2['latitude'] = json_decode($lat)->latitude;
                $res2['longitude'] = json_decode($lat)->longitude;
              }

              if(!empty($d2->display_address)){
                $res2['display_address'] = $d2->display_address;
              }
              if(!empty($arr->price_text)){
                $res2['price_text'] = $d2->price_text;
              }
              if(!empty($d2->display_price)){
                $res2['display_price'] = $d2->display_price;
              }
              if(!empty($d2->price_include_tax)){
                $res2['price_include_tax'] = $d2->price_include_tax;
              }
              if(!empty($d2->rental_yield)){
                $res2['rental_yield'] = $d2->rental_yield;
              }
              if(!empty($d2->zoning)){
                $res2['zoning'] = $d2->zoning;
              }
              if(!empty($d2->parking)){
                $res2['parking'] = $d2->parking;
              }
              if(!empty($d2->current_leased)){
                $res2['current_leased'] = $arr->current_leased;
              }
              if(!empty($d2->tenancy_option)){
                $res2['tenancy_option'] = $d2->tenancy_option;
              }
              if(!empty($d2->lease_further_option)){
                $res2['lease_further_option'] = $d2->lease_further_option;
              }
              if(!empty($d2->land_area)){
                $res2['land_area'] = $d2->land_area;
              }
              if(!empty($d2->land_area_to)){
                $res2['land_area_to'] = $d2->land_area_to;
              }
              if(!empty($d2->land_area_metric)){
                $res2['land_area_metric'] = $d2->land_area_metric;
              }
              if(!empty($d2->floor_area)){
                $res2['floor_area'] = $d2->floor_area;
              }
              if(!empty($d2->floor_area_metric)){
                $res2['floor_area_metric'] = $d2->floor_area_metric;
              }
              if(!empty($d2->area_range)){
                $res2['area_range'] = $d2->area_range;
              }
              if(!empty($arr->area_range_to)){
                $res2['area_range_to'] = $arr->area_range_to;
              }
              if(!empty($arr->land_frontage_metric)){
                $res2['land_frontage_metric'] = $arr->land_frontage_metric;
              }
              if(!empty($arr->land_depth_left_metric)){
                $res2['land_depth_left_metric'] = $arr->land_depth_left_metric;
              }
              if(!empty($d2->land_depth_right_metric)){
                $res2['land_depth_right_metric'] = $d2->land_depth_right_metric;
              }
              if(!empty($d2->land_depth_rear_metric)){
                $res2['land_depth_rear_metric'] = $d2->land_depth_rear_metric;
              }
              if(!empty($d2->land_crossover)){
                $res2['land_crossover'] = $d2->land_crossover;
              }
              if(!empty($d2->energy_efficiency_rating)){
                $res2['energy_efficiency_rating'] = $d2->energy_efficiency_rating;
              }
              if(!empty($d2->energy_efficiency_rating)){
                $res2['energy_efficiency_rating'] = $d2->energy_efficiency_rating;
              }
              if(!empty($d2->energy_efficiency_rating)){
                $res2['energy_efficiency_rating'] = $d2->energy_efficiency_rating;
              }
              if(!empty($d2->all_the_floor)){
                $res2['all_the_floor'] = $d2->all_the_floor;
              }
              if(!empty($d2->all_the_building)){
                $res2['all_the_building'] = $d2->all_the_building;
              }
              if(!empty($d2->forthcoming_auction)){
                $res2['forthcoming_auction'] = $d2->forthcoming_auction;
              }
              if(!empty($d2->office_area_metric)){
                $res2['office_area_metric'] = $d2->office_area_metric;
              }
              if(!empty($d2->warehouse_area_metric)){
                $res2['warehouse_area_metric'] = $d2->warehouse_area_metric;
              }
              if(!empty($d2->retail_area_metric)){
                $res2['retail_area_metric'] = $d2->retail_area_metric;
              }
              if(!empty($d2->other_area_metric)){
                $res2['other_area_metric'] = $d2->other_area_metric;
              }
              if(!empty($d2->outgoings_paid_by_tenant)){
                $res2['outgoings_paid_by_tenant'] = $d2->outgoings_paid_by_tenant;
              }
              if(!empty($d2->listings_this_address)){
                $res2['listings_this_address'] = $d2->listings_this_address;
              }
              if(!empty($d2->method_of_sale)){
                $res2['method_of_sale'] = $d2->method_of_sale;
              }
              if(!empty($d2->status)){
                $res2['status'] = $d2->status;
              }
              if(!empty($d2->rural)){
                $res2['rural'] = $d2->rural;
              }
               if(!empty($d2->price)){
                $res2['price'] = $d2->price;
                $p=$d2->price;
              }else{
              	$p=0;
              }
              $itemp[] = $p.'='.$d2->id;
               if(!empty($d2->property_type_sub)){
                $res2['property_type_sub'] = $d2->property_type_sub;
              }
              if(!empty($d2->property_type2_sub)){
                $res2['property_type2_sub'] = $d2->property_type2_sub;
              }
            if(!empty($d2->property_type3_sub)){
                $res2['property_type3_sub'] = $d2->property_type3_sub;
              }
              if(!empty($d2->price_to)){
                $res2['price_to'] = $d2->price_to;
              }
           if(!empty($d2->price_per)){
                $res2['price_per'] = $d2->price_per;
              }
               if(!empty($d2->garage_spaces)){
                $res2['garage_spaces'] = $d2->garage_spaces;
              }
             if(!empty($d2->bedrooms)){
                $res2['bedrooms'] = $d2->bedrooms;
              }
            if(!empty($d2->parking_spaces)){
                $res2['parking_spaces'] = $d2->parking_spaces;
              }
             if(!empty($d2->bathrooms)){
                $res2['bathrooms'] = $d2->bathrooms;
              }
             if(!empty($d2->bathrooms)){
                $res2['bathrooms'] = $d2->bathrooms;
              }



              if(!empty($d2->features)){
                $res2['features'] = json_encode($d2->features);
              }
              if(!empty($d2->floorplans)){
                $res2['floorplans'] = json_encode($d2->floorplans);
              }
              if(!empty($d2->brochures)){
                $res2['brochures'] = json_encode( $d2->brochures);
              }
              if(!empty($d2->projects)){
                $res2['projects'] =json_encode( $d2->projects);
              }
              if(!empty($d2->custom)){
                $res2['custom'] = json_encode( $d2->custom) ;
              }
              if(!empty($d2->exports)){
                $res2['exports'] = json_encode( $d2->exports);
              }

              if(!empty($d2->opentimes)){
                $res2['opentimes'] =  json_encode( $d2->opentimes);
              }
              if(!empty($d2->exports_old)){
                $res2['exports_old'] =  json_encode( $d2->exports_old);
              }
              if(!empty($d2->translations)){
                $res2['translations'] =  json_encode( $d2->translations);
              }
            if(!empty($d2->warehouse_area)){
             $res2['warehouse_area'] =  json_encode( $d2->warehouse_area);
             }
             if(!empty($d2->retail_area)){
             $res2['retail_area'] =  json_encode( $d2->retail_area);
             }
             if(!empty($d2->carport_spaces)){
             $res2['carport_spaces'] =  json_encode( $d2->carport_spaces);
             }

              $res2['created_at'] =$d2->created_at;
              $res2['updated_at'] =$d2->updated_at;
              $check2 = Property_detail::where('item_id',$d2->id)->first();
              if(isset($check2->item_id)){
               $insert2 = Property_detail::where('item_id',$d2->id)->update($res2);
              }else{
               $insert2= Property_detail::insert($res2);
              }

             $check = Property::where('item_id',$arr->id)->first();
             $insert='';
              if(isset($check->item_id)){
              $insert = Property::where('item_id',$arr->id)->update($res);
              }else{
                $insert = Property::insert($res);
              }
            }
            // return $itemid;
            if($insert){
              return [
                "status" => 1,
                "msg" => "Succesfully",
                "data" =>$itemp
              ];
           }else{
              return [
                "status" => 0,
                "msg" => "Property not inserted.",
                "data" =>$itemp
              ];
           }

      }
        // create property
      public function create_agents(Request $request)
      {

          $endpoint ="http://api2.agentaccount.com:80/agents";
          $client = new \GuzzleHttp\Client();
          $token = '4de1a0d5afbf7b9789198037c34293a83e04eb51';
          $response = $client->request('GET', $endpoint, ['query' => [
              'token' => $token,
              'per_page'=>150
          ]]);


           $statusCode = $response->getStatusCode();
            $data = (string) $response->getBody();

            $d =json_decode($data);
          //  print_r($d); die;
          $itemid= [];
            foreach($d->results as $arr){
            // $res  = array();
             $res2 = array();
             $res3 = array();

              //$res['agent_id'] =$arr->id;




           /*   if(!empty($arr->office_id)){
                $res['office_id'] = $arr->office_id;
              }
              if(!empty($arr->type)){
                $res['type'] = $arr->type;
              }
              if(!empty($arr->first_name)){
                $res['first_name'] = $arr->first_name;
                $res3['name'] = $arr->first_name;
              }
              if(!empty($arr->last_name)){
                $res['last_name'] = $arr->last_name;
                $res3['surname'] = $arr->last_name;
              }
              if(!empty($arr->email)){
                $res['email'] = $arr->email;
                $res3['email'] = $arr->email;
              }
              if(!empty($arr->phone_number)){
                $res['phone_number'] = $arr->phone_number;
              }
              if(!empty($arr->mobile_number)){
                $res['mobile_number'] = $arr->mobile_number;
                $res3['mobile'] = $arr->mobile_number;
              }*/
             /* if(!empty($arr->fax_number)){
                $res['fax_number'] = $arr->fax_number;
              }
              if(!empty($arr->username)){
                $res['username'] = $arr->username;
              }
              if(!empty($arr->description)){
                $res['description'] = $arr->description;
              }
              if(!empty($arr->position)){
                $res['position'] = $arr->position;
              }
              if(!empty($arr->suburb)){
                $res['suburb'] = $arr->suburb;
              }
              if(!empty($arr->role)){
                $res['role'] = $arr->role;
              }
              if(!empty($arr->url)){
                $res['url'] = $arr->url;
              }
              if(!empty($arr->video_url)){
                $res['video_url'] = $arr->video_url;
              }
              if(!empty($arr->facebook_username)){
                $res['facebook_username'] = $arr->facebook_username;
              }

              if(!empty($arr->twitter_username)){
                $res['twitter_username'] = $arr->twitter_username;
              }
              if(!empty($arr->linkedin_username)){
                $res['linkedin_username'] = $arr->linkedin_username;
              }
              if(!empty($arr->instagram_username)){
                $res['instagram_username'] = $arr->instagram_username;
              }
              if(!empty($arr->display_on_team_page)){
                $res['display_on_team_page'] = $arr->display_on_team_page;
              }
              if(!empty($arr->disabled)){
                $res['disabled'] = $arr->disabled;
              }


              $res['created_at'] =$arr->created_at;
              $res['updated_at'] =$arr->updated_at;
              */
              $endpoint2 ="http://api2.agentaccount.com:80/agents/".$arr->id;
              $client2 = new \GuzzleHttp\Client();
              $token2 = '4de1a0d5afbf7b9789198037c34293a83e04eb51';
               $response2 = $client2->request('GET', $endpoint2, ['query' => [
                  'token' => $token2
               ]]);
              // $statusCode = $response->getStatusCode();
               $data2 = (string) $response2->getBody();

                $d2 =json_decode($data2);
                $res2['agent_id'] = $d2->id;
                $res3['agent_id'] = $d2->id;

                $res3['password'] = '$2y$10$R01ZNlnCM5iWzUAFe9XXzO5/YhmkMfbtSDm3Bt30OfOodpFPju5Yi';
                $res3['role'] = 'agent';

                if(!empty($d2->office_id)){
                $res2['office_id'] = $d2->office_id;
              }
              if(!empty($d2->type)){
                $res2['type'] = $d2->type;
              }
              if(!empty($d2->first_name)){
                $res2['first_name'] = $d2->first_name;
                $res3['name'] = $d2->first_name;
              }
              if(!empty($d2->last_name)){
                $res2['last_name'] = $d2->last_name;
                $res3['surname'] = $d2->last_name;
              }
              if(!empty($d2->email)){
                $res2['email'] = $d2->email;
                $res3['email'] = $d2->email;
              }
              if(!empty($d2->phone_number)){
                $res2['phone_number'] = $d2->phone_number;
                $res3['phone'] = $d2->phone_number;
              }
              if(!empty($d2->mobile_number)){
                $res2['mobile_number'] = $d2->mobile_number;
                $res3['mobile'] = $d2->mobile_number;
              }
              if(!empty($d2->fax_number)){
                $res2['fax_number'] = $d2->fax_number;
              }
              if(!empty($d2->username)){
                $res2['username'] = $d2->username;
              }
              if(!empty($d2->level)){
                $res2['level'] = $d2->level;
              }
              if(!empty($d2->description)){
                $res2['description'] = $d2->description;
              }
              if(!empty($d2->position)){
                $res2['position'] = $d2->position;
              }
              if(!empty($d2->suburb)){
                $res2['suburb'] = $d2->suburb;
              }
              if(!empty($d2->role)){
                $res2['role'] = $d2->role;
                $res3['agent_role'] = $d2->role;
              }
              if(!empty($d2->video_url)){
                $res2['video_url'] = $d2->video_url;
              }
              if(!empty($d2->facebook_username)){
                $res2['facebook_username'] = $d2->facebook_username;
              }
              if(!empty($d2->twitter_username)){
                $res2['twitter_username'] = $d2->twitter_username;
              }
              if(!empty($d2->linkedin_username)){
                $res2['linkedin_username'] = $d2->linkedin_username;
              }
              if(!empty($d2->instagram_username)){
                $res2['instagram_username'] = $d2->instagram_username;
              }

              if(!empty($d2->groups)){
                $res2['groups'] = json_encode($d2->groups);
              }
              if(!empty($d2->testimonials)){
                $res2['testimonials'] = json_encode($d2->testimonials);
              }
              if(!empty($d2->display_on_team_page)){
                $res2['display_on_team_page'] = $d2->display_on_team_page;
              }
              if(!empty($d2->photos_landscape)){
                $res2['photos_landscape'] = json_encode($d2->photos_landscape);
                //$res3['profile_image'] = json_encode($d2->photos_landscape);
              }
              if(!empty($d2->photos_portrait)){
                $res2['photos_portrait'] = json_encode($d2->photos_portrait);
              }
              if(!empty($d2->disabled)){
                $res2['disabled'] = $d2->disabled;
              }

              $res2['created_at'] =$d2->created_at;
              $res2['updated_at'] =$d2->updated_at;

              $check2 = Agent_detail::where('agent_id',$arr->id)->first();
              if(isset($check2->item_id)){
              }else{
                $insert2= Agent_detail::insert($res2);
              }
               $check = User::where('agent_id',$arr->id)->orWhere('email',$d2->email)->first();
              $insert='';
              if(isset($check->agent_id)){
              }else{
                $insert3 = User::insert($res3);
              }
            }
            // return $itemid;
            if($insert3){
              return [
                "status" => 1,
                "msg" => "Succesfully",
                "data" =>""
              ];
            }else{
              return [
                "status" => 0,
                "msg" => "update successfully",
                "data" =>""
              ];
            }

      }


      public function property_details(Request $request)
      {
         $whishlist = DB::table('wishlists')->where('uid',$request->input('uid'))->where('property_id',$request->input('property_id'))->where('status','active')->first();
        // return $whishlist->property_id;
       /* $data = Property_detail::select('property_details.item_id','property_details.type','property_details.property_type','property_details.property_type2','property_details.property_type3','property_details.photos','property_details.headline','property_details.description','property_details.authority','property_details.current_rent','property_details.deal_type','property_details.rent_type','property_details.address','property_details.price_text','property_details.features','property_details.floorplans','property_details.brochures','property_details.projects','property_details.custom','property_details.exports','property_details.opentimes','property_details.exports_old','property_details.translations','property_details.status','property_details.method_of_sale','property_details.listings_this_address','agent_details.agent_id','agent_details.type as agent_type','agent_details.agent_id','agent_details.first_name','agent_details.last_name','agent_details.email','agent_details.phone_number','agent_details.mobile_number','agent_details.username','agent_details.description','agent_details.role','agent_details.url','agent_details.video_url','agent_details.facebook_username','agent_details.groups','agent_details.photos_landscape','agent_details.photos_portrait','agent_details.testimonials','agent_details.twitter_username','property_details.created_at','property_details.updated_at')->where('item_id', $request->input('property_id'))->leftJoin('agent_details', 'property_details.agent_id_1', '=', 'agent_details.agent_id')->first();*/
         $data = Property_detail::select('item_id','type','agent_id_1','agent_id_2','property_type','property_type2','property_type3','garage_spaces','bedrooms','number_of_floors','bathrooms','photos','headline','description','authority','current_rent','deal_type','rent_type','address','price_text','features','floorplans','brochures','projects','custom','exports','opentimes','exports_old','translations','status','method_of_sale','listings_this_address','land_area','land_area_metric','floor_area','floor_area_metric','warehouse_area','warehouse_area_metric','retail_area','retail_area_metric','carport_spaces','created_at','updated_at','total_view')->where('item_id', $request->input('property_id'))->first();
        if(!empty($whishlist->property_id)){
          $data->wishlist = 1;
        }else{
          $data->wishlist = 0;
        }
        if(isset($data)) {
          $totalview = $data->total_view+1;
          $update['total_view']=$totalview;
          $up=Property_detail::where('item_id',$request->input('property_id'))->update($update);
           $agentData = DB::table('agent_details')->select('agent_id','first_name','last_name','email','phone_number','mobile_number','description','role','photos_landscape')->where('agent_id',$data->agent_id_1)->orWhere('agent_id',$data->agent_id_2)->distinct()->get();
             if(!empty($agentData)){
		          $data->agentdata = $agentData;
		        }else{
		          $data->agentdata = "";
		        }


          return [
              "status" => 1,
              "msg" => "Succesfully",
              "data" =>$data
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "Property not found.",
              "data" =>""
            ];
          }
      }

       // property type list
       public function property_type_list(Request $request)
       {
            //  return $request->all();
         if($request->input('type') =='Retail'){
          $data = Property::select('item_id','headline','address','latitude','longitude','deal_type','photos','authority','price_text','display_price','current_rent')->where('property_type','Retail')->where('status','1')->get();
         }else if($request->input('type') =='Industrial'){
          $data = Property::select('item_id','headline','address','latitude','longitude','deal_type','photos','authority','price_text','display_price','current_rent')->where('property_type','Industrial')->where('status','1')->get();
         }else{
          $data = Property::select('item_id','headline','address','latitude','longitude','deal_type','photos','authority','price_text','display_price','current_rent')->where('type', $request->input('type'))->where('property_type','!=','Retail')->where('status','1')->where('property_type','!=','Industrial')->get();
         }

         if(isset($data)) {
           return [
               "status" => 1,
               "msg" => "Succesfully",
               "data" =>$data
             ];
           }else{
             return [
               "status" => 0,
               "msg" => "Property not found.",
               "data" =>""
             ];

           }
       }
         // application_list  list
         public function application_list(Request $request)
         {

            $data = Application::select('property_details.item_id','property_details.type','property_details.property_type','property_details.property_type2','property_details.deal_type','property_details.photos','property_details.headline','property_details.description','property_details.authority','property_details.current_rent','property_details.price_text','property_details.features','property_details.address','property_details.rent_type','applications.status','applications.id','applications.agent_id','applications.approve_status','applications.created_at','applications.updated_at')->where('uid',$request->input('uid'))->where(function($q) {
         return $q->where('applications.status','active')
           ->orWhere('applications.status','cancel');
      })->leftJoin('property_details', 'property_details.item_id', '=', 'applications.property_id')->orderBy('applications.id','desc')->get();

           if(isset($data)){
             return [
                 "status" => 1,
                 "msg" => "Succesfully",
                 "data" =>$data
               ];
             }else{
               return [
                 "status" => 0,
                 "msg" => "Applications not found.",
                 "data" =>""
               ];

             }
         }

         public function application_create(Request $request)
         {
          $data['uid'] =  $request->input('uid');
          $data['property_id'] =  $request->input('property_id');
          $data['communication_method'] =  $request->input('method');

          $data['created_at'] = date('Y-m-d H:i:s');
          $data['updated_at'] = date('Y-m-d H:i:s');
          $check =Application::where('uid',$request->input('uid'))->where('property_id','=',$request->input('property_id'))->where('status','!=','deleted')->first();
          if(isset($check->uid) && !empty($check->property_id)){
            return [
              "status" => 0,
              "msg" => "You have already applied for this property. Please review lodgements to track the details",
              "data" =>""
            ];

         } else{
          $agentDetail =Property::select('agent_id_1')->where('item_id',$request->input('property_id'))->first();
          if(!empty($agentDetail))
           {
             $data['agent_id'] = $agentDetail->agent_id_1;
             $result = DB::table('applications')->insert($data);

            if(isset($result))
             {
                $result1 = DB::table('applications')->orderby('id','desc')->first();
                $data1['sender_id'] =  $agentDetail->agent_id_1;
                $data1['receiver_id'] =  $request->input('uid');
                $data1['application_id'] = $result1->id;
                $data1['message'] = "Your application has been successfully lodged. We will contact you via your preferred method of communication within 24 hours.";
                $data1['created_at'] = date('Y-m-d H:i:s');
                $data1['updated_at'] = date('Y-m-d H:i:s');
                DB::table('application_messages')->insert($data1);
                return [
                  "status" => 1,
                  "msg" =>"Your application has been successfully lodged. We will contact you via your preferred method of communication within 24 hours.",
                  "data" =>""
                   ];
               }

           }
          else{
            return [
              "status" => 0,
              "msg" => "Agent not available.",
              "data" =>""
            ];
          }

         }
        }
        public function applications_status(Request $request)
        {

          $data['status'] =  $request->input('status');
          if($request->input('status') =='deleted'){
           $msg = "Deleted successfully.";
          }
          if($request->input('status') =='archive'){
           $msg = "Archived successfully.";
          }
          if($request->input('status') =='cancel'){
            $data['approve_status'] = 'cancelled';
           $msg = "Cancelled successfully.";
          }
          if($request->input('status') =='mute'){
           $msg = "Mute successfully.";
          }
          $data['updated_at'] = date('Y-m-d H:i:s');
          $result = DB::table('applications')->where('uid', $request->input('uid'))->where('id', $request->input('application_id'))->update($data);
          if(isset($result)){
            return [
              "status" => 1,
              "msg" =>$msg,
              "data" =>""
            ];
          }

        }


public function application_message(Request $request)
    {

      //$data['property_id'] =  $request->input('property_id');
      $data['sender_id'] =  $request->input('uid');
      $data['receiver_id'] =  $request->input('receiver_id');
      $data['application_id'] =  $request->input('application_id');
      $data['message'] =  $request->input('message');

      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');

      $result = DB::table('application_messages')->insert($data);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" =>"Send mesage successfully .",
          "data" =>""
        ];
      }

    }


 public function application_message_list(Request $request)
        {
          $result = DB::table('application_messages')->where('application_id', $request->input('application_id'))->where('status','active')->get();
          if(isset($result)){
             $agentdata = array();
            if(!empty($result)){
                 if($result[0]->sender_id==$request->input('uid'))
                   {
                    $agent_id = $result[0]->receiver_id;
                   }
                else{
                     $agent_id = $result[0]->sender_id;
                  }
               $agentdata = DB::table('agent_details')->select('first_name','last_name','photos_landscape')->where('agent_id', $agent_id)->first();
            }
            return [
              "status" => 1,
              "msg" =>"application mesage list .",
              "data" => $result,
              "agentdata"=>$agentdata
            ];
          }
     }


        // inspection  list
        public function inspection_list(Request $request)
        {
          $data = Inspection::select('property_details.item_id','property_details.type','property_details.property_type','property_details.property_type2','property_details.deal_type','property_details.photos','property_details.headline','property_details.description','property_details.authority','property_details.current_rent','property_details.price_text','property_details.features','property_details.address','property_details.rent_type','inspections.id','inspections.agent_id','inspections.inspect_dates','inspections.communication_method','inspections.booked_status','inspections.status','inspections.created_at','inspections.updated_at')->where('uid',$request->input('uid'))->where(function($q) {
             return $q->where('inspections.status','active')
               ->orWhere('inspections.status','cancel');
          })->leftJoin('property_details', 'property_details.item_id', '=', 'inspections.property_id')->orderBy('inspections.id','desc')->get();

          if(isset($data)) {
            return [
                "status" => 1,
                "msg" => "Succesfully",
                "data" =>$data
              ];
            }else{
              return [
                "status" => 0,
                "msg" => "Inspection not found.",
                "data" =>""
              ];

            }
        }

    // inspect date
    public function inspection_create(Request $request)
    {
      $data['uid'] =  $request->input('uid');
      $data['property_id'] =  $request->input('property_id');
      $data['inspect_dates'] =  $request->input('dates');
      $data['communication_method'] =  $request->input('method');
      $data['booked_status'] =  $request->input('booked_status');
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');
      $check =Inspection::where('uid',$request->input('uid'))->where('property_id','=',$request->input('property_id'))->where('status','!=','deleted')->first();
      if(isset($check->uid) && !empty($check->property_id)){
        return [
          "status" => 0,
          "msg" => "You have already lodged an inspection for this property. Please review lodgements sections for details.",
          "data" =>""
        ];

      } else{
        $agentDetail =Property::select('agent_id_1')->where('item_id',$request->input('property_id'))->first();
        if(!empty($agentDetail))
        {
          $data['agent_id'] = $agentDetail->agent_id_1;
          $result = DB::table('inspections')->insert($data);

          if(isset($result))
          {

              $result1 = DB::table('inspections')->orderby('id','desc')->first();
              $data1['sender_id'] = $agentDetail->agent_id_1;
              $data1['receiver_id'] =  $request->input('uid');
              $data1['inspection_id'] = $result1->id;
              $data1['message'] = "Your inspection has been successfully lodged. We will contact you via your preferred method of communication within 24 hours.";
              $data1['created_at'] = date('Y-m-d H:i:s');
              $data1['updated_at'] = date('Y-m-d H:i:s');
              DB::table('inspection_messages')->insert($data1);
              return [
                "status" => 1,
                "msg" => "Your inspection has been successfully lodged. We will contact you via your preferred method of communication within 24 hours.",
                "data" =>""
                ];
            }

        }
        else{
          return [
            "status" => 0,
            "msg" => "Agent not available.",
            "data" =>""
          ];
        }

      }

    }
    // inspect status update
    public function inspection_status(Request $request)
    {

      $data['status'] = $request->input('status');
      if($request->input('status') =='deleted'){
      $msg = "Deleted successfully.";
      }
      if($request->input('status') =='archive'){
      $msg = "Archived successfully.";
      }
      if($request->input('status') =='cancel'){
        $data['booked_status'] = 'cancelled';
      $msg = "Cancelled successfully.";
      }
      if($request->input('status') =='mute'){
      $msg = "Mute successfully.";
      }
      $data['updated_at'] = date('Y-m-d H:i:s');
      $result = DB::table('inspections')->where('uid', $request->input('uid'))->where('id',$request->input('inspection_id'))->update($data);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" =>$msg,
          "data" =>""
        ];
      }

    }
    public function inspections_message(Request $request)
    {


      //$data['property_id'] =  $request->input('property_id');
      $data['sender_id'] =  $request->input('uid');
      $data['receiver_id'] =  $request->input('receiver_id');
      $data['inspection_id'] =  $request->input('inspection_id');
      $data['message'] =  $request->input('message');

      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');

      $result = DB::table('inspection_messages')->insert($data);
      if(isset($result)){
        return [
          "status" => 1,
          "msg" =>"Message sent successfully.",
          "data" =>""
        ];
      }

    }
    public function inspection_message_list(Request $request)
    {
    $result = DB::table('inspection_messages')->where('inspection_id', $request->input('inspection_id'))->where('status','active')->get();
    if(isset($result)){
        $agentdata = array();
      if(!empty($result)){
            if($result[0]->sender_id==$request->input('uid'))
              {
              $agent_id = $result[0]->receiver_id;
              }
          else{
                $agent_id = $result[0]->sender_id;
            }
          $agentdata = DB::table('agent_details')->select('first_name','last_name','photos_landscape')->where('agent_id', $agent_id)->first();
      }
      return [
        "status" => 1,
        "msg" =>"Inspection mesage list .",
        "data" => $result,
        "agentdata"=>$agentdata
      ];
    }

    }

    // inspect date
    public function nearby_distance(Request $request)
    {

      // $sql = "SELECT u.name,u.profile_image,u.address,u.latitude, u.longitude,('6371' * acos( cos( radians($lat) ) * cos( radians(u.latitude)) * cos( radians(u.longitude) - radians($lng)) + sin(radians($lat)) * sin( radians(u.latitude)))) AS distance FROM categories as c JOIN retailer_category AS
						// rc ON c.id = rc.category_id JOIN users u ON u.id = rc.user_id WHERE c.id IN ($category_id) GROUP BY rc.user_id ORDER BY distance ";

      if($request->input('type')=='Retail' || $request->input('type')=='Commercial')
        {
          $field ='property_type';
        }
      else
        {
          $field ='type';
        }

    if(!empty($request->input('listtype')) && $request->input('listtype')=='nearby'){

      if(!empty($request->input('latitude'))){
          $lat =  $request->input('latitude');
          $lon =  $request->input('longitude');
      }
      else{
         $user=   DB::table("users")->where('id',$request->input('uid'))->first();
            if(!empty($user->latitude)) {
              $lat =  $user->latitude;
              $lon =  $user->longitude;

          }else{
            return [
              "status" => 0,
              "msg" => "Address not found.",
              "data" =>""
            ];

          }
        }
      $result=   DB::table("property_details")
              ->select("item_id","type","property_type","photos","headline","description","address","latitude","longitude","price_text"
                  ,DB::raw("6371 * acos(cos(radians(" . $lat . "))
                  * cos(radians(latitude))
                  * cos(radians(longitude) - radians(" . $lon . "))
                  + sin(radians(".$lat."))
                  * sin(radians(latitude))) AS distance"))
                  ->where($field, $request->input('type'))
                  ->where('status','1')
                  ->orderBy('distance', 'ASC')
                  ->get();
        if(isset($result)){
          return [
            "status" => 1,
            "msg" => "Nearby property list.",
            "data" => $result
          ];
        }

       }

    elseif(!empty($request->input('listtype')) && $request->input('listtype')=='popular'){


      $result=   DB::table("property_details")
              ->select("item_id","type","property_type","photos","headline","description","address","latitude","longitude","price_text")
                  ->where($field, $request->input('type'))
                  ->where('status','1')
                  ->orderBy('total_view', 'DESC')
                  ->get();
        if(isset($result)){
          return [
            "status" => 1,
            "msg" => "popular property list.",
            "data" => $result
          ];
        }

       }
    else{


      $result=   DB::table("property_details")
              ->select("item_id","type","property_type","photos","headline","description","address","latitude","longitude","price_text")
                  ->where($field,$request->input('type'))
                  ->where('status','1')
                  ->orderBy('total_view', 'DESC')
                  ->get();
        if(isset($result)){
          return [
            "status" => 1,
            "msg" => "Property list.",
            "data" => $result
          ];
        }

       }
    }
    public function search_list(Request $request)
    {
       $data = Property_detail::get();
      if(isset($data)) {
        return [
            "status" => 1,
            "msg" => "search list .",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }


    }

    public function property_dropdown(Request $request)
    {
        //  return $request->all();
      if(!empty($request->input('search'))){
        $search = $request->input('search');
        $data = Property::select('item_id','headline','photos','address')->where('headline', 'LIKE', "%$search%")->get();

      }else{
      $data = Property::select('item_id','headline','photos','address')->get();
      }
      if(isset($data)) {
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }

  public function application_information(Request $request)
    {
       $data = Application::select('applications.id','applications.agent_id','applications.property_id','applications.approve_status','applications.created_at','properties.headline','properties.description','properties.photos','properties.address','agent_details.first_name','agent_details.last_name','agent_details.role','agent_details.photos_landscape')->where('applications.id', $request->input('application_id'))->leftJoin('properties', 'properties.item_id', '=', 'applications.property_id')->leftJoin('agent_details', 'agent_details.agent_id', '=', 'applications.agent_id')->first();

      if(isset($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }
  public function inspection_information(Request $request)
    {
       $data = Inspection::select('inspections.id','inspections.agent_id','inspections.property_id','inspections.booked_status','inspections.booked_date','inspections.created_at','properties.headline','properties.description','properties.photos','properties.address','agent_details.first_name','agent_details.last_name','agent_details.email','agent_details.mobile_number','agent_details.role','agent_details.photos_landscape')->where('inspections.id', $request->input('inspection_id'))->leftJoin('properties', 'properties.item_id', '=', 'inspections.property_id')->leftJoin('agent_details', 'agent_details.agent_id', '=', 'inspections.agent_id')->first();

      if(isset($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }

   public function enquery_information(Request $request)
    {
        $data = DB::table('enquiries')->select('enquiries.id','enquiries.agent_id','enquiries.property_id','enquiries.status','enquiries.created_at','enquiries.subjects','enquiries.message','properties.headline','properties.description','properties.photos','properties.address','agent_details.first_name','agent_details.last_name','agent_details.role','agent_details.photos_landscape')->where('enquiries.id', $request->input('enquery_id'))->leftJoin('properties', 'properties.item_id', '=', 'enquiries.property_id')->leftJoin('agent_details', 'agent_details.agent_id', '=', 'enquiries.agent_id')->first();

      if(isset($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }


    public function search(Request $request)
    {


      $q = Property_detail::query();
      $q->select('id','item_id','agent_id_1','agent_id_2','agent_id_2','type','property_type','price','price_text','headline','address','photos','authority','land_area','land_area_to');
      if(!empty($request->input('type')))
       {
          // simple where here or another scope, whatever you like
         if($request->input('type')=='Industrial' || $request->input('type')=='Retail')
          {
            $q->where('property_type',$request->input('type'));
          }
         else
          {
            $q->where('type',$request->input('type'));
            $q->where('property_type','!=','Industrial');
            $q->where('property_type','!=','Retail');
          }
       }

       if(!empty($request->input('property_type')))
       {
          $q->where('property_type',$request->input('property_type'));
       }

       if(!empty($request->input('start_price')))
       {
          $q->where('price','>=', $request->input('start_price'));
       }

       if(!empty($request->input('end_price')))
       {
          $q->where('price','<=', $request->input('end_price'));
       }
      if(!empty($request->input('floor_area_start')))
       {
          $q->where('floor_area','>=', $request->input('floor_area_start'));
       }
       if(!empty($request->input('floor_area_end')))
       {
          $q->where('floor_area','<=', $request->input('floor_area_end'));
       }


     if(!empty($request->input('badroom_start')))
       {
          $q->where('bedrooms','>=', $request->input('badroom_start'));
       }
       if(!empty($request->input('badroom_end')))
       {
          $q->where('bedrooms','<=', $request->input('badroom_end'));
       }

     if(!empty($request->input('bathroom_start')))
       {
          $q->where('bathrooms','>=', $request->input('bathroom_start'));
       }
       if(!empty($request->input('bathroom_end')))
       {
          $q->where('bathrooms','<=', $request->input('bathroom_end'));
       }
      if(!empty($request->input('parking_space_start')))
       {
          $q->where('parking_spaces','>=', $request->input('parking_space_start'));
       }
       if(!empty($request->input('parking_space_end')))
       {
          $q->where('parking_spaces','<=', $request->input('parking_space_end'));
       }
      if(!empty($request->input('land_area_start')))
       {
          $q->where('land_area','>=', $request->input('land_area_start'));
       }
       if(!empty($request->input('land_area_end')))
       {
          $q->where('land_area','<=', $request->input('land_area_end'));
       }
      if(!empty($request->input('features')))
       {  $features = explode(',',$request->input('features'));
          foreach ($features as $value) {
          $q->where('features','like', '%' .trim($value). '%');
          }

       }
        $q->where('status',1);

       if(!empty($request->input('order_by')))
       {
        if($request->input('order_by')=='updated')
           {
             $q->orderBy('updated_at','desc');
           }
        elseif($request->input('order_by')=='highest'){
           $q->orderBy('price','desc');

          }
        elseif($request->input('order_by')=='lowest'){
           $q->orderBy('price','asc');

          }
        else{
          $q->orderBy('created_at','desc');
          }
        }

      $data = $q->get()->toArray();
       // $data = $q->toSql();
       //$data = $request->input();
      if(!empty($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>array()
            ];

        }
    }

  public function propery_type_get(Request $request)
    {
       $data = DB::table('property_details')->select('property_type')->distinct('property_type')->get();
      // echo '<pre>'; print_r($data); die;

      if(isset($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }

   public function get_search_parameter(Request $request)
    {
       $data = DB::table('property_details')->select(\DB::raw("MIN(price) AS min_price"),\DB::raw("MAX(price) AS max_price"),\DB::raw("MIN(floor_area) AS min_floor_area"),\DB::raw("MAX(floor_area) AS max_floor_area"))->first();
       //echo '<pre>'; print_r($data); die;

      if(isset($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }

 public function my_properties_for_dropdown(Request $request)
    {
       $data = DB::table('applications')->select('applications.uid','applications.property_id','properties.headline','properties.photos')->where('applications.uid',$request->input('uid'))->where('applications.approve_status','approved')->leftJoin('properties', 'properties.item_id', '=', 'applications.property_id')->get();
      // echo '<pre>'; print_r($data); die;

      if(isset($data)){
        return [
            "status" => 1,
            "msg" => "Succesfully",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "Property not found.",
            "data" =>""
          ];

        }
    }

   public function my_properties(Request $request)
    {
       $data = DB::table('applications')->select('applications.id','applications.uid','applications.property_id','applications.agent_id','applications.approve_status','property_details.headline','property_details.property_type','property_details.price_text','property_details.address','property_details.deal_type','property_details.photos','property_details.land_area','property_details.land_area_metric','property_details.floor_area','property_details.floor_area_metric','property_details.warehouse_area','property_details.warehouse_area_metric','property_details.retail_area','property_details.retail_area_metric','property_details.carport_spaces','property_details.bedrooms','property_details.bathrooms','property_details.garage_spaces')->where('applications.uid',$request->input('uid'))->where('applications.approve_status','approved')->leftJoin('property_details', 'property_details.item_id', '=', 'applications.property_id')->get();
      // echo '<pre>'; print_r($data); die;

      if(!empty($data)){
        return [
            "status" => 1,
            "msg" => "You don’t have any active property.",
            "data" =>$data
          ];
        }else{
          return [
            "status" => 0,
            "msg" => "You don’t have any active property.",
            "data" =>""
          ];

        }
    }

 //  job list
  public function property_maintenance(Request $request)
      {

        $job= DB::table('jobs')->select('jobs.id','jobs.agent_id','jobs.assign_id','jobs.property_id','jobs.mantinance_type','jobs.title','jobs.description','jobs.hours','jobs.status','property_details.address')->where('property_id',$request->input('property_id'))->where('jobs.status','!=','deleted')->leftJoin('property_details', 'property_details.item_id', '=', 'jobs.property_id')->get();
        if(!empty($job)){
           return [
              "status" => 1,
              "msg" => "All your maintenance requests will appear here, in your jobs list. Maintenance requests are job cards you can raise for any maintenance-related issue on your property. This ensures PPP is adequately notified to immediately resolve the issue. To raise a job card, simply tap on the plus icon located on the bottom-righ of this screen, select your property, fill in the required fields, and hit submit.",
              "data" => $job
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "All your maintenance requests will appear here, in your jobs list. Maintenance requests are job cards you can raise for any maintenance-related issue on your property. This ensures PPP is adequately notified to immediately resolve the issue. To raise a job card, simply tap on the plus icon located on the bottom-righ of this screen, select your property, fill in the required fields, and hit submit.",
              "data" =>array()
            ];

          }
      }

//  job list
  public function rental_info(Request $request)
      {

       $data = Application::select('applications.id','applications.agent_id','applications.property_id','applications.approve_status','applications.rent','applications.security_diposit','applications.date_applied','applications.date_leased','applications.lease_due','applications.created_at','properties.deal_type','properties.address','properties.headline','properties.type','properties.property_type','agent_details.first_name','agent_details.last_name','agent_details.role','agent_details.photos_landscape','agent_details.phone_number','agent_details.email','agent_details.mobile_number')->where('applications.id', $request->input('application_id'))->leftJoin('properties', 'properties.item_id', '=', 'applications.property_id')->leftJoin('agent_details', 'agent_details.agent_id', '=', 'applications.agent_id')->first();
        if(isset($data)){
           return [
              "status" => 1,
              "msg" => "Job list",
              "data" => $data
            ];
          }else{
            return [
              "status" => 0,
              "msg" => "application not found.",
              "data" =>array()
            ];

          }
      }

}
