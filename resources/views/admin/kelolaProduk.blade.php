@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                <a href="{{ route('admin.produk.index') }}" 
                   class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Produk
                </a>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.produk.edit', $product->product_id) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit Produk
                </a>
                <a href="{{ route('admin.produk.account-fields', $product->product_id) }}" 
                   class="bg-cyan-600 text-white px-4 py-2 rounded hover:bg-cyan-700">
                    <i class="fas fa-list-alt mr-2"></i>Edit Struktur Form Akun
                </a>
                <form action="{{ route('admin.produk.destroy', $product->product_id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus Produk
                    </button>
                </form>
                            </div>
                        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
        @endif

        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-start space-x-6">
                <!-- Product Image -->
                <div class="flex-shrink-0">
                    @if($product->logo)
                        <img src="{{ Storage::url($product->logo) }}" 
                             alt="{{ $product->product_name }}" 
                             class="w-32 h-32 object-cover rounded-lg border">
                    @elseif($product->thumbnail_url)
                        <img src="{{ asset('image/' . $product->thumbnail_url) }}" 
                             alt="{{ $product->product_name }}" 
                             class="w-32 h-32 object-cover rounded-lg border">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->product_name }}</h1>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        @if($product->developer)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Developer:</span>
                                <span class="ml-2 text-gray-900">{{ $product->developer }}</span>
                            </div>
                        @endif
                        
                        @if($product->kategori)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Kategori:</span>
                                <span class="ml-2 text-gray-900">{{ $product->kategori->nama }}</span>
                            </div>
                        @endif
                        
                        @if($product->kode_digiflazz)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Kode Digiflazz:</span>
                                <span class="ml-2 text-gray-900">{{ $product->kode_digiflazz }}</span>
                            </div>
                        @endif
                        
                            <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            <span class="ml-2">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </span>
                    </div>
                </div>

                    @if($product->description)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500">Deskripsi:</span>
                            <p class="mt-1 text-gray-900">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Sync Digiflazz Button -->
                    @if($product->kode_digiflazz)
                        <form action="{{ route('admin.produk.sync-digiflazz', $product->product_id) }}" 
                              method="POST" 
                              class="inline-block">
                            @csrf
                            <button type="submit" 
                                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                                <i class="fas fa-sync mr-2"></i>Sync Denom dari Digiflazz
                                        </button>
                        </form>
                    @endif
                                    </div>
                                </div>
                            </div>

        <!-- Denom Management -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">Manajemen Denom</h2>
                    <button onclick="toggleDenomForm()" 
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Denom
                                        </button>
                                    </div>
                                </div>

            <!-- Add Denom Form -->
            <div id="denom-form" class="hidden p-6 border-b border-gray-200 bg-gray-50">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('admin.denom.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="nama_denom" class="block text-sm font-medium text-gray-700 mb-1">Nama Denom *</label>
                            <input type="text" 
                                   id="nama_denom" 
                                   name="nama_denom" 
                                   required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                        <div>
                            <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli *</label>
                            <input type="number" 
                                   id="harga_beli" 
                                   name="harga_beli" 
                                   required 
                                   min="0"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                        
                        <div>
                            <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual *</label>
                            <input type="number" 
                                   id="harga_jual" 
                                   name="harga_jual" 
                                   required 
                                   min="0"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                        
                        <div>
                            <label for="harga_member" class="block text-sm font-medium text-gray-700 mb-1">Harga Member *</label>
                            <input type="number" 
                                   id="harga_member" 
                                   name="harga_member" 
                                   required 
                                   min="0"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                        
                        <div>
                            <label for="profit" class="block text-sm font-medium text-gray-700 mb-1">Profit *</label>
                            <input type="number" 
                                   id="profit" 
                                   name="profit" 
                                   required 
                                   min="0"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                        
                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                            <input type="text" 
                                   id="provider" 
                                   name="provider" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                        
                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="kategori_id" name="kategori_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriDenoms as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                                    </div>
                                </div>
                    
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" 
                                onclick="toggleDenomForm()" 
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Batal
                                        </button>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Simpan Denom
                                        </button>
                                    </div>
                </form>
                            </div>

            <!-- Denom Lists -->
            <div class="p-6">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Daftar Denom</h2>
                    @foreach($kategoriDenoms as $kategori)
                        @php
                            $denoms = $product->priceLists->where('kategori_id', $kategori->id);
                        @endphp
                        @if($denoms->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                {{ $kategori->nama }} ({{ $denoms->count() }})
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border border-gray-300 rounded-lg">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Nama Denom</th>
                                            <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Beli</th>
                                            <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Jual</th>
                                            <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Member</th>
                                            <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Profit</th>
                                            <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($denoms as $denom)
                                            <tr class="even:bg-gray-50 hover:bg-blue-50">
                                                <td class="px-4 py-2 border text-sm font-medium text-gray-900 text-center whitespace-nowrap">{{ $denom->nama_produk }}</td>
                                                <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_beli ?? 0) }}</td>
                                                <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_jual ?? 0) }}</td>
                                                <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_member ?? 0) }}</td>
                                                <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->profit ?? 0) }}</td>
                                                <td class="px-4 py-2 border text-sm font-medium text-center whitespace-nowrap">
                                                    <div class="flex justify-center space-x-2">
                                                        <a href="{{ route('admin.denom.edit', $denom->id) }}" class="text-blue-600 hover:text-blue-900">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.denom.destroy', $denom->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus denom ini?')" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if($kategoriDenoms->sum(fn($k)=>$product->priceLists->where('kategori_id', $k->id)->count()) == 0)
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-coins text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada denom</h3>
                            <p class="text-gray-600 mb-4">Mulai dengan menambahkan denom pertama untuk produk ini</p>
                            <button onclick="toggleDenomForm()" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Tambah Denom Pertama
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDenomForm() {
    const form = document.getElementById('denom-form');
    form.classList.toggle('hidden');
}

// Auto-calculate profit when harga_jual or harga_beli changes
document.addEventListener('DOMContentLoaded', function() {
    const hargaBeliInput = document.getElementById('harga_beli');
    const hargaJualInput = document.getElementById('harga_jual');
    const profitInput = document.getElementById('profit');
    
    function calculateProfit() {
        const beli = parseFloat(hargaBeliInput.value) || 0;
        const jual = parseFloat(hargaJualInput.value) || 0;
        const profit = jual - beli;
        profitInput.value = profit > 0 ? profit : 0;
    }
    
    if (hargaBeliInput && hargaJualInput && profitInput) {
        hargaBeliInput.addEventListener('input', calculateProfit);
        hargaJualInput.addEventListener('input', calculateProfit);
    }
});
</script>
@endsection
