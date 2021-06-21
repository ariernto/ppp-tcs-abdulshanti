<?php

namespace App\helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Filemanager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image ;

class Helper {
    public static function uploadImage($filedetail) {
        try {
            $savearray = [];
            $savearray['type'] = $filedetail->getClientOriginalExtension();
            if ($filedetail->getClientSize() < 1000000) {
                $savearray['filesize'] = number_format(($filedetail->getClientSize()/1000), 2, '.', '')."KB";
            } else {
                $savearray['filesize'] = number_format(($filedetail->getClientSize()/1000000), 2, '.', '')."MB";
            }
            $filename = self::renameFileExists(Carbon::now()->year."/".Carbon::now()->month, $filedetail->getClientOriginalName());
            $pathinfo = pathinfo($filename);
            $savearray['name'] = $pathinfo['filename'];
            $filepathdata= Carbon::now()->year."/".Carbon::now()->month;
            $savearray['filepath'] = $filedetail->storeAs(Carbon::now()->year."/".Carbon::now()->month, $filename);
            $destinationPath = public_path('/uploads'.'/'. $filepathdata);
            $filedetail->move($destinationPath, $filename);
            // print_r($savearray);die;
            $savearray['created_at'] = Carbon::now();
            $savearray['updated_at'] = Carbon::now();
            $alldata = Filemanager::insert($savearray);
            $alldataid = Filemanager::orderBy('id','DESC')->first();
            // print_r($alldataid->id); die;
            return ["status"=>"success", "message"=>"Files uploaded successfully!", "id"=>$alldataid->id];
        } catch (\Exception $e) {
            return ["status"=>"danger", "message"=>$e->getMessage()];
        }
    }

    public static function renameFileExists($filepath, $filename, $i=1) {
        $pathinfo = pathinfo($filename);
        $basename = $pathinfo['filename'];
        if(\File::exists(public_path('uploads/'.$filepath.'/'.$basename.'.'.$pathinfo['extension'])) ) {
            $i = (int)$i+1;
            $basename = preg_replace('/-\d+$/', '', $basename).'-'.$i;
            $filename = $basename.'.'.$pathinfo['extension'];
            return self::renameFileExists($filepath, $filename, (int)$i++);
        }
        return $basename.'.'.$pathinfo['extension'];
    }

    ///send push nocation
    public function pushNotification($uid,$data) {
        $fields = json_encode(array(
            'to' =>'/topics/ppp_'.$uid,
            'notification' =>$data,
            'data' =>$data
        ));
        //~ preprint($fields);
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . env('FIREBASE_API_KEY'),
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        echo $result;
    }
}
