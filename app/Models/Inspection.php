<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    public function hasProperty()
    {
        return $this->hasOne('App\Property', 'item_id', 'property_id');
    }

    public function assignedAgent()
    {
        return $this->hasOne('App\Agent_detail', 'agent_id', 'agent_id');
    }

    public function hasTenant()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }
}
