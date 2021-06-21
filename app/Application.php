<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
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

    public function hasEmployeement()
    {
        return $this->hasOne('App\EmploymentDetail', 'user_id', 'uid');
    }

}
