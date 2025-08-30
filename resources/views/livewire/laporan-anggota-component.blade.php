<div>
    <h4 class="mb-4">Laporan Anggota</h4>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                {{-- Tanggal Mulai --}}
                <div class="col-md-2">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" wire:model.defer="tanggalMulai">
                </div>

                {{-- Tanggal Akhir --}}
                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" wire:model.defer="tanggalAkhir">
                </div>

                {{-- Status --}}
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-control" wire:model.defer="status">
                        <option value="">Semua</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                {{-- Jenis --}}
                <div class="col-md-2">
                    <label class="form-label">Jenis</label>
                    <select class="form-control" wire:model="jenis">
                        <option value="" disabled selected>Pilih Jenis</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                    </select>
                </div>

                {{-- Kelas (hanya untuk siswa) --}}
                @if ($jenis === 'siswa')
                    <div class="col-md-2">
                        <label class="form-label">Kelas</label>
                        <select class="form-control" wire:model.defer="kelas">
                            <option value="">Semua</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                @endif

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
                <span>{{ $judul }}</span>
                <button class="btn btn-primary btn-sm" wire:click="exportPdf">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </button>
            </div>

            <div class="card-body table-responsive">

                @if ($jenis === 'siswa')
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Alamat</th>
                                <th>No WA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($anggota->firstItem() - 1) }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nisn ?? '-' }}</td>
                                    <td>{{ $item->kelas ?? '-' }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->telepon }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @elseif ($jenis === 'guru')
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIP</th>
                                <th>Alamat</th>
                                <th>No WA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($anggota->firstItem() - 1) }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nip ?? '-' }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->telepon ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif

                {{ $anggota->links() }}
            </div>
        </div>
    @endif
</div>
