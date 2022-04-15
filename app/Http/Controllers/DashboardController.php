<?php

namespace App\Http\Controllers;

use App\Models\ChamCong;
use App\Models\ChucVu;
use App\Models\HopDong;
use App\Models\NhanVien;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function static(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
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

    public function list(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
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

    public function chartLate(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        $arrMonth = [];
        $arrLate = [];
        for($i = 0; $i < 7; $i ++){
            $month = date("M",strtotime("-$i month"));
            $yearMonth = date("Y-m",strtotime("-$i month"));
            $dimuon = ChamCong::where('ngay', 'LIKE', '%'.$yearMonth.'%')
                                ->where('gio_vao', '>','08:30:00')
                                ->where('tinh_trang', 1)
                                ->count();
            array_push($arrLate, $dimuon);
            array_push($arrMonth, $month);                    
        }
        $result['arrLate'] = array_reverse($arrLate);
        $result['arrMonth'] = array_reverse($arrMonth);
        return $result;
    }

    public function chartRole(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        $arrCount = [];
        $getIdRole = ChucVu::select('id')
                            ->orderBy('id', 'DESC')
                            ->where('trang_thai',1)
                            ->get();
        foreach($getIdRole as $idRole){
            $id = $idRole['id'];
            $countRole = HopDong::where('id_chuc_vu', $id)
                                ->orderBy('id_chuc_vu', 'DESC')
                                ->where('trang_thai_hd', 1)
                                ->count();
            array_push($arrCount, $countRole);
            $result['arrCount'] = array_reverse($arrCount);                    
        }                 
        $arrRole = ChucVu::select('ten_chuc_vu')
                        ->where('trang_thai', 1)
                        ->pluck('ten_chuc_vu');
        $result['arrRole'] = $arrRole;   
        // print_r($result); 
        return $result;            
    }
}
