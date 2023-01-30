<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadProduct extends Model
{
    use HasFactory;
    protected $table='lead_product_details';

    public function product_details()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
