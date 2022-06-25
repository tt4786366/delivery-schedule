<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }  
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function order_drafts()
    {
        return $this->hasMany(OrderDraft::class);
    }

}