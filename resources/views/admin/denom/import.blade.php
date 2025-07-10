@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Import Denom dari Apigames</h1>
    
    <!-- Debug button untuk cek project list -->
    <div class="mb-4">
        <a href="{{ route('admin.denom.importApigames', ['test_connection' => 1]) }}" 
           class="px-4 py-2 bg-green-600 text-white rounded mr-2">
            Test: Cek Koneksi API
        </a>
        <a href="{{ route('admin.denom.importApigames', ['debug_projects' => 1]) }}" 
           class="px-4 py-2 bg-yellow-600 text-white rounded mr-2">
            Debug: Cek Project List dari API
        </a>
        <a href="{{ route('admin.denom.importApigames', ['projectid' => 1, 'debug_denoms' => 1]) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded mr-2">
            Test: Cek Denom Free Fire (ID: 1)
        </a>
        <a href="{{ route('admin.denom.importApigames', ['test_voucher_params' => 1]) }}" 
           class="px-4 py-2 bg-purple-600 text-white rounded mr-2">
            Test: Cek Semua Parameter Voucher
        </a>
        <a href="{{ route('admin.denom.importApigames', ['check_endpoints' => 1]) }}" 
           class="px-4 py-2 bg-red-600 text-white rounded mr-2">
            Check: Semua Endpoint yang Tersedia
        </a>
        <a href="{{ route('admin.denom.importApigames', ['test_voucher_form' => 1]) }}" 
           class="px-4 py-2 bg-orange-600 text-white rounded mr-2">
            Test: Voucher Detail dengan Form Data
        </a>
        <a href="{{ route('admin.denom.importApigames', ['test_api_structures' => 1]) }}" 
           class="px-4 py-2 bg-indigo-600 text-white rounded mr-2">
            Test: Struktur API Berbeda
        </a>
        <a href="{{ route('admin.denom.importApigames', ['comprehensive_test' => 1]) }}" 
           class="px-4 py-2 bg-pink-600 text-white rounded mr-2">
            Test: Comprehensive Voucher
        </a>
        <a href="{{ route('admin.denom.manual') }}" 
           class="px-4 py-2 bg-green-600 text-white rounded mr-2">
            Tambah Denom Manual
        </a>
        <a href="{{ route('admin.denom.importDigiflazz') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded">
            Import dari Digiflazz
        </a>
    </div>
    
    <form method="GET" action="{{ route('admin.denom.importApigames') }}" class="mb-6">
        <label for="projectid" class="block mb-2 font-semibold">Pilih Project ID</label>
        <select name="projectid" id="projectid" class="border rounded px-3 py-2 w-full max-w-md">
            <option value="">-- Pilih Project ID --</option>
            @if(isset($projectList['data']) && is_array($projectList['data']))
                @foreach($projectList['data'] as $project)
                    <option value="{{ $project['id'] ?? $project['project_id'] ?? '' }}" 
                            {{ request('projectid') == ($project['id'] ?? $project['project_id'] ?? '') ? 'selected' : '' }}>
                        {{ $project['name'] ?? $project['project_name'] ?? 'Unknown' }} 
                        (ID: {{ $project['id'] ?? $project['project_id'] ?? 'N/A' }})
                    </option>
                @endforeach
            @else
                <option value="" disabled>Loading project list...</option>
            @endif
        </select>
        <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Tampilkan Denom</button>
    </form>

    @if($projectid && $denoms && !empty($denoms['data']))
    <form method="POST" action="{{ route('admin.denom.storeImport') }}">
        @csrf
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2">Pilih</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($denoms['data'] ?? [] as $denom)
                <tr>
                    <td class="px-4 py-2 text-center">
                        <input type="checkbox" name="denoms[]" value="{{ htmlspecialchars(json_encode($denom), ENT_QUOTES, 'UTF-8') }}">
                    </td>
                    <td class="px-4 py-2">{{ $denom['name'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $denom['price'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded">Import</button>
    </form>
    @elseif($projectid && $denoms && empty($denoms['data']))
        <div class="text-red-600 font-semibold mt-4">Tidak ada denom untuk project ID ini.</div>
    @elseif($projectid && $denoms && isset($denoms['error_msg']))
        <div class="text-red-600 font-semibold mt-4">
            Error: {{ $denoms['error_msg'] }}
        </div>
    @endif
</div>
@endsection 