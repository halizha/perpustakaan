<div>
    <div class="card">
        
            @if ($pinjam->count())
        <div class="card-header">
            Data Peminjaman Buku
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th>Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjam as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->pinjam->user->nama }}</td>
                                <td>{{ $detail->buku->judul ?? '-' }}</td>
                                <td>{{ $detail->pinjam->tgl_pinjam }}</td>
                                <td>{{ $detail->pinjam->tgl_kembali }}</td>
                                <td>
                                    <a href="#" wire:click="pilih({{ $detail->id }})"
                                        class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#pilih">Pengembalian</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pinjam->links() }}
            </div>
        </div>
        @endif
    </div>
    

    <div class="card">
        <div class="card-header">
            Daftar Buku Dikembalikan
        </div>
        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th scope="col">Denda</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = ($pengembalian->currentPage() - 1) * $pengembalian->perPage() + 1;
                        @endphp

                        @foreach ($pengembalian as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->pinjam->user->nama ?? '-' }}</td>
                                <td>{{ $data->detail->buku->judul ?? '-' }}</td>
                                <td>{{ $data->pinjam->tgl_pinjam ?? '-' }}</td>
                                <td>{{ $data->tgl_kembali ?? '-' }}</td>
                                <td>{{ $data->denda ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pengembalian->links() }}
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="pilih" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pengembalian Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Judul Buku
                        </div>
                        <div class="col-md-8">
                            : {{ $judul }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Nama Lengkap
                        </div>
                        <div class="col-md-8">
                            : {{ $member }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Tanggal Kembali
                        </div>
                        <div class="col-md-8">
                            : {{ $tgl_kembali }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Tanggal Dikembalikan
                        </div>
                        <div class="col-md-8">
                            : {{ date('Y-m-d') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Denda
                        </div>
                        <div class="col-md-8">
                            : @if ($this->status == true)
                                Ya
                            @else
                                Tidak
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Lama Terlambat
                        </div>
                        <div class="col-md-8">
                            : {{ $lama }} Hari
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Jumlah Denda
                        </div>
                        <div class="col-md-8">
                            : {{ $status * 1000 }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click="store" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
