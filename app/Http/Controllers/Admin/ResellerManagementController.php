<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResellerManagementController extends Controller
{
    /**
     * Show reseller management dashboard.
     */
    public function index()
    {
        $statistics = Reseller::getStatistics();
        
        $recentResellers = Reseller::with('user')
            ->latest()
            ->take(10)
            ->get();

        $pendingWithdrawals = Withdrawal::with('reseller.user')
            ->pending()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reseller.index', compact('statistics', 'recentResellers', 'pendingWithdrawals'));
    }

    /**
     * Show all resellers.
     */
    public function resellers()
    {
        $resellers = Reseller::with('user')
            ->when(request('search'), function($query, $search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('reseller_code', 'like', "%{$search}%")
                ->orWhere('company_name', 'like', "%{$search}%");
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.reseller.list', compact('resellers'));
    }

    /**
     * Show reseller details.
     */
    public function show(Reseller $reseller)
    {
        $reseller->load(['user', 'transactions.game', 'withdrawals', 'referrals.user']);
        
        $statistics = [
            'total_transactions' => $reseller->transactions()->count(),
            'successful_transactions' => $reseller->transactions()->successful()->count(),
            'total_earnings' => $reseller->total_earnings,
            'balance' => $reseller->balance,
            'total_withdrawals' => $reseller->withdrawals()->count(),
            'pending_withdrawals' => $reseller->withdrawals()->pending()->count(),
            'total_referrals' => $reseller->referrals()->count(),
        ];

        return view('admin.reseller.show', compact('reseller', 'statistics'));
    }

    /**
     * Approve reseller.
     */
    public function approve(Reseller $reseller)
    {
        if ($reseller->status !== Reseller::STATUS_PENDING) {
            return back()->withErrors(['error' => 'Reseller tidak dalam status pending.']);
        }

        $reseller->update([
            'status' => Reseller::STATUS_ACTIVE,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Reseller berhasil disetujui!');
    }

    /**
     * Reject reseller.
     */
    public function reject(Request $request, Reseller $reseller)
    {
        if ($reseller->status !== Reseller::STATUS_PENDING) {
            return back()->withErrors(['error' => 'Reseller tidak dalam status pending.']);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $reseller->update([
            'status' => Reseller::STATUS_REJECTED,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Reseller berhasil ditolak!');
    }

    /**
     * Suspend reseller.
     */
    public function suspend(Reseller $reseller)
    {
        if ($reseller->status !== Reseller::STATUS_ACTIVE) {
            return back()->withErrors(['error' => 'Reseller tidak dalam status aktif.']);
        }

        $reseller->update([
            'status' => Reseller::STATUS_SUSPENDED,
        ]);

        return back()->with('success', 'Reseller berhasil ditangguhkan!');
    }

    /**
     * Activate reseller.
     */
    public function activate(Reseller $reseller)
    {
        if ($reseller->status !== Reseller::STATUS_SUSPENDED) {
            return back()->withErrors(['error' => 'Reseller tidak dalam status suspended.']);
        }

        $reseller->update([
            'status' => Reseller::STATUS_ACTIVE,
        ]);

        return back()->with('success', 'Reseller berhasil diaktifkan kembali!');
    }

    /**
     * Update commission rate.
     */
    public function updateCommission(Request $request, Reseller $reseller)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        $reseller->update([
            'commission_rate' => $request->commission_rate,
        ]);

        return back()->with('success', 'Komisi berhasil diperbarui!');
    }

    /**
     * Show withdrawal requests.
     */
    public function withdrawals()
    {
        $withdrawals = Withdrawal::with('reseller.user')
            ->when(request('search'), function($query, $search) {
                $query->whereHas('reseller.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('reseller', function($q) use ($search) {
                    $q->where('reseller_code', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.reseller.withdrawals', compact('withdrawals'));
    }

    /**
     * Process withdrawal.
     */
    public function processWithdrawal(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== Withdrawal::STATUS_PENDING) {
            return back()->withErrors(['error' => 'Withdrawal tidak dalam status pending.']);
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:500',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            if ($request->action === 'approve') {
                // Check if reseller has enough balance
                if ($withdrawal->reseller->balance < $withdrawal->amount) {
                    return back()->withErrors(['error' => 'Saldo reseller tidak mencukupi.']);
                }

                // Deduct balance
                $withdrawal->reseller->deductBalance($withdrawal->amount);

                // Update withdrawal status
                $withdrawal->update([
                    'status' => Withdrawal::STATUS_COMPLETED,
                    'processed_at' => now(),
                    'processed_by' => auth()->id(),
                    'notes' => $request->notes,
                ]);

                $message = 'Withdrawal berhasil diproses!';
            } else {
                // Reject withdrawal
                $withdrawal->update([
                    'status' => Withdrawal::STATUS_REJECTED,
                    'processed_at' => now(),
                    'processed_by' => auth()->id(),
                    'rejection_reason' => $request->rejection_reason,
                ]);

                $message = 'Withdrawal berhasil ditolak!';
            }

            DB::commit();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses withdrawal.']);
        }
    }

    /**
     * Show reseller statistics.
     */
    public function statistics()
    {
        $resellerStats = Reseller::getStatistics();
        $withdrawalStats = Withdrawal::getStatistics();

        // Monthly earnings chart data
        $monthlyEarnings = Reseller::selectRaw('MONTH(created_at) as month, SUM(total_earnings) as earnings')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top performing resellers
        $topResellers = Reseller::with('user')
            ->orderBy('total_earnings', 'desc')
            ->take(10)
            ->get();

        return view('admin.reseller.statistics', compact(
            'resellerStats', 
            'withdrawalStats', 
            'monthlyEarnings', 
            'topResellers'
        ));
    }

    /**
     * Export resellers data.
     */
    public function export()
    {
        $resellers = Reseller::with('user')->get();

        $filename = 'resellers_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($resellers) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Nama', 'Email', 'Kode Reseller', 'Perusahaan', 
                'Status', 'Saldo', 'Total Pendapatan', 'Total Transaksi',
                'Tanggal Registrasi', 'Tanggal Disetujui'
            ]);

            // Add data
            foreach ($resellers as $reseller) {
                fputcsv($file, [
                    $reseller->id,
                    $reseller->user->name,
                    $reseller->user->email,
                    $reseller->reseller_code,
                    $reseller->company_name,
                    $reseller->status,
                    $reseller->balance,
                    $reseller->total_earnings,
                    $reseller->total_transactions,
                    $reseller->created_at->format('Y-m-d H:i:s'),
                    $reseller->approved_at ? $reseller->approved_at->format('Y-m-d H:i:s') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 