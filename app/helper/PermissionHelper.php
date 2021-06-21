<?php

namespace App\helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Filemanager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image ;
use App\Permission;
use DB;

class PermissionHelper {
    public static function permissionCheck($permission)
    {
        $permission = Permission::where('permission', $permission)->first();
        $checker = DB::table('permission_user')->where('user_id', auth()->user()->id)->where('permission_id', $permission->id)->get();
        if (count($checker)) { return true; } else { return false; }
    }
}
