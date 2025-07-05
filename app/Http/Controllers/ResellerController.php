<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResellerController extends Controller
{
    /**
     * Show reseller registration form.
     */
    public function showRegister()
    {
        return view('reseller.register');
    }

    /**
     * Register a new reseller.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:50',
            'bank_account_name' => 'required|string|max:255',
            'referral_code' => 'nullable|string|exists:resellers,referral_code',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'phone.required' => 'Nomor telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'city.required' => 'Kota harus diisi',
            'province.required' => 'Provinsi harus diisi',
            'postal_code.required' => 'Kode pos harus diisi',
            'bank_name.required' => 'Nama bank harus diisi',
            'bank_account_number.required' => 'Nomor rekening harus diisi',
            'bank_account_name.required' => 'Nama pemilik rekening harus diisi',
            'referral_code.exists' => 'Kode referral tidak valid',
        ]);

        DB::beginTransaction();

        try {
            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => 'reseller',
                'is_active' => true,
            ]);

            // Find referrer if referral code provided
            $referrer = null;
            if ($request->referral_code) {
                $referrer = Reseller::where('referral_code', $request->referral_code)->first();
            }

            // Create reseller profile
            $reseller = Reseller::create([
                'user_id' => $user->id,
                'reseller_code' => Reseller::generateResellerCode(),
                'company_name' => $request->company_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'commission_rate' => 5.00, // Default commission rate
                'status' => Reseller::STATUS_PENDING,
                'referral_code' => Reseller::generateReferralCode(),
                'referred_by' => $referrer?->id,
            ]);

            DB::commit();

            // Log in the user
            Auth::login($user);

            return redirect()->route('reseller.dashboard')->with('success', 'Registrasi reseller berhasil! Akun Anda sedang menunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollback();
            // DEBUG: tampilkan pesan error asli di browser
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show reseller dashboard.
     */
    public function dashboard()
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        $statistics = [
            'total_transactions' => $reseller->transactions()->count(),
            'total_earnings' => $reseller->total_earnings,
            'balance' => $reseller->balance,
            'pending_withdrawals' => $reseller->withdrawals()->pending()->count(),
            'recent_transactions' => $reseller->transactions()->with('game')->latest()->take(5)->get(),
            'recent_withdrawals' => $reseller->withdrawals()->latest()->take(5)->get(),
        ];

        return view('reseller.dashboard', compact('reseller', 'statistics'));
    }

    /**
     * Show reseller profile.
     */
    public function profile()
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        return view('reseller.profile', compact('reseller'));
    }

    /**
     * Update reseller profile.
     */
    public function updateProfile(Request $request)
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:50',
            'bank_account_name' => 'required|string|max:255',
        ]);

        $reseller->update($request->only([
            'company_name', 'phone', 'address', 'city', 'province', 
            'postal_code', 'bank_name', 'bank_account_number', 'bank_account_name'
        ]));

        // Update user phone
        Auth::user()->update(['phone' => $request->phone]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show transactions history.
     */
    public function transactions()
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        $transactions = $reseller->transactions()
            ->with(['game', 'user'])
            ->latest()
            ->paginate(20);

        return view('reseller.transactions', compact('reseller', 'transactions'));
    }

    /**
     * Show withdrawal history.
     */
    public function withdrawals()
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        $withdrawals = $reseller->withdrawals()
            ->latest()
            ->paginate(20);

        return view('reseller.withdrawals', compact('reseller', 'withdrawals'));
    }

    /**
     * Show withdrawal form.
     */
    public function showWithdrawalForm()
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        if (!$reseller->isActive()) {
            return back()->withErrors(['error' => 'Akun reseller Anda tidak aktif.']);
        }

        return view('reseller.withdrawal-form', compact('reseller'));
    }

    /**
     * Submit withdrawal request.
     */
    public function submitWithdrawal(Request $request)
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller || !$reseller->isActive()) {
            return back()->withErrors(['error' => 'Akun reseller Anda tidak aktif.']);
        }

        $request->validate([
            'amount' => 'required|numeric|min:50000|max:' . $reseller->balance,
            'bank_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:50',
            'bank_account_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ], [
            'amount.required' => 'Jumlah penarikan harus diisi',
            'amount.min' => 'Minimal penarikan Rp 50.000',
            'amount.max' => 'Saldo tidak mencukupi',
            'bank_name.required' => 'Nama bank harus diisi',
            'bank_account_number.required' => 'Nomor rekening harus diisi',
            'bank_account_name.required' => 'Nama pemilik rekening harus diisi',
        ]);

        // Check if there's a pending withdrawal
        $pendingWithdrawal = $reseller->withdrawals()->pending()->first();
        if ($pendingWithdrawal) {
            return back()->withErrors(['error' => 'Anda masih memiliki permintaan penarikan yang pending.']);
        }

        // Create withdrawal request
        $reseller->withdrawals()->create([
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('reseller.withdrawals')->with('success', 'Permintaan penarikan berhasil diajukan!');
    }

    /**
     * Show referrals.
     */
    public function referrals()
    {
        $reseller = Auth::user()->reseller;
        
        if (!$reseller) {
            return redirect()->route('reseller.register');
        }

        $referrals = $reseller->referrals()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('reseller.referrals', compact('reseller', 'referrals'));
    }
} 