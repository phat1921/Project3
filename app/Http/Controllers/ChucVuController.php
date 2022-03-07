<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function index()
    {
        return view('ChucVu');
    }

    public function list()
    {
        $data = [];
        $chucVu = ChucVu::where('trang_thai',1)->get();
        $data['data'] = $chucVu;
        echo json_encode($data);
    }

    public function store(Request $request)
    {   
       $name =  $request->get('name');
       $salary = $request->get('salary');
       $chucvu = new ChucVu();
       $chucvu->ten_chuc_vu = $name;
       $chucvu->luong_co_ban = $salary;
       $chucvu->trang_thai = 1;

       $chucvu->save();
       echo json_encode($chucvu);
    }
}
