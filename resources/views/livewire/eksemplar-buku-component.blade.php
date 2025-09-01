<div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            Detail Buku & Eksemplar
        </div>
        <div class="card-body">

            {{-- Informasi Buku --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    @if ($buku->sampul)
                        <img src="{{ asset('storage/' . $buku->sampul) }}" class="img-fluid rounded" alt="Sampul">
                    @else
                        <img src="https://via.placeholder.com/150x200?text=No+Image" class="img-fluid rounded"
                            alt="Sampul">
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Judul</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->judul }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Kode Buku</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->kode_buku }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Kategori</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->kategori->nama ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Penulis</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->penulis }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Penerbit</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->penerbit }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Tahun</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->tahun }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">ISBN</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->isbn }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Jumlah Eksemplar</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->eksemplars->count() }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Kode Rak</div>
                        <div class="col-auto">:</div>
                        <div class="col">
                            {{ $buku->slot->rak->kode_rak ?? '-' }} : {{ $buku->slot->rak->nama_rak ?? '-' }} -
                            {{ $buku->slot->kode_slot ?? '' }} : {{ $buku->slot->nama_slot ?? '' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-bold">Sinopsis</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{ $buku->sinopsis }}</div>
                    </div>
                </div>

            </div>

            {{-- Notifikasi --}}
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Eksemplar --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Eksemplar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buku->eksemplars as $eks)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $eks->kode_eksemplar }}</td>
                                <td>
                                    <select wire:change="updateStatus({{ $eks->id }}, $event.target.value)"
                                        class="form-control">
                                        <option value="Tersedia" {{ $eks->status == 'Tersedia' ? 'selected' : '' }}>
                                            Tersedia
                                        </option>
                                        <option value="Dipinjam" {{ $eks->status == 'Dipinjam' ? 'selected' : '' }}>
                                            Dipinjam
                                        </option>
                                        <option value="Hilang" {{ $eks->status == 'Hilang' ? 'selected' : '' }}>
                                            Hilang
                                        </option>
                                        <option value="Rusak" {{ $eks->status == 'Rusak' ? 'selected' : '' }}>
                                            Rusak
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <button wire:click="confirmDelete({{ $eks->id }})"
                                        class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada eksemplar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('buku') }}" class="btn btn-secondary mt-3">←</a>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus eksemplar ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" wire:click="deleteEksemplar" class="btn btn-danger" data-dismiss="modal">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
