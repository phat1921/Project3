<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    protected $table = 'cham_cong';
    public $timestamps = false;
    public $primaryKey = 'id';
}
