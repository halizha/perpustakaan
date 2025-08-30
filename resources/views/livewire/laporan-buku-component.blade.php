<div>
    <h4 class="mb-4">Laporan Buku</h4>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" wire:model.defer="tanggalMulai">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" wire:model.defer="tanggalAkhir">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Kategori</label>
                    <select class="form-control" wire:model.defer="kategori">
                        <option value="">Semua</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-control" wire:model.defer="status">
                        <option value="">-- Pilih Status --</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="hilang">Hilang</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button class="btn btn-success" wire:click="tampilkan">Tampilkan</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Tabel Data --}}
    @if ($showTable)
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>{{ $this->judul }}</span>
                <button class="btn btn-primary btn-sm" wire:click="exportPdf">
                    Export PDF
                </button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buku as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($buku->firstItem() - 1) }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->kategori->nama ?? '-' }}</td>
                                <td>{{ ucfirst($item->status) }}</td>
                                <td>{{ $item->jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $buku->links() }}
            </div>
        </div>
    @endif
</div>
