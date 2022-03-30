<?php

namespace App\Http\Controllers;

use App\Models\ChamCong;
use App\Models\DiaDiemIp;
use App\Models\NhanVien;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function checkIn(Request $request){
        $date = date("Y-m-d");
        $idUser = $request->session()->get('id');
        $timein = date("H:i:s");
        $getIp = request()->ip();
       
        $getUserIp = DiaDiemIp::where('ip',$getIp)
                                ->join('nhan_vien','nhan_vien.id_dd_truy_cap', '=', 'truy_cap.id')
                                ->where('truy_cap.trang_thai', 1)
                                ->count();
        if($getUserIp == 1){
            if($timein < '09:00:00'){
                $chamcong = new ChamCong();
                $chamcong->id_nhan_vien = $idUser;
                $chamcong->ngay = $date;
                $chamcong->gio_vao = $timein;
                $chamcong->tinh_trang = 1;
                
                if(ChamCong::where('id_nhan_vien', $idUser)->where('ngay', $date)->exists()){
                    $json['msg'] = "Đã chấm công";
                    $json['code'] = 401; 
                }else{
                    if($chamcong->save()){
                        $json['msg'] = "Chấm công thành công";
                        $json['code'] = 200;
                    }else{
                        $json['msg'] = "Chấm công thất bại";
                        $json['code'] = 401; 
                    }
                }
            }else{
                $json['msg'] = "Quá giờ chấm công";
                $json['code'] = 401; 
            }
        }else{
            $json['msg'] = "Sai địa chỉ ip";
            $json['code'] = 401; 
        }
       
       echo json_encode($json);

    }

    public function checkOut(Request $request){
        $date = date("Y-m-d");
        $idUser = $request->session()->get('id');
        $timeout = date("H:i:s");

        $congvao = ChamCong::where('id_nhan_vien', $idUser)
                            ->where('ngay', $date)
                            ->count();
        if($congvao == 1){
            $chamcong = ChamCong::where('id_nhan_vien', $idUser)
            ->where('ngay', $date)
            ->first();
            $chamcong->gio_ra = $timeout;

            if($chamcong->save()){
                $json['msg'] = "CheckOut thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "CheckOut thất bại";
                $json['code'] = 401; 
            }
        }else{
            $json['msg'] = "Chưa checkin";
            $json['code'] = 401; 
        }                    
        
       echo json_encode($json);
    }

    public function list(Request $request ){
        $data = [];
        $getmonth = $request->get('month');
        $getyear = $request->get('year');
        if(isset($getmonth) && $getmonth != ''){
            $month = $getmonth;
        }else{
            $month = date('m');
        }

        if(isset($getyear) && $getyear != ''){
            $year = $getyear;
        }else{
            $year = date('Y');
        }
        
        // $month = (isset($_REQUEST['month']) && ($_REQUEST['month'] != '')) ? $_REQUEST['month'] : date("m");
        // $year = (isset($_REQUEST['year']) && ($_REQUEST['year'] != '')) ? $_REQUEST['year'] : date("Y");
        // $year = date('Y');
        // $month = date('m');
        $idUser = $request->session()->get('id');
        $date = $year . '-' . $month;
        $chamcong = ChamCong::where('ngay', 'like', '%'.$date.'%')
                             ->where('id_nhan_vien', $idUser)
                             ->where('tinh_trang', 1)
                             ->get();
        $data['data'] = $chamcong;
        echo json_encode($data);
    }
}
