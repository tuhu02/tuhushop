@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Import Denom dari Apigames</h1>
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
</div>
@endsection 