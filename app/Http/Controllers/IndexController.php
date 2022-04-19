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
                                ->where('nhan_vien.id', $idUser)
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
                    $json['msg'] = "Chấm công đã tồn tại";
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
        $getIp = request()->ip();

        $congvao = ChamCong::where('id_nhan_vien', $idUser)
                            ->where('ngay', $date)
                            ->count();

        $getUserIp = DiaDiemIp::where('ip',$getIp)
                            ->join('nhan_vien','nhan_vien.id_dd_truy_cap', '=', 'truy_cap.id')
                            ->where('nhan_vien.id', $idUser)
                            ->where('truy_cap.trang_thai', 1)
                            ->count();
    if($timeout >= '05:00:00'){
    if($getUserIp == 1){                    
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
        }else{
            $json['msg'] = "Sai địa chỉ ip";
            $json['code'] = 401; 
        }  
     }else{
        $json['msg'] = "Không thể chấm công";
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
        $id = $request->session()->get('id');
        $idNV = $request->get('staffId');
        $idUser = isset($idNV) ? $idNV  : $id;
        // dd($idUser) ;
        $date = $year . '-' . $month;
        $chamcong = ChamCong::where('ngay', 'LIKE', '%'.$date.'%')
                             ->where('id_nhan_vien', $idUser)
                             ->where('tinh_trang', 1)
                             ->get();
                            //  dd($chamcong);
        $data['data'] = $chamcong;
        echo json_encode($data);
    }

    public function checkdate(Request $request){
        $staffId = $request->get('staffId');
        $date = $request->get('date');
        if(isset($date)){
            $date = $date;
        }else{
            $date = '';
        }
        $chamcong = ChamCong::where('ngay', $date)
                             ->where('id_nhan_vien', $staffId)
                             ->where('tinh_trang', 1)
                             ->count();
        if ($chamcong == 0) {
            $jsonObj['mess'] = "Success";
            $jsonObj['code'] = 200;
        } else {
            $jsonObj['msg'] = "Failed";
            $jsonObj['code'] = 401;
        }
        echo json_encode($jsonObj);                     
    }

    public function manualTimekeeping(Request $request){
        $id = $request->get('id');
        if($id == 0){
            $staffId = $request->get('staffId');
            $date = $request->get('date');
            $checkInTime = $request->get('checkInTime');
            $checkOutTime = $request->get('checkOutTime');
            if ($checkInTime == '00:00:00' || $checkInTime == '') {
                $jsonObj['msg'] = "Bạn chưa nhập giờ vào!";
                $jsonObj['code'] = 402;
                echo json_encode($jsonObj);
                return false;
            }
            if($checkInTime > $checkOutTime){
                $jsonObj['msg'] = "Giờ ra không thể nhỏ hơn giờ vào!";
                $jsonObj['code'] = 402;
                echo json_encode($jsonObj);
                return false;
            }
            $chamcong = new ChamCong;
            $chamcong->ngay = date("Y-m-d",strtotime(str_replace('/','-',$date)));
            $chamcong->id_nhan_vien = $staffId;
            $chamcong->gio_vao = $checkInTime;
            $chamcong->gio_ra = $checkOutTime;
            $chamcong->tinh_trang = 1;

            if( $chamcong->save()){
                $json['msg'] = "Cập nhật dữ liệu thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "Cập nhật dữ liệu thất bại";
                $json['code'] = 401; 
            }
        }else{
            $staffId = $request->get('staffId');
            $date = $request->get('date');
            $checkInTime = $request->get('checkInTime');
            $checkOutTime = $request->get('checkOutTime');
            if ($checkInTime == '00:00:00' || $checkInTime == '') {
                $json['msg'] = "Bạn chưa nhập giờ vào!";
                $json['code'] = 402;
                echo json_encode($json);
                return false;
            }
            $chamcong = ChamCong::find($id);
            $chamcong->ngay = date("Y-m-d",strtotime(str_replace('/','-',$date)));
            $chamcong->id_nhan_vien = $staffId;
            $chamcong->gio_vao = $checkInTime;
            $chamcong->gio_ra = $checkOutTime;

            if( $chamcong->save()){
                $json['msg'] = "Cập nhật dữ liệu thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "Cập nhật dữ liệu thất bại";
                $json['code'] = 401; 
            }
        }
        echo json_encode($json);
    }
}
