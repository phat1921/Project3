<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use App\Models\HopDong;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HopDongController extends Controller
{
    public function index()
    {
        return view('hopdong');
    }

    public function list(Request $request)
    {
        $data = [];
        $userid = $request->session()->get('id');
        if($userid != 1){
        $hopDong = HopDong::where('hop_dong_lao_dong.trang_thai_hd', ">", 0)
                            ->join("nhan_vien", "hop_dong_lao_dong.id_nv", "=", "nhan_vien.id")
                            ->where("nhan_vien.id", $userid)
                            ->where("nhan_vien.trang_thai",1)
                            ->get();
        }else{
            $hopDong = HopDong::where('hop_dong_lao_dong.trang_thai_hd', ">", 0)
            ->join("nhan_vien", "hop_dong_lao_dong.id_nv", "=", "nhan_vien.id")
            ->where("nhan_vien.trang_thai",1)
            ->get();
        }
        $data['data'] = $hopDong;
        echo json_encode($data);
    }

    public function load(Request $request, $id)
    {
        // if($request->session()->get('id') != 1){
        //     return Redirect::route('dashboard');
        //     return false;
        //         }
        $hopDong = HopDong::find($id);
        $data['data'] = $hopDong;
        echo json_encode($data);
        // return $hopDong;
    }

    public function listStaff(Request $request)
    {
        // if($request->session()->get('id') != 1){
        //     return Redirect::route('dashboard');
        //     return false;
        //         }
        $nhanvien = NhanVien::SELECT('id','ten_nv AS text')
                                ->where('id', '>', 1)
                                ->get();
        $data = $nhanvien;
        echo json_encode($data);
        // return $hopDong;
    }

    public function listRole(Request $request)
    {
        // if($request->session()->get('id') != 1){
        //     return Redirect::route('dashboard');
        //     return false;
        //         }
        $chucvu = ChucVu::SELECT('id','ten_chuc_vu AS text','luong_co_ban')->get();
        $data = $chucvu;
        echo json_encode($data);
        // return $hopDong;
    }

    public function getSalary(Request $request)
    {
        // if($request->session()->get('id') != 1){
        //     return Redirect::route('dashboard');
        //     return false;
        //         }
        $idChucVu = $request->get('chucvuId');
        $chucvu = ChucVu::SELECT('luong_co_ban')
                        ->where('id', $idChucVu)
                        ->get();
        $data['data'] = $chucvu;
        echo json_encode($data);
        // return $hopDong;
    }

    public function edit(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
        $idNv =  $request->get('idNv');
        $idChucVu =  $request->get('idChucVu');
       $loaiHD = $request->get('loaiHD');
       $chinhanh = $request->get('chinhanh');
       $diachi = $request->get('diachi');
       $salary =  str_replace(',', '',$request->get('salary'));
       $phucap =  str_replace(',', '',$request->get('phucap'));
       $startday = $request->get('startday');
       $enddate = $request->get('endday');
       $trangthai = $request->get('trangthai');

       if($startday > $enddate){
        $json['msg'] = "Ngày kết thúc không thể nhỏ hơn ngày bắt đầu";
        $json['code'] = 402;
        echo json_encode($json);
        return false;
       }       

       $hopdong = HopDong::find($id);
       $hopdong->id_nv = $idNv;
       $hopdong->id_chuc_vu = $idChucVu;
       $hopdong->loai_hop_dong = $loaiHD;
       $hopdong->chi_nhanh = $chinhanh;
       $hopdong->dia_diem = $diachi;
       $hopdong->luong_co_ban = $salary;
       $hopdong->phu_cap = $phucap;
       $hopdong->ngay_bat_dau = date("Y-m-d",strtotime(str_replace('/','-',$startday)));
       $hopdong->ngay_ket_thuc = date("Y-m-d",strtotime(str_replace('/','-',$enddate)));
       $hopdong->trang_thai_hd = $trangthai;

       
       if($hopdong->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }

    public function store(Request $request)
    {   
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
       $idNv =  $request->get('idNv');
       $idChucVu =  $request->get('idChucVu');
       $loaiHD = $request->get('loaiHD');
       $chinhanh = $request->get('chinhanh');
       $diachi = $request->get('diachi');
       $salary = str_replace(',', '',$request->get('salary'));
       $phucap =  str_replace(',', '',$request->get('phucap'));
       $startday = $request->get('startday');
       $enddate = $request->get('endday');
       $trangthai = $request->get('trangthai');
       
       $checkHd = HopDong::where('id_nv', $idNv)
                           ->where('trang_thai_hd', 1)
                           ->count();
       if($startday > $enddate){
        $json['msg'] = "Ngày kết thúc không thể nhỏ hơn ngày bắt đầu";
        $json['code'] = 402;
        echo json_encode($json);
        return false;
       }                    
       if($checkHd == 1){
            $json['msg'] = "Còn hợp đồng đang thực hiện";
            $json['code'] = 402;
            echo json_encode($json);
            return false;
       }                    

       $hopdong = new HopDong();
       $hopdong->id_nv = $idNv;
       $hopdong->id_chuc_vu = $idChucVu;
       $hopdong->loai_hop_dong = $loaiHD;
       $hopdong->chi_nhanh = $chinhanh;
       $hopdong->dia_diem = $diachi;
       $hopdong->luong_co_ban = $salary;
       $hopdong->phu_cap = $phucap;
       $hopdong->ngay_bat_dau = date("Y-m-d",strtotime(str_replace('/','-',$startday)));
       $hopdong->ngay_ket_thuc = date("Y-m-d",strtotime(str_replace('/','-',$enddate)));
       $hopdong->trang_thai_hd = $trangthai;

       if($hopdong->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }

    public function del(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
       $hopdong = HopDong::find($id);
       $hopdong->trang_thai_hd = 2;

       if($hopdong->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }
}
