<?php

namespace App\Http\Controllers;

use App\Models\DiaDiemIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DiaDiemIpController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
        return view('diadiemip');
    }

    public function list(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
        $data = [];
        $diadiem = DiaDiemIp::where('trang_thai',1)->get();
        $data['data'] = $diadiem;
        echo json_encode($data);
    }

    public function load(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
        $diadiem = DiaDiemIp::where('trang_thai',1)->find($id);
        $data['data'] = $diadiem;
        echo json_encode($data);
        // return $chucVu;
    }

    

    public function edit(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('dashboard');
            return false;
                }
        $name =  $request->get('name');
       $ip = $request->get('ip');
       $diadiem = DiaDiemIp::find($id);
       $diadiem->ten_dia_diem = $name;
       $diadiem->ip= $ip;

       if( $diadiem->save()){
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
       $name =  $request->get('name');
       $ip = $request->get('ip');
       $diadiem = new DiaDiemIp();
       $diadiem->ten_dia_diem = $name;
       $diadiem->ip = $ip;
       $diadiem->trang_thai = 1;

       if( $diadiem->save()){
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
       $diadiem = DiaDiemIp::find($id);
       $diadiem->trang_thai = 0;

       if( $diadiem->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }
}
