<div class="card">
    <div class="card-body">
        <h2 class="card-title">Halo, {{ Auth::user()->nama }}</h2>
        <p class="card-text">Selamat datang di dashboard siswa.</p>
    </div>
</div>

    {{-- @include('components.layouts.member') --}}

    {{-- Statistik Singkat 
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Sedang Dipinjam</h6>
                    <p class="fs-4 fw-bold text-primary">{{ $pinjamAktif ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Riwayat Pinjam</h6>
                    <p class="fs-4 fw-bold text-success">{{ $totalPinjam ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Denda</h6>
                    <p class="fs-4 fw-bold text-danger">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>--}}

    {{-- Daftar Pinjaman Aktif 
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Pinjaman Aktif</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pinjamanAktif ?? [] as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pinjam->buku->judul ?? '-' }}
                            </td>
                            <td>{{ $item->tgl_pinjam }}</td>
                            <td>{{ $item->tgl_kembali }}</td>
                            <td>
                                @if (now()->gt($item->tgl_kembali))
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada pinjaman aktif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>--}}

    {{-- Rekomendasi Buku 
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">Rekomendasi Buku</div>
        <div class="card-body">
            <div class="row">
                @foreach ($rekomendasi ?? [] as $buku)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $buku->sampul ? asset('storage/' . $buku->sampul) : asset('default.png') }}"
                                class="card-img-top" alt="Sampul Buku">
                            <div class="card-body">
                                <h6 class="card-title">{{ $buku->judul }}</h6>
                                <a href="{{ route('member.buku.detail', $buku->id) }}" class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>--}}

