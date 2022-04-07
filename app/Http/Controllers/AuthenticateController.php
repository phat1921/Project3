<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Redirect;
use Exception;


class AuthenticateController extends Controller
{
  public function login(){
        return view('login');
    }

   public function loginProcess(Request $request){
        $username = $request->get('username');
        $password = $request->get('password');
        $check = NhanVien::select('trang_thai')
                            ->where('ten_tk', $username)
                            ->where('mat_khau', $password)
                            ->get();
        // if($check == '1'){                    
        try{
            $admin = NhanVien::where('ten_tk', $username)
                            ->where('mat_khau', $password)
                            ->firstOrFail();
                          
                            // if($admin->id == 10){
                                $request->session()->put('id',  $admin->id); 
                                $request->session()->put('name',  $admin->ten_nv);
                                $request->session()->put('anh', $admin->anh);  
                            //     return Redirect::route('calendar');
                                
                            // }else{ 
                            //     $request->session()->put('idnv',  $admin->id); 
                            //     $request->session()->put('namenv',  $admin->ten_nv); 
                                return Redirect::route('calendar'); 
                                // return Redirect::route('calendar'); 
                            // }
                            
        }catch (Exception $e){
            return Redirect::route('login')->with('error', 'Sai tài khoản hoặc mật');
        }
        // }else{
        //     return Redirect::route('login')->with('error', 'Tài khoản đã khóa');
        // }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return Redirect::route('login');
    }
}
