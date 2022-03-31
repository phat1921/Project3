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
            return Redirect::route('chamcong');
            return false;
                }
        $nam = $request->get('nam');
        $thang = $request->get('thang');
        $ngay = $nam.'-'.$thang;
        $iduser = NhanVien::select('id')
                            ->where('id','>',1)
                            ->where('trang_thai', '>', 0)
                            ->get();
         
        $checkexist = BangLuong::where('nam', $nam)
                            ->where('thang', $thang)
                            ->where('tinh_trang', '>=', 1)
                            ->count();
                
        if($checkexist == 0){
        foreach($iduser as $user){
            $id = $user['id'];
            $congtt = ChamCong::where('id_nhan_vien', $id)
                                ->where('ngay', 'like','%'. $ngay . '%')
                                ->count();

            $luongcb = HopDong::select('luong_co_ban')
                                ->where('id_nv', $id)
                                ->pluck('luong_co_ban');
            $luongcb = str_replace(array('[',']'),"",$luongcb);   

            $phucap = HopDong::select('phu_cap')
                                ->where('id_nv', $id)
                                ->pluck('phu_cap');   
            $phucap = str_replace(array('[',']'),"",$phucap); 

            $dimuon = ChamCong::where('id_nhan_vien', $id)
                                    ->where('ngay', 'like','%'. $ngay . '%')
                                    ->where('gio_vao','>','08:15:00')
                                    ->count();
           
                $bangluong = BangLuong::create([
                    'id_nhan_vien' => $id,
                    'nam' => $nam,
                    'thang' => $thang,
                    'cong_chuan' => 24,
                    'cong_thuc_te' => $congtt,
                    'luong_co_ban' => $luongcb,
                    'phu_cap' => $phucap,
                    'thuong' => 0,
                    'ung_truoc' => 0,
                    'phat_muon' => $dimuon,
                    'tinh_trang' => 1,
                ]);
                    if( $bangluong->save()){
                        $json['msg'] = "Cập nhật dữ liệu thành công";
                        $json['code'] = 200;
                    }else{
                        $json['msg'] = "Cập nhật dữ liệu thất bại";
                        $json['code'] = 401; 
                    }
        }
    }else{
        $json['msg'] = "Bảng lương ".$thang."/".$nam." đã tồn tại";
        $json['code'] = 401; 
}        
        echo json_encode($json);
    }

    public function load(Request $request, $id){
        if($request->session()->get('id') != 1){
            return Redirect::route('chamcong');
            return false;
                }
        
        $bangluong = BangLuong::find($id);
        $data['data'] = $bangluong;
        echo json_encode($data);                        
    }

    public function edit(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('chamcong');
            return false;
                }
       $phucap =  str_replace(',', '',$request->get('phucap'));
       $thuong =  str_replace(',', '',$request->get('thuong'));
       $ungtruoc =  str_replace(',', '',$request->get('ungtruoc'));
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
        if($request->session()->get('id') != 1){
            return Redirect::route('chamcong');
            return false;
                }
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

    public function uncheck(Request $request, $id){
        if($request->session()->get('id') != 1){
            return Redirect::route('chamcong');
            return false;
                }
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

    public function checkById(Request $request, $id){
        if($request->session()->get('id') != 1){
            return Redirect::route('chamcong');
            return false;
                }
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
