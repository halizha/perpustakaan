<div class="card">
    <div class="card-header bg-primary text-white">
         Riwayat Peminjaman
    </div>

    <div class="card-body">
        {{-- optional: kalau mau pakai pencarian --}}
        {{-- <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari..."> --}}

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead >
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = ($riwayat->currentPage() - 1) * $riwayat->perPage() + 1; @endphp
                    @forelse ($riwayat as $pinjam)
                        @foreach ($pinjam->detail as $detail)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $detail->buku->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</td>
                                <td>
                                    {{ $pinjam->tgl_kembali 
                                        ? \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') 
                                        : '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $pinjam->status == 'pinjam' ? 'warning text-dark' : 'success' }}">
                                        {{ ucfirst($pinjam->status) }}
                                    </span>
                                </td>
                                <td class="{{ $pinjam->denda > 0 ? 'text-danger fw-bold' : '' }}">
                                    Rp{{ number_format($pinjam->denda, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $riwayat->links() }}
        </div>
    </div>
</div>
