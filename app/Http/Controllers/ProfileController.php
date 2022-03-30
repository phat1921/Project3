<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;
use App\Http\Requests\JsonRequest;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
        
    }

    public function list(Request $request)
    {
        $data = [];
        $idUser = $request->session()->get('id');
        $profile = NhanVien::where('trang_thai',1)
                             ->where('id', $idUser)   
                            ->get();
        $data['data'] = $profile;
        echo json_encode($data);
    }

    public function edit(Request $request)
    {   
       $idUser = $request->session()->get('id');
       $name =  $request->get('name');
       $sdt = $request->get('phonenum');
       $email = $request->get('email');
       $cmnd = $request->get('cmnd');
       $diachi = $request->get('diachi');
       $quoctich = $request->get('quoctich');
       $quequan = $request->get('quequan');

       $profile = NhanVien::find($idUser);
       $profile->sdt_nv = $sdt;
       $profile->ten_nv = $name;
       $profile->email = $email;
       $profile->cmnd = $cmnd;
       $profile->dia_chi = $diachi;
       $profile->quoc_tich = $quoctich;
       $profile->que_quan = $quequan;

      
    if( $profile->save()){
        $json['msg'] = "Cập nhật dữ liệu thành công";
        $json['code'] = 200;
    }else{
        $json['msg'] = "Cập nhật dữ liệu thất bại";
        $json['code'] = 401; 
    }
   echo json_encode($json);
    }

    public function upAvatar(Request $request){
        // $request->validate([
        //     'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //   ]);
          $idUser = $request->session()->get('id');
         $test = $request->image->extension();
         dd($test);
          
          if ($request->file('avatar')) {
              $imagePath = $request->file('avatar');
              $imageName = $imagePath->getClientOriginalName();
  
              $path = $request->file('avatar')->storeAs('uploads', $imageName, 'public');
          }
        //   $image->name = $imageName;
        $image = NhanVien::find($idUser);
          $image->anh = '/storage/'.$path;
          $image->save();
          if( $image->save()){
            $json['msg'] = "Cập nhật dữ liệu thành công";
            $json['code'] = 200;
        }else{
            $json['msg'] = "Cập nhật dữ liệu thất bại";
            $json['code'] = 401; 
        }
    }

    public function changePass(Request $request){
        $idUser = $request->session()->get('id');
        $password = $request->get('password');
        $pass = NhanVien::where('mat_khau', $password)->where('id', $idUser)->count();

        if($pass > 0){
            $newpass = $request->get('newpass');
            $renewpass = $request->get('renewpass');
                if($newpass == $renewpass){
                    $changePass = NhanVien::find($idUser);
                    $changePass->mat_Khau = $newpass;
                        if($changePass->save()){
                            $json['msg'] = "Cập nhật dữ liệu thành công";
                            $json['code'] = 200;
                        }else{
                            $json['msg'] = "Cập nhật dữ liệu thất bại";
                            $json['code'] = 401; 
                        }
                }else{
                    $json['msg'] = "Mật khẩu không khớp";
                    $json['code'] = 401; 
                }
        }else{
            $json['msg'] = "Mật khẩu hiện tại không chính xác";
            $json['code'] = 401; 
        }
            echo json_encode($json);
    }

}