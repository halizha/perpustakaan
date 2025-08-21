<div>
    <h4 class="mb-4">Laporan Buku</h4>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Kategori</label>
                    <select class="form-control" wire:model="kategori">
                        <option value="">Semua</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Status</label>
                    <select class="form-control" wire:model="status">
                        <option value="">Semua</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="hilang">Hilang</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100" wire:click="exportPdf">Export PDF</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Jumlah Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($buku as $item)
                        <tr>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->kategori->nama }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>{{ $item->jumlah_dipinjam }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $buku->links() }}
        </div>
    </div>
</div>
