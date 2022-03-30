<?php

namespace App\Http\Controllers;

use App\Models\BangLuong;
use App\Models\ChamCong;
use App\Models\ChucVu;
use App\Models\HopDong;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BangLuongController extends Controller
{
    public function index()
    {
        return view('bangluong');
    }

    public function list(Request $request)
    {
        $nam = isset($_REQUEST['nam']) ? $_REQUEST['nam'] : date('Y');
        $thang = isset($_REQUEST['thang']) ? $_REQUEST['thang'] : date('m');
        $userId = $request->session()->get('id');
        $data = [];
        if($userId != 1){
            $bangluong = BangLuong::where('luong.tinh_trang',2)
                                    ->where('luong.nam',$nam)
                                    ->where('luong.thang',$thang)
                                    ->join('nhan_vien','nhan_vien.id','=','luong.id_nhan_vien')
                                    ->where('nhan_vien.id',$userId)
                                    ->get();
        }else{
            $bangluong = BangLuong::whereIn('luong.tinh_trang',[1,2])
                                    ->where('luong.nam',$nam)
                                    ->where('luong.thang',$thang)
                                    ->join('nhan_vien','nhan_vien.id','=','luong.id_nhan_vien')
                                    ->get();
        }
        
        $data['data'] = $bangluong;
        echo json_encode($data);
    }

    public function search(Request $request)
    {
        $nam = $request->get('nam');
        $thang = $request->get('thang');
        $userId = $request->session()->get('id');
        $data = [];
        if($userId != 1){
            $bangluong = BangLuong::where('luong.tinh_trang',2)
                                    ->where('luong.nam',$nam)
                                    ->where('luong.thang',$thang)
                                    ->join('nhan_vien','nhan_vien.id','=','luong.id_nhan_vien')
                                    ->where('nhan_vien.id',$userId)
                                    ->get();
        }else{
            $bangluong = BangLuong::whereIn('luong.tinh_trang', [1,2])
                                    ->where('luong.nam',$nam)
                                    ->where('luong.thang',$thang)
                                    ->join('nhan_vien','nhan_vien.id','=','luong.id_nhan_vien')
                                    ->get();
        }
        
        $data['data'] = $bangluong;
        echo json_encode($data);
    }

    public function add(Request $request){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        $nam = $request->get('nam');
        $thang = $request->get('thang');
        $ngay = $nam.'-'.$thang;
        $iduser = NhanVien::select('id')
                            ->where('id','>',1)
                            ->where('trang_thai', '>', 0)
                            ->get();
        // $id = explode(",", $iduser);
        // $congtt = ChamCong::where('id_nhan_vien', $iduser )
        //                   ->where('ngay', 'like','%'. $ngay . '%')    
        //                   ->count();               
        // dd($ngay,$congtt);
        // return;             
        // foreach($iduser as $user){
            // $id = $user['id'];
            // $data = [];
            // $data['id_nhan_vien'] = $id;
            // $data['nam'] = $nam;
            // $data['thang'] = $thang;
            // $data['cong_chuan'] = 24;
          
            $luongcb = HopDong::select('hop_dong_lao_dong.luong_co_ban', 'hop_dong_lao_dong.phu_cap')
                                ->join('nhan_vien','hop_dong_lao_dong.id_nv','=', 'nhan_vien.id')
                                ->where('nhan_vien.id',3)
                                ->join('chuc_vu', 'chuc_vu.id', '=', 'hop_dong_lao_dong.id_chuc_vu')
                                ->get();
            // $data['luong_co_ban'] = $luongcb;    
            // $data['phu_cap'] = 0;
            // $data['tinh_trang'] = 1;
            
            $bangluong =  BangLuong::create([
                'id_nhan_vien' => 3,
                'nam' => $nam,
                'thang' => $thang,
                'cong_chuan' => 24,
                'luong_co_ban' => $luongcb,
                'phu_cap' => 0,
                'phat_muon' => 0,
                'tinh_trang' => 1,

            ]);
            
            $bangluong->save();
            // dd($id);
            // $congtt = ChamCong::where('id_nhan_vien', $iduser)
            //                     ->where('ngay', 'like','%'. $ngay . '%')
            //                     ->count();
            // dd($congtt);  

        // }
    }

    public function load(Request $request, $id){
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        
        $bangluong = BangLuong::find($id);
        $data['data'] = $bangluong;
        echo json_encode($data);                        
    }

    public function edit(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
       $phucap =  $request->get('phucap');
       $thuong = $request->get('thuong');
       $ungtruoc = $request->get('ungtruoc');
       $dimuon = $request->get('dimuon');
       $bangluong = BangLuong::find($id);
       $bangluong->phu_cap = $phucap;
       $bangluong->thuong= $thuong;
       $bangluong->ung_truoc= $ungtruoc;
       $bangluong->phat_muon= $dimuon;

       if( $bangluong->save()){
            $json['msg'] = "Cập nhật dữ liệu thành công";
            $json['code'] = 200;
        }else{
            $json['msg'] = "Cập nhật dữ liệu thất bại";
            $json['code'] = 401; 
        }
       echo json_encode($json);
    }

    public function checkall(Request $request){ 
        $nam = $request->get('nam');
        $thang = $request->get('thang');
        $checkall = BangLuong::where('nam',$nam)
                                ->where('thang', $thang)
                                ->where('tinh_trang', 1)
                                ->update(array('tinh_trang' => 2));
        if( $checkall == true){
            $json['msg'] = "Duyệt bảng lương ".$thang."/".$nam." thành công";
            $json['code'] = 200;
        }else{
            $json['msg'] = "Bảng lương ".$thang."/".$nam." đã tồn tại";
            $json['code'] = 401; 
        }
        echo json_encode($json);                        
    }

    public function uncheck($id){
        $uncheck = BangLuong::find($id);
        $uncheck->tinh_trang = 1;
        
        if( $uncheck -> save()){
            $json['msg'] = "Cập nhật dữ liệu thành công";
            $json['code'] = 200;
        }else{
            $json['msg'] = "Cập nhật dữ liệu thất bại";
            $json['code'] = 401; 
        }
        echo json_encode($json);   
    }

    public function checkById($id){
        $checkById = BangLuong::find($id);
        $checkById->tinh_trang = 2;
        
        if( $checkById -> save()){
            $json['msg'] = "Cập nhật dữ liệu thành công";
            $json['code'] = 200;
        }else{
            $json['msg'] = "Cập nhật dữ liệu thất bại";
            $json['code'] = 401; 
        }
        echo json_encode($json);   
    }
}
