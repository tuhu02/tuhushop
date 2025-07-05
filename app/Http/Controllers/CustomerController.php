<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\PriceList;
use App\Models\Transaction;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index() { return abort(404); }

    public function showProduct($productId) { return abort(404); }

    public function showCategory($categoryId) { return abort(404); }

    public function checkout(Request $request) { return abort(404); }

    public function payment($orderId) { return abort(404); }

    public function paymentSuccess($orderId) { return abort(404); }

    public function paymentFailed($orderId) { return abort(404); }

    public function search(Request $request) { return abort(404); }
} 