<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangLuong extends Model
{
    protected $table = 'luong';
    protected $fillable = ['id_nhan_vien','nam','thang','cong_chuan','cong_thuc_te','luong_co_ban','phu_cap','thuong','ung_truoc','phat_muon','tinh_trang'];
    public $timestamps = false;
    public $primaryKey = 'id_bl';
}
