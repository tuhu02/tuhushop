@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

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
                    <a href="{{ route('admin.produk.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Kembali</a>
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
                <button id="saveOrder" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Simpan Urutan</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border"></th>
                            <th class="px-4 py-2 border">Nama Denom</th>
                            <th class="px-4 py-2 border">Harga Beli</th>
                            <th class="px-4 py-2 border">Harga Jual</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortableDenoms">
                        @foreach($product->priceLists->sortBy('sort_order') as $denom)
                            <tr id="denom-row-{{ $denom->id }}" data-id="{{ $denom->id }}">
                                <td class="px-4 py-2 border text-center cursor-move"><i class="fas fa-grip-vertical"></i></td>
                                <td class="px-4 py-2 border">
                                    <span class="view-mode">{{ $denom->nama_produk }}</span>
                                    <input type="text" name="nama_produk" class="edit-mode hidden w-full" value="{{ $denom->nama_produk }}">
                                </td>
                                <td class="px-4 py-2 border">
                                    <span class="view-mode">Rp{{ number_format($denom->harga_beli) }}</span>
                                    <input type="number" name="harga_beli" class="edit-mode hidden w-full" value="{{ $denom->harga_beli }}">
                                </td>
                                <td class="px-4 py-2 border">
                                    <span class="view-mode">Rp{{ number_format($denom->harga_jual) }}</span>
                                    <input type="number" name="harga_jual" class="edit-mode hidden w-full" value="{{ $denom->harga_jual }}">
                                </td>
                                <td class="px-4 py-2 border">
                                    <span class="view-mode">{{ $denom->kategoriDenom->nama ?? '-' }}</span>
                                    <select name="kategori_id" class="edit-mode hidden w-full">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoriDenoms as $kategori)
                                            <option value="{{ $kategori->id }}" {{ $denom->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <div class="view-actions">
                                        <form action="{{ route('admin.denom.destroy', $denom->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus denom ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                    <div class="edit-actions hidden">
                                        <!-- Save/Cancel buttons are removed for autosave -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('sortableDenoms');
    let activeEditRow = null;

    // --- Enter Edit Mode on Click ---
    tableBody.addEventListener('click', function(e) {
        const target = e.target;
        const row = target.closest('tr');
        if (!row || target.closest('button, form, a, input, select')) return;

        if (activeEditRow && activeEditRow !== row) {
            toggleEditMode(activeEditRow, false); // Revert previous row
        }
        
        if (activeEditRow !== row) {
            toggleEditMode(row, true);
            activeEditRow = row;
        }
    });

    // --- Autosave on Change ---
    tableBody.addEventListener('change', function(e) {
        if (e.target.matches('.edit-mode')) {
            const row = e.target.closest('tr');
            if (row && row === activeEditRow) {
                saveDenomChanges(row);
            }
        }
    });

    // --- Cancel with Escape key ---
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape" && activeEditRow) {
            toggleEditMode(activeEditRow, false);
            activeEditRow = null;
        }
    });

    function toggleEditMode(row, isEditing) {
        if (isEditing) {
            row.querySelectorAll('.edit-mode').forEach(input => {
                input.setAttribute('data-original-value', input.value);
            });
        } else {
            row.querySelectorAll('.edit-mode').forEach(input => {
                if (input.hasAttribute('data-original-value')) {
                    input.value = input.getAttribute('data-original-value');
                }
            });
        }
        row.querySelectorAll('.view-mode, .edit-mode').forEach(el => el.classList.toggle('hidden'));
    }

    function saveDenomChanges(row) {
        const id = row.dataset.id;
        const form = new FormData();
        form.append('_method', 'PUT');
        form.append('nama_produk', row.querySelector('[name="nama_produk"]').value);
        form.append('harga_beli', row.querySelector('[name="harga_beli"]').value);
        form.append('harga_jual', row.querySelector('[name="harga_jual"]').value);
        form.append('kategori_id', row.querySelector('[name="kategori_id"]').value);

        fetch(`/admin/denom/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: form
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const denom = data.denom;
                row.querySelector('td:nth-child(2) .view-mode').textContent = denom.nama_produk;
                row.querySelector('td:nth-child(3) .view-mode').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(denom.harga_beli);
                row.querySelector('td:nth-child(4) .view-mode').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(denom.harga_jual);
                row.querySelector('td:nth-child(5) .view-mode').textContent = denom.kategori_denom ? denom.kategori_denom.nama : '-';
                
                toggleEditMode(row, false);
                activeEditRow = null;
            } else {
                alert('Gagal memperbarui: ' + (data.message || 'Error'));
                toggleEditMode(row, false); // Revert on failure
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi.');
            toggleEditMode(row, false); // Revert on failure
        });
    }

    new Sortable(tableBody, { animation: 150, handle: '.fa-grip-vertical' });
});
</script>
@endsection 