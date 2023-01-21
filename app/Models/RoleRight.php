<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRight extends Model
{
    use HasFactory;
    protected $table='mst_role_right';
    protected $primaryKey = 'role_right_id';
}
