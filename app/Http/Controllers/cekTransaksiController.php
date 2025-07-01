<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cekTransaksiController extends Controller
{
    public function index(){
        $data = [
            "title" => "Cek Transasksi",
        ];
        
        return view("cekTransaksi",$data);
    }
}
