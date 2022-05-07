<?php

namespace App\Http\Controllers;

use App\Models\DiaDiemIp;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class NhanVienController extends Controller
{
    public function index()
    {
        return view('NhanVien');
    }

    public function list()
    {
        $data = [];
        $nhanVien = NhanVien::where('trang_thai',1)
                             ->where('id', '>', 1)   
                            ->get();
        $data['data'] = $nhanVien;
        echo json_encode($data);
    }

    public function load(Request $request ,$id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
            
        }
        $nhanVien = NhanVien::where('trang_thai',1)->find($id);
        $data['data'] = $nhanVien;
        echo json_encode($data);
        // return $nhanVien;
    }

    public function edit(Request $request, $id)
    {   
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $name =  $request->get('name');
        $sdt = $request->get('sdt');
        $date = $request->get('date');
        $gender = $request->get('gender');
        $quequan = $request->get('quequan');
        $quoctich = $request->get('quoctich');
        $diachi = $request->get('diachi');
        $cmnd = $request->get('cmnd');
        $anh = $request->get('anh');
        $email = $request->get('email');
        $hocvan = $request->get('hocvan');
        $taikhoan = $request->get('taikhoan');
        $matkhau = $request->get('matkhau');

        $checkEmail = NhanVien::where('email', $email)
                                ->where('id', '!=', $id)
                                ->where('trang_thai',1)
                                ->count();  
        $checkSdt = NhanVien::where('sdt_nv', $sdt)
                                ->where('id', '!=', $id)
                                ->where('trang_thai',1)
                                ->count();
        $checkCmnd = NhanVien::where('cmnd', $cmnd)
                                ->where('id', '!=', $id)
                                ->where('trang_thai',1)
                                ->count();

        if ($checkCmnd ==  1){
            $json['msg'] = "Số cmnd đã tồn tại";
            $json['code'] = 401; 
        }elseif ($checkSdt == 1){
            $json['msg'] = "Số điện thoại đã tồn tại";
            $json['code'] = 401; 
        }elseif ($checkEmail == 1){
            $json['msg'] = "Địa chỉ Email đã tồn tại";
            $json['code'] = 401; 
        }else{                                             
            $nhanvien = NhanVien::find($id);
            $nhanvien->ten_nv = $name;
            $nhanvien->sdt_nv = $sdt;
            $nhanvien->ngay_sinh = date("Y-m-d",strtotime(str_replace('/','-',$date)));
            $nhanvien->gioi_tinh = $gender;
            $nhanvien->que_quan = $quequan;
            $nhanvien->quoc_tich = $quoctich;
            $nhanvien->dia_chi = $diachi;
            $nhanvien->cmnd = $cmnd;
            $nhanvien->anh = $anh;
            $nhanvien->email = $email;
            $nhanvien->hoc_van = $hocvan;
            $nhanvien->ten_tk = $taikhoan;
            $nhanvien->mat_khau = $matkhau;

            if( $nhanvien->save()){
                $json['msg'] = "Cập nhật dữ liệu thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "Cập nhật dữ liệu thất bại";
                $json['code'] = 401; 
            }
    }
   echo json_encode($json);
    }

    public function store(Request $request)
    {   
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
       $manv = $request->get('manv');
        $name =  $request->get('name');
        $sdt = $request->get('sdt');
        $date = $request->get('date');
        $gender = $request->get('gender');
        $quequan = $request->get('quequan');
        $quoctich = $request->get('quoctich');
        $diachi = $request->get('diachi');
        $cmnd = $request->get('cmnd');
        $anh = $request->get('anh');
        $email = $request->get('email');
        $hocvan = $request->get('hocvan');
        $taikhoan = $request->get('taikhoan');
        $matkhau = $request->get('matkhau');
        
        $checkMa = NhanVien::where('ma_nv', $manv)
                             ->where('trang_thai',1)
                             ->count();
        $checkEmail = NhanVien::where('email', $email)
                                ->where('trang_thai',1)
                                ->count();                     
        $checkSdt = NhanVien::where('sdt_nv', $sdt)
                                ->where('trang_thai',1)
                                ->count();
        $checkCmnd = NhanVien::where('cmnd', $cmnd)
                                ->where('trang_thai',1)
                                ->count();
        if($checkMa == 1){
            $json['msg'] = "Mã nhân viên đã tồn tại";
            $json['code'] = 401; 
        }elseif ($checkCmnd == 1){
            $json['msg'] = "Số cmnd đã tồn tại";
            $json['code'] = 401; 
        }elseif ($checkSdt == 1){
            $json['msg'] = "Số điện thoại đã tồn tại";
            $json['code'] = 401; 
        }elseif ($checkEmail == 1){
            $json['msg'] = "Địa chỉ Email đã tồn tại";
            $json['code'] = 401; 
        }else{                                                    
            $nhanvien = new NhanVien();
            $nhanvien->ma_nv = $manv;
            $nhanvien->ten_nv = $name;
            $nhanvien->sdt_nv = $sdt;
            $nhanvien->ngay_sinh = date("Y-m-d",strtotime(str_replace('/','-',$date)));
            $nhanvien->gioi_tinh = $gender;
            $nhanvien->que_quan = $quequan;
            $nhanvien->quoc_tich = $quoctich;
            $nhanvien->dia_chi = $diachi;
            $nhanvien->cmnd = $cmnd;
            $nhanvien->anh = $anh;
            $nhanvien->email = $email;
            $nhanvien->hoc_van = $hocvan;
            $nhanvien->ten_tk = $taikhoan;
            $nhanvien->mat_khau = $matkhau;
            $nhanvien->trang_thai = 1;

        if($nhanvien->save()){
            $json['msg'] = "Cập nhật dữ liệu thành công";
            $json['code'] = 200;
        }else{
            $json['msg'] = "Cập nhật dữ liệu thất bại";
            $json['code'] = 401; 
        }
        }
      
   echo json_encode($json);
    }

    public function del(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar'); 
            return false;
                }
       $nhanvien = NhanVien::find($id);
       $nhanvien->trang_thai = 0;

       if( $nhanvien->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }

    public function unlock(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar'); 
            return false;
                }
       $nhanvien = NhanVien::find($id);
       $nhanvien->trang_thai = 1;

       if( $nhanvien->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }

    public function taikhoan(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        return view('taikhoan');
    }

    public function getTK(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $data = [];
        $taikhoan = NhanVien::select('id','ten_nv','ten_tk','mat_khau','trang_thai')
                            ->where('id','>', 1)
                            ->where('ten_tk','!=',null)
                            ->where('mat_khau','!=',null)
                           ->get();
        $data['data'] = $taikhoan;
           echo json_encode($data); 
    }

    public function loadTK(Request $request,$id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $taikhoan = NhanVien::where('trang_thai',1)->find($id);
        $data['data'] = $taikhoan;
        echo json_encode($data);
        // return $nhanVien;
    }

    public function listStaff(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $nhanvien = NhanVien::SELECT('id','ten_nv AS text','ten_tk','mat_khau')
                           ->where('id','>', 1)
                        //     ->where('mat_khau','=',null)
                            ->get();
        $data = $nhanvien;
        echo json_encode($data);
        // return $hopDong;
    }

    public function listIp(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $truycap = DiaDiemIp::SELECT('id','ten_dia_diem AS text')
                           ->where('trang_thai',1)
                            ->get();
        $data = $truycap;
        echo json_encode($data);
        // return $hopDong;
    }

    public function editTK(Request $request, $id){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $tenTk = $request->get('tenTk');
        $truycap = $request->get('truycap');
        $matkhau = $request->get('password');

        $checkUserName = NhanVien::where('trang_thai',1)
                                ->where('id', '!=', $id)
                                ->where('ten_tk', $tenTk)
                                ->count();
       
        if($checkUserName == 1){
            $json['msg'] = "Tên tài khoản đã tồn tại";
            $json['code'] = 401; 
        }else{    
            $taikhoan = NhanVien::find($id);
            $taikhoan->id_dd_truy_cap = $truycap;
            $taikhoan->ten_tk = $tenTk;
            $taikhoan->mat_khau = $matkhau;

            if( $taikhoan->save()){
                $json['msg'] = "Cập nhật dữ liệu thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "Cập nhật dữ liệu thất bại";
                $json['code'] = 401; 
            }
        }
        echo json_encode($json);
    }

    
    public function addTK(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
        }
        $id =  $request->get('idNv');
        $truycap = $request->get('truycap');
        $tenTk = $request->get('tenTk');
        $matkhau = $request->get('password');
       
        $checkUserName = NhanVien::where('trang_thai',1)
                                  ->where('ten_tk', $tenTk)
                                  ->count();
        $checkAcc = NhanVien::where('trang_thai',1)
                             ->where('id', $id)
                             ->where('ten_tk', '=', NULL)
                             ->count();

        if($checkUserName == 1){
            $json['msg'] = "Tên tài khoản đã tồn tại";
            $json['code'] = 401; 
        }elseif ($checkAcc == 0){
            $json['msg'] = "Đã có tài khoản";
            $json['code'] = 401;
        }else{
            $taikhoan = NhanVien::find($id);
            $taikhoan->id_dd_truy_cap = $truycap;
            $taikhoan->ten_tk = $tenTk;
            $taikhoan->mat_khau = $matkhau;

            if( $taikhoan->save()){
                $json['msg'] = "Cập nhật dữ liệu thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "Cập nhật dữ liệu thất bại";
                $json['code'] = 401; 
            }
        }    
        echo json_encode($json);
    }

    public function delTK(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar'); 
            return false;
                }
       $taikhoan = NhanVien::find($id);
       $taikhoan->trang_thai = -1;

       if( $taikhoan->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }
}
