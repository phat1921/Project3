<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Staff;
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
        
        try{
            $admin = Admin::where('email', $username)
                            ->where('pass', $password)
                            ->firstOrFail();
            $request->session()->put('id',  $admin->id);  
           
            // $staff = Staff::where('ten_tk', $username)
            //                 ->where('mat_khau', $password)
            //                 ->firstOrFail();
            // $request->session()->put('idStaff',  $staff->id);                 
            return Redirect::route('dashboard');  
        }catch (Exception $e){
            return Redirect::route('login')->with('error', 'Sai tài khoản hoặc mật');
        }
    }
}
