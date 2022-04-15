<?php

namespace App\Http\Controllers;

use App\Models\HopDong;
use App\Models\NhanVien;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function static(){
        $staff = NhanVien::where('id', '!=', 1)
                        ->where('trang_thai', 1)
                        ->count();
        $test = HopDong::where('trang_thai_hd', 1)
                        ->where('loai_hop_dong', 'LIKE', 'Thử việc')
                        ->count();
        $offical = HopDong::where('trang_thai_hd', 1)
                        ->where('loai_hop_dong', 'LIKE', 'Chính thức')
                        ->count();   
        $quit = NhanVien:: where('trang_thai', 0)
                        ->count();                             
        return view('dashboard',[
            'staff' => $staff,
            'test' => $test,
           'offical' => $offical,
           'quit' => $quit
        ]);                   
    }

    public function list(){
        $data = [];
        $today = new DateTime();
        $date = new DateTime();
        $date->modify("+5 days")->format('Y-m-d');
            $hopDong = HopDong::where('hop_dong_lao_dong.trang_thai_hd', 1)
            ->join("nhan_vien", "hop_dong_lao_dong.id_nv", "=", "nhan_vien.id")
            ->where('ngay_ket_thuc', '<=', $date)
            ->where('ngay_ket_thuc', '>=', $today)
            ->where("nhan_vien.trang_thai",1)
            ->get();
        $data['data'] = $hopDong;
        echo json_encode($data);
    }
}
