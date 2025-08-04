{{-- resources/views/admin/kelolaProdukList.blade.php --}}
@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    #sortableProducts .product-item {
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
    
    /* Table styles */
    .denom-table {
        border-collapse: collapse;
        width: 100%;
    }
    
    .denom-table th {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .denom-table td {
        border-bottom: 1px solid #f3f4f6;
        padding: 0.75rem 1rem;
        vertical-align: middle;
    }
    
    .denom-table tbody tr:hover {
        background-color: #f9fafb;
        transition: background-color 0.15s ease-in-out;
    }
    
    /* Custom scrollbar for table */
    .table-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .table-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Status badge improvements */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-badge.active {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .status-badge.inactive {
        background-color: #fef2f2;
        color: #991b1b;
    }
    
    /* Responsive table */
    @media (max-width: 768px) {
        .denom-table {
            font-size: 0.875rem;
        }
        
        .denom-table th,
        .denom-table td {
            padding: 0.5rem 0.75rem;
        }
    }
</style>

<div class="ml-64 bg-gray-50 min-h-screen">
    <div class="p-8">
        {{-- Header Halaman --}}
        <div class="flex items-center justify-between pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Produk</h1>
            <a href="{{ route('admin.produk.create') }}" 
               class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                <span>Tambah Produk</span>
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mt-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-600"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200 flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-red-600"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-8">
            @php
                $stats = [
                    ['icon' => 'fa-box', 'color' => 'blue', 'title' => 'Total Produk', 'value' => $products->count()],
                    ['icon' => 'fa-check-circle', 'color' => 'green', 'title' => 'Aktif', 'value' => $products->where('is_active', 1)->count()],
                    ['icon' => 'fa-star', 'color' => 'yellow', 'title' => 'Populer', 'value' => $products->where('is_popular', 1)->count()],
                    ['icon' => 'fa-tags', 'color' => 'purple', 'title' => 'Kategori Unik', 'value' => $products->unique('kategori_id')->count()],
                ];
            @endphp

            @foreach ($stats as $stat)
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600">
                        <i class="fas {{ $stat['icon'] }} text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Kontainer Daftar Produk --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">Drag & drop untuk mengurutkan</span>
                            <button id="saveOrder" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                                <i class="fas fa-save mr-1"></i>Simpan Urutan
                            </button>
                        </div>
                        <form method="GET" class="flex items-center gap-2">
                            <label for="kategori_id" class="text-sm text-gray-700">Filter Kategori:</label>
                            <select name="kategori_id" id="kategori_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @isset($kategoris)
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <label for="sort" class="text-sm text-gray-700">Urutkan:</label>
                            <select name="sort" id="sort" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                <option value="sort_order" {{ request('sort') == 'sort_order' ? 'selected' : '' }}>Urutan Kustom</option>
                                <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Populer</option>
                                <option value="aktif" {{ request('sort') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="kategori_asc" {{ request('sort') == 'kategori_asc' ? 'selected' : '' }}>Kategori A-Z</option>
                                <option value="kategori_desc" {{ request('sort') == 'kategori_desc' ? 'selected' : '' }}>Kategori Z-A</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($products->isNotEmpty())
                    <div id="sortableProducts" class="space-y-8">
                        @foreach($products as $product)
                            <div class="product-item bg-gray-50 border border-gray-200 rounded-lg shadow-sm p-6 hover:shadow-md transition-all duration-200" data-id="{{ $product->product_id }}">
                                <div class="flex items-start mb-4">
                                    <div class="mr-3 mt-1">
                                        <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
                                    </div>
                                    @if($product->thumbnail_url)
                                        <img src="{{ asset('image/'.$product->thumbnail_url) }}" alt="{{ $product->product_name }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200 mr-4 flex-shrink-0">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border mr-4 flex-shrink-0">
                                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-lg font-bold text-gray-800 truncate">{{ $product->product_name }}</h3>
                                            <div class="flex items-center space-x-2 ml-4">
                                                <a href="{{ route('admin.produk.show', $product->product_id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i>Edit Produk
                                                </a>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1.5"></i>Aktif
                                            </span>
                                            @if($product->is_popular)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star mr-1.5"></i>Populer
                                                </span>
                                            @endif
                                            @if($product->kategori)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-tag mr-1.5"></i>{{ $product->kategori->nama }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($product->developer)
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fas fa-building mr-1"></i>{{ $product->developer }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                {{-- Daftar Denom --}}
                                <div class="ml-20">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-gray-700">Daftar Denom:</h4>
                                        <span class="text-sm text-gray-500">{{ $product->priceLists->count() }} denom tersedia</span>
                                    </div>
                                    @if($product->priceLists->isNotEmpty())
                                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                            <div class="overflow-x-auto max-h-64 table-container">
                                                <table class="min-w-full divide-y divide-gray-200 denom-table">
                                                    <thead class="bg-gray-50 sticky top-0">
                                                        <tr>
                                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Denom</th>
                                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Member</th>
                                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($product->priceLists->take(10) as $denom)
                                                            <tr class="hover:bg-gray-50 transition-colors">
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        @if($denom->logo)
                                                                            <img src="{{ Storage::url($denom->logo) }}" alt="Logo" class="w-6 h-6 object-contain mr-2">
                                                                        @endif
                                                                        <div>
                                                                            <div class="text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $denom->nama_produk }}">
                                                                                {{ $denom->nama_produk }}
                                                                            </div>
                                                                            @if($denom->denom)
                                                                                <div class="text-xs text-gray-500">{{ $denom->denom }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <span class="text-sm font-semibold text-blue-600">
                                                                        Rp {{ number_format($denom->harga_jual,0,',','.') }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <span class="text-sm text-gray-600">
                                                                        Rp {{ number_format($denom->harga_member,0,',','.') }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <span class="text-xs text-gray-500">
                                                                        {{ $denom->kategoriDenom->nama ?? '-' }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    @if($denom->status === 'active')
                                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                                                            Aktif
                                                                        </span>
                                                                    @else
                                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                                                            Nonaktif
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @if($product->priceLists->count() > 10)
                                            <div class="mt-3 text-center">
                                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium" onclick="toggleDenomTable({{ $product->product_id }})">
                                                    <span id="toggle-text-{{ $product->product_id }}">Tampilkan {{ $product->priceLists->count() - 10 }} denom lainnya</span>
                                                    <i class="fas fa-chevron-down ml-1" id="toggle-icon-{{ $product->product_id }}"></i>
                                                </button>
                                                <div id="additional-denoms-{{ $product->product_id }}" class="hidden mt-3">
                                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                                        <div class="overflow-x-auto table-container">
                                                            <table class="min-w-full divide-y divide-gray-200 denom-table">
                                                                <thead class="bg-gray-50">
                                                                    <tr>
                                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Denom</th>
                                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Member</th>
                                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="bg-white divide-y divide-gray-200">
                                                                    @foreach($product->priceLists->skip(10) as $denom)
                                                                        <tr class="hover:bg-gray-50 transition-colors">
                                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                                <div class="flex items-center">
                                                                                    @if($denom->logo)
                                                                                        <img src="{{ Storage::url($denom->logo) }}" alt="Logo" class="w-6 h-6 object-contain mr-2">
                                                                                    @endif
                                                                                    <div>
                                                                                        <div class="text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $denom->nama_produk }}">
                                                                                            {{ $denom->nama_produk }}
                                                                                        </div>
                                                                                        @if($denom->denom)
                                                                                            <div class="text-xs text-gray-500">{{ $denom->denom }}</div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                                <span class="text-sm font-semibold text-blue-600">
                                                                                    Rp {{ number_format($denom->harga_jual,0,',','.') }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                                <span class="text-sm text-gray-600">
                                                                                    Rp {{ number_format($denom->harga_member,0,',','.') }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                                <span class="text-xs text-gray-500">
                                                                                    {{ $denom->kategoriDenom->nama ?? '-' }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                                @if($denom->status === 'active')
                                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                                                                        Aktif
                                                                                    </span>
                                                                                @else
                                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                                                                        Nonaktif
                                                                                    </span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                                            <i class="fas fa-box-open text-gray-400 text-2xl mb-2"></i>
                                            <p class="text-gray-500 text-sm">Belum ada denom.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-box-open fa-4x"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-500 mb-6">Mulai dengan menambahkan produk pertama Anda.</p>
                        <a href="{{ route('admin.produk.create') }}" class="inline-flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Tambah Produk</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Sortable
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        
        const sortableList = document.getElementById('sortableProducts');
        console.log('SortableList element:', sortableList);
        
        if (sortableList) {
            // Test if Sortable is available
            if (typeof Sortable === 'undefined') {
                console.error('Sortable is not loaded!');
                // Fallback to jQuery UI
                if (typeof $ !== 'undefined' && $.fn.sortable) {
                    console.log('Using jQuery UI Sortable as fallback');
                    $('#sortableProducts').sortable({
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
                
                const rows = document.querySelectorAll('#sortableProducts .product-item');
                const order = Array.from(rows).map((row, index) => ({
                    id: row.dataset.id,
                    sort_order: index + 1
                }));

                console.log('Order to save:', order);

                // Send to server
                fetch('{{ route("admin.produk.update-order") }}', {
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
                        alert('Urutan produk berhasil disimpan!');
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

    // Function to toggle additional denominations
    function toggleDenomTable(productId) {
        const additionalDenoms = document.getElementById(`additional-denoms-${productId}`);
        const toggleText = document.getElementById(`toggle-text-${productId}`);
        const toggleIcon = document.getElementById(`toggle-icon-${productId}`);
        
        if (additionalDenoms.classList.contains('hidden')) {
            additionalDenoms.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan denom';
            toggleIcon.classList.remove('fa-chevron-down');
            toggleIcon.classList.add('fa-chevron-up');
        } else {
            additionalDenoms.classList.add('hidden');
            toggleText.textContent = 'Tampilkan denom lainnya';
            toggleIcon.classList.remove('fa-chevron-up');
            toggleIcon.classList.add('fa-chevron-down');
        }
    }
</script>
@endsection