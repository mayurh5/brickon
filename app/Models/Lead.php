<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table='lead';

    public function user_details()
    {
        return $this->hasOne(Member::class, 'id', 'user_id');
    }

    // public function user_address()
    // {
    //     return $this->hasOne(Address::class, 'id', 'user_id');
    // }
}
