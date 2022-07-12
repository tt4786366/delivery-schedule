<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreChain extends Model
{
    public function stores()
    {
        return $this->hasMany(Store::class,'chain_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'chain_id');
    }    
    
}
