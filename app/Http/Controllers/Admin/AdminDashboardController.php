<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Produk;
use App\Models\Reseller;
use App\Models\Withdrawal;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = $this->getDashboardStats();
        
        $data = [
            "title" => "Admin Dashboard",
            "stats" => $stats
        ];
        
        return view("admin.dashboardAdmin", $data);
    }

    private function getDashboardStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        $stats = [
            'total_users' => User::count(),
            'total_resellers' => Reseller::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('status', 'success')->sum('amount'),
            'total_games' => Produk::count(),
            'total_withdrawals' => Withdrawal::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            
            'today_transactions' => Transaction::whereDate('created_at', $today)->count(),

            // Transaction status counts
            'failed_transactions' => Transaction::where('status', Transaction::STATUS_FAILED)->count(),
            'pending_transactions' => Transaction::where('status', Transaction::STATUS_PENDING)->count(),
            'successful_transactions' => Transaction::where('status', Transaction::STATUS_SUCCESS)->count(),
            'cancelled_transactions' => Transaction::where('status', Transaction::STATUS_CANCELLED)->count(),
            
            // Revenue statistics
            'today_revenue' => Transaction::where('status', Transaction::STATUS_SUCCESS)
                ->whereDate('created_at', $today)
                ->sum('amount'),
            
            'this_month_revenue' => Transaction::where('status', Transaction::STATUS_SUCCESS)
                ->whereMonth('created_at', $thisMonth->month)
                ->whereYear('created_at', $thisMonth->year)
                ->sum('amount'),
            
            // Recent transactions
            'recent_transactions' => Transaction::with(['user', 'game'])
                ->latest()
                ->take(5)
                ->get(),
            
            // Top games by transaction count
            'top_games' => Produk::withCount(['transactions' => function($query) {
                $query->where('status', Transaction::STATUS_SUCCESS);
            }])
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get(),
        ];
        
        return $stats;
    }
}
