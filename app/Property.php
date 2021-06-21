<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function assignedTo()
    {
        return $this->hasOne('App\Agent_detail', 'agent_id', 'agent_id_1');
    }
}
