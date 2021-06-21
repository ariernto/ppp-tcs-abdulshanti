<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function assignedTo()
    {
        return $this->hasOne('App\Agent', 'agent_id', 'agent_id');
    }

    public function assignedWorker()
    {
        return $this->hasOne('App\Worker', 'id', 'assign_id');
    }

    public function hasProperty()
    {
        return $this->hasOne('App\Property', 'item_id', 'property_id');
    }

    public function hasTenant()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }

    public function hasRating()
    {
        return $this->hasOne('App\Models\JobRating', 'job_id', 'id');
    }
}
