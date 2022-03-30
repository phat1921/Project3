<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    protected $table = 'hop_dong_lao_dong';
    public $timestamps = false;
    public $primaryKey = 'id_hd';
}
