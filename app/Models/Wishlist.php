<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public function hasProperty()
    {
        return $this->hasOne('App\Property', 'item_id', 'property_id');
    }

 

    public function hasTenant()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }
}