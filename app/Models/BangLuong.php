<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangLuong extends Model
{
    protected $table = 'luong';
    public $timestamps = false;
    public $primaryKey = 'id_bl';
}
