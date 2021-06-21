<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property_detail extends Model
{
    public function assignedToAgent()
    {
        return $this->hasOne('App\Agent_detail', 'agent_id', 'agent_id_1');
      /*  return $this->hasOneThrough(
            'App\Agent_detail',
            'App\Agent_detail',           
            'agent_id_1', // Local key on mechanics table...
            'agent_id_2', // Local key on cars table...
            'agent_id', // Foreign key on cars table...
            'agent_id',  // Foreign key on owners table...
        );*/
    }
}
