<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function store()
    {
        return $this->belongsTo(Store::class);
    }  
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function order_drafts()
    {
        return $this->hasMany(Order::class);
    }
}
