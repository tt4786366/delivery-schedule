<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name', 'chain_id', 'store_number', 'user_id', 'valid_from', 'valid_until',
    ];      
    
    
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
    public function store_chain()
    {
        return $this->belongsTo(StoreChain::class, 'chain_id');
    }  


}
