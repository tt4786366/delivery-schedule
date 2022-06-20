<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDraft extends Model
{
    protected $fillable = [
        'store_id', 'product_id', 'deliver_date', 'quantity',
    ];    
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }    
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }  
}
