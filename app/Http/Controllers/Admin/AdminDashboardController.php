<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Game;
use App\Models\Reseller;
use App\Models\Withdrawal;
use App\Models\Bundle;
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
            'total_games' => Game::count(),
            'total_withdrawals' => Withdrawal::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_bundles' => Bundle::count(),
            
            // Transaction status counts
            'failed_transactions' => Transaction::where('status', Transaction::STATUS_FAILED)->count(),
            'pending_transactions' => Transaction::where('status', Transaction::STATUS_PENDING)->count(),
            'successful_transactions' => Transaction::where('status', Transaction::STATUS_SUCCESS)->count(),
            'cancelled_transactions' => Transaction::where('status', Transaction::STATUS_CANCELLED)->count(),
            
            // Revenue statistics
            'today_revenue' => Transaction::where('status', Transaction::STATUS_SUCCESS)
                ->whereDate('created_at', $today)
                ->sum('amount'),
            'month_revenue' => Transaction::where('status', Transaction::STATUS_SUCCESS)
                ->where('created_at', '>=', $thisMonth)
                ->sum('amount'),
            
            // Today's statistics
            'today_transactions' => Transaction::whereDate('created_at', $today)->count(),
            'today_visitors' => 98, // Mock data for now
            'today_page_views' => 991, // Mock data for now
            'online_users' => 98, // Mock data for now
            
            // Recent transactions
            'recent_transactions' => Transaction::with(['user', 'reseller'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
            
            // Top performing games
            'top_games' => Game::withCount(['transactions' => function($query) {
                $query->where('status', Transaction::STATUS_SUCCESS);
            }])
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get()
        ];

        return $stats;
    }
}
