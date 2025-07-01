<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class kontakController extends Controller
{
    public function index (){
        $data = [
            "title" => "Kontak",
        ];
        return view('kontak',$data);
    }
}
