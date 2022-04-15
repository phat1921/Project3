<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChucVuController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        return view('ChucVu');
    }

    public function list(Request $request)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        $data = [];
        $chucVu = ChucVu::where('trang_thai',1)->get();
        $data['data'] = $chucVu;
        echo json_encode($data);
    }

    public function load(Request $request,$id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        $chucVu = ChucVu::where('trang_thai',1)->find($id);
        $data['data'] = $chucVu;
        echo json_encode($data);
        // return $chucVu;
    }

    public function edit(Request $request, $id)
    {
        if($request->session()->get('id') != 1){
            return Redirect::route('calendar');
            return false;
                }
        $name =  $request->get('name');
       $salary = $request->get('salary');
       $chucvu = ChucVu::find($id);
       $chucvu->ten_chuc_vu = $name;
       $chucvu->luong_co_ban = $salary;

      if($chucvu->save()){
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
            return Redirect::route('calendar');
            return false;
                }
       $name =  $request->get('name');
       $salary = $request->get('salary');
       $chucvu = new ChucVu();
       $chucvu->ten_chuc_vu = $name;
       $chucvu->luong_co_ban = $salary;
       $chucvu->trang_thai = 1;

       if($chucvu->save()){
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
            return Redirect::route('calendar');
            return false;
                }
       $chucvu = ChucVu::find($id);
       $chucvu->trang_thai = 0;

       if($chucvu->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
       echo json_encode($json);
    }
}
