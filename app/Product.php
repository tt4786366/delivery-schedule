<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'lot', 'category_id', 'factory_id', 'chain_id', 'valid_from', 'valid_until',
    ];      
    
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }  
    public function category()
    {
        return $this->belongsTo(Category::class);
    } 
    public function factory()
    {
        return $this->belongsTo(Factory::class);
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
