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
                            ->first();
                            
        return response()->json(['profile' => $profile], 200);
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
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);

        $filePath = '';

        $idUser = $request->session()->get('id');
        //$test = $request->image->extension();
          
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');

            $filePath = asset('storage/' . $avatarFile->store('uploads', 'public'));
        }

        //   $image->name = $imageName;
        $user = NhanVien::find($idUser);
        $user->anh = $filePath;

        $response = [];

        if($user->save()){
            $response['msg'] = "Cập nhật dữ liệu thành công";
            $response['code'] = 200;
        }else{
            $response['msg'] = "Cập nhật dữ liệu thất bại";
            $response['code'] = 401; 
        }

        return response()->json($response);
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