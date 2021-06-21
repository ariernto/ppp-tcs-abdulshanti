<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public function hasJobs()
    {
        return $this->hasMany('App\Models\Job', 'assign_id', 'id');
    }

    public function hasJob()
    {
        return $this->hasOne('App\Models\Job', 'assign_id', 'id');
    }

    public function lastJob()
    {
        return $this->hasJob()->orderBy('id', 'desc')->limit(1);
    }

    public function activejobs()
    {
        return $this->hasJobs()->where(function ($query) {
            $query
            ->orwhere('status', 'new')
            ->orwhere('status', 'resolved')
            ->orwhere('status', 'closed')
            ->orwhere('status', 'in progress');
        });
    }

    public function completedjobs()
    {
        return $this->hasJobs()->where('status', 'resolved');
    }

}
