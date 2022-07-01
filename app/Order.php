<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//class Order extends Model
class Order extends OrderDraft
{


    protected $fillable = [
    'store_id', 'product_id', 'deliver_date', 'quantity', 'approved by',
    ];    
    
/*    public function product()
    {
        return $this->belongsTo(Product::class);
    }    
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }    */

    
}
