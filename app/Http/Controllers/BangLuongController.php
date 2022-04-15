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
            return Redirect::route('dashboard');
            return false;
                }
        $nam = $request->get('nam');
        $thang = $request->get('thang');
        $workdays = array();
        $type = CAL_GREGORIAN;
        $day_count = cal_days_in_month($type, $thang, $nam); // Get the amount of days
        for ($i = 1; $i <= $day_count; $i++) {

            $date = $nam.'/'.$thang.'/'.$i; //format date
            $get_name = date('l', strtotime($date)); //get week day
            $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
    
            //if not a weekend add day to array
            if($day_name != 'Sun' && $day_name != 'Sat'){
                $workdays[] = $i;
            }
    }
        $congchuan = count($workdays);
        $ngay = $nam.'-'.$thang;
        $iduser = NhanVien::select('id')
                            ->where('id','>',1)
                            ->where('trang_thai', '>', 0)
                            ->get();
        foreach($iduser as $user){
            $id = $user['id'];
            $congtt = ChamCong::where('id_nhan_vien', $id)
                                ->where('ngay', 'like','%'. $ngay . '%')
                                ->where('gio_ra', '!=', NULL)
                                ->count();

            $luongcb = HopDong::select('luong_co_ban')
                                ->where('id_nv', $id)
                                ->where('trang_thai_hd', 1)
                                ->pluck('luong_co_ban');
            $luongcb = str_replace(array('[',']'),"",$luongcb);   

            $phucap = HopDong::select('phu_cap')
                                ->where('id_nv', $id)
                                ->where('trang_thai_hd', 1)
                                ->pluck('phu_cap');   
            $phucap = str_replace(array('[',']'),"",$phucap); 

            $dimuon = ChamCong::where('id_nhan_vien', $id)
                                    ->where('ngay', 'like','%'. $ngay . '%')
                                    ->where('gio_vao','>','08:30:00')
                                    ->count();
            $checkBl = BangLuong::select('id_bl')
                                  ->where('nam', $nam)
                                  ->where('thang', $thang)
                                  ->where('id_nhan_vien', $id)
                                  ->pluck('id_bl');
            $checkBl = str_replace(array('[',']'),"",$checkBl);                       
            if($checkBl != ''){
                $bangluong = BangLuong::find($checkBl);
                $bangluong->cong_thuc_te = $congtt;
                $bangluong->luong_co_ban = $luongcb;
                $bangluong->phu_cap = $phucap;
                $bangluong->phat_muon = $dimuon;

            }else{
                $bangluong = BangLuong::create([
                    'id_nhan_vien' => $id,
                    'nam' => $nam,
                    'thang' => $thang,
                    'cong_chuan' => $congchuan,
                    'cong_thuc_te' => $congtt,
                    'luong_co_ban' => $luongcb,
                    'phu_cap' => $phucap,
                    'thuong' => 0,
                    'ung_truoc' => 0,
                    'phat_muon' => $dimuon,
                    'tinh_trang' => 1,
                ]);
            }   
            if( $bangluong -> save() || $bangluong == true){
                $json['msg'] = "Cập nhật dữ liệu thành công";
                $json['code'] = 200;
            }else{
                $json['msg'] = "Cập nhật dữ liệu thất bại";
                $json['code'] = 401; 
            }
        }
       
        echo json_encode($json);
    }

    public function load(Request $request, $id){
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
        
        $bangluong = BangLuong::find($id);
        $data['data'] = $bangluong;
        echo json_encode($data);                        
    }

    public function edit(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
       $ngaycong = $request->get('ngaycong');
       $phucap =  str_replace(',', '',$request->get('phucap'));
       $thuong =  str_replace(',', '',$request->get('thuong'));
       $ungtruoc =  str_replace(',', '',$request->get('ungtruoc'));
       $dimuon = $request->get('dimuon');
       $bangluong = BangLuong::find($id);
       $bangluong->cong_thuc_te = $ngaycong;
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
            return Redirect::route('dashboard');
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
            return Redirect::route('dashboard');
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
            return Redirect::route('dashboard');
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
