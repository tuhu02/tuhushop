@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    #sortableDenoms tr {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    .fa-grip-vertical {
        cursor: grab !important;
        color: #6b7280 !important;
        font-size: 16px !important;
        padding: 4px !important;
        border-radius: 4px !important;
        transition: all 0.2s !important;
    }
    .fa-grip-vertical:hover {
        background-color: #e5e7eb !important;
        color: #374151 !important;
    }
    .fa-grip-vertical:active {
        cursor: grabbing !important;
        background-color: #d1d5db !important;
    }
    .sortable-ghost {
        opacity: 0.5;
        background-color: #dbeafe !important;
    }
    .sortable-chosen {
        background-color: #bfdbfe !important;
    }
    .sortable-drag {
        background-color: #93c5fd !important;
        transform: rotate(5deg);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .sortable-fallback {
        background-color: #fef3c7 !important;
        border: 2px dashed #f59e0b !important;
    }
</style>

<div class="ml-64 p-4">
    <div class="bg-white rounded-lg shadow p-4">
        <h1 class="text-2xl font-bold mb-4">Detail Produk</h1>
        <div class="flex items-start space-x-6">
            <div>
                <img src="{{ asset('image/' . $product->thumbnail_url) }}" alt="{{ $product->product_name }}" class="w-32 h-32 object-cover rounded-lg border">
            </div>
            <div>
                <h2 class="text-xl font-semibold">{{ $product->product_name }}</h2>
                <p class="text-gray-600 mb-2">Developer: {{ $product->developer }}</p>
                <p class="text-gray-600 mb-2">Kategori: {{ $product->kategori->nama ?? '-' }}</p>
                <p class="text-gray-600 mb-2">Deskripsi: {{ $product->description ?? '-' }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.produk.edit', $product->product_id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mr-2">Edit</a>
                    <a href="{{ route('admin.kelolaProduk') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Tambah Denom -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold mb-4">Tambah Denom</h2>
        <form action="{{ route('admin.denom.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Denom *</label>
                    <input type="text" id="nama_produk" name="nama_produk" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                    <input type="number" id="harga" name="harga" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="harga_member" class="block text-sm font-medium text-gray-700 mb-1">Harga Member</label>
                    <input type="number" id="harga_member" name="harga_member" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="profit" class="block text-sm font-medium text-gray-700 mb-1">Profit</label>
                    <input type="number" id="profit" name="profit" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                    <select id="provider" name="provider" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="Digiflazz">Digiflazz</option>
                        <option value="DuniaGames">DuniaGames</option>
                        <option value="Unipin">Unipin</option>
                    </select>
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="kategori" name="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="diamond">Diamond</option>
                        <option value="nondiamond">Non Diamond</option>
                    </select>
                </div>
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Denom</label>
                    <input type="file" id="logo" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Tambah Denom</button>
            </div>
        </form>
    </div>
    
    <!-- Tabel Daftar Denom -->
    @if($product->priceLists->count())
        <div class="bg-white rounded-lg shadow p-4 mt-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Daftar Denom</h2>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">Drag & drop untuk mengurutkan</span>
                    <button id="saveOrder" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        <i class="fas fa-save mr-1"></i>Simpan Urutan
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center w-12">
                            <i class="fas fa-grip-vertical text-gray-400"></i>
                        </th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Logo</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Nama Denom</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Beli</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Jual</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Member</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Kategori</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Provider</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortableDenoms" class="bg-white divide-y divide-gray-200">
                    @foreach($product->priceLists->sortBy('sort_order') as $denom)
                        <tr class="even:bg-gray-50 hover:bg-blue-50 cursor-move" data-id="{{ $denom->id }}">
                            <td class="px-4 py-2 border text-sm text-center">
                                <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
                            </td>
                            <td class="px-4 py-2 border text-sm text-center">
                                @if($denom->logo)
                                    <img src="{{ Storage::url($denom->logo) }}" alt="Logo" class="h-8 mx-auto">
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-sm font-medium text-gray-900 text-center whitespace-nowrap">{{ $denom->nama_produk }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_beli) }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_jual) }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_member) }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">{{ $denom->kategoriDenom->nama ?? '-' }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">{{ $denom->provider }}</td>
                            <td class="px-4 py-2 border text-sm font-medium text-center whitespace-nowrap">
                                <a href="javascript:void(0);" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.denom.destroy', $denom->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus denom ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-4 mt-4">
            <p class="text-gray-500">Belum ada denom untuk produk ini.</p>
        </div>
    @endif
</div>

<script>
    // Initialize Sortable
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        
        const sortableList = document.getElementById('sortableDenoms');
        console.log('SortableList element:', sortableList);
        
        if (sortableList) {
            // Test if Sortable is available
            if (typeof Sortable === 'undefined') {
                console.error('Sortable is not loaded!');
                // Fallback to jQuery UI
                if (typeof $ !== 'undefined' && $.fn.sortable) {
                    console.log('Using jQuery UI Sortable as fallback');
                    $('#sortableDenoms').sortable({
                        handle: '.fa-grip-vertical',
                        axis: 'y',
                        opacity: 0.6,
                        cursor: 'move',
                        start: function(event, ui) {
                            console.log('jQuery UI drag started');
                        },
                        stop: function(event, ui) {
                            console.log('jQuery UI drag stopped');
                        }
                    });
                }
                return;
            }
            
            console.log('Creating Sortable instance...');
            
            const sortable = new Sortable(sortableList, {
                animation: 150,
                handle: '.fa-grip-vertical',
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                delay: 100,
                delayOnTouchOnly: false,
                preventOnFilter: false,
                forceFallback: true,
                fallbackClass: 'sortable-fallback',
                onStart: function(evt) {
                    console.log('Drag started on item:', evt.item);
                    evt.item.style.userSelect = 'none';
                },
                onMove: function(evt) {
                    console.log('Drag moving');
                    return true;
                },
                onEnd: function(evt) {
                    console.log('Drag ended');
                    evt.item.style.userSelect = '';
                }
            });
            
            console.log('Sortable instance created:', sortable);
            
            // Test if handle elements exist
            const handles = document.querySelectorAll('.fa-grip-vertical');
            console.log('Found', handles.length, 'drag handles');
            
            handles.forEach((handle, index) => {
                console.log('Handle', index, ':', handle);
                handle.style.cursor = 'grab';
                
                // Add click event to test if handle is clickable
                handle.addEventListener('click', function(e) {
                    console.log('Handle clicked:', e.target);
                });
            });
            
        } else {
            console.error('SortableList element not found');
        }

        // Save order button
        const saveButton = document.getElementById('saveOrder');
        if (saveButton) {
            saveButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Save button clicked');
                
                const rows = document.querySelectorAll('#sortableDenoms tr');
                const order = Array.from(rows).map((row, index) => ({
                    id: row.dataset.id,
                    sort_order: index + 1
                }));

                console.log('Order to save:', order);

                // Send to server
                fetch('{{ route("admin.denom.updateOrder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Urutan berhasil disimpan!');
                    } else {
                        alert('Gagal menyimpan urutan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan urutan');
                });
            });
        }

        // Prevent text selection on drag handle
        document.querySelectorAll('.fa-grip-vertical').forEach(handle => {
            handle.addEventListener('mousedown', function(e) {
                console.log('Handle mousedown');
                e.preventDefault();
                e.stopPropagation();
            });
            
            handle.addEventListener('click', function(e) {
                console.log('Handle click');
                e.preventDefault();
                e.stopPropagation();
            });
        });
    });
</script>
@endsection 