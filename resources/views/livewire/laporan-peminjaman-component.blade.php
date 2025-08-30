<div>
    <h4 class="mb-4">Laporan Peminjaman</h4>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" class="form-control" wire:model.defer="tanggalMulai">
                </div>
                <div class="col-md-3">
                    <label>Tanggal Akhir</label>
                    <input type="date" class="form-control" wire:model.defer="tanggalAkhir">
                </div>
                <div class="col-md-2">
                    <label>Status</label>
                    <select class="form-control" wire:model.defer="status">
                        <option value="">Semua</option>
                        <option value="aktif">Aktif</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Jenis Peminjam</label>
                    <select class="form-control" wire:model.defer="jenis">
                        <option value="">Semua</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-success w-100" wire:click="tampilkan">Tampilkan</button>
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
                <th>Nama Peminjam</th>
                <th>Kelas</th>
                <th>Jenis</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pinjam as $item)
                <tr>
                    <td>{{ $loop->iteration + ($pinjam->firstItem() - 1) }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->user->kelas }}</td>
                    <td>{{ ucfirst($item->user->jenis) }}</td>
                    <td>
                        @foreach ($item->detail as $d)
                            {{ $d->buku->judul ?? '-' }}<br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $pinjam->links() }}
</div>

        </div>
    @endif
</div>
