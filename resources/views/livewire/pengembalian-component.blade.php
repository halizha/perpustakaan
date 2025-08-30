<div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        @if ($pinjam->count())
            <div class="card-header bg-primary text-white">
                Data Peminjaman Buku
            </div>
            <div class="card-body">
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
                                @if ($detail->pinjam && $detail->pinjam->user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->pinjam->user->nama }}</td>
                                        <td>{{ $detail->buku->judul ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($detail->pinjam->tgl_pinjam)->format('d-m-Y H:i') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($detail->pinjam->tgl_kembali)->format('d-m-Y') }}
                                        </td>

                                        <td>
                                            <a href="#" wire:click="pilih({{ $detail->id }})"
                                                class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#pilih">Pengembalian</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pinjam->links() }}
                </div>
            </div>
        @endif
    </div>


    <div class="card">
        <div class="card-header bg-primary text-white">
            Daftar Buku Dikembalikan
        </div>
        <div class="card-body">
            <input type="text" wire:model.live="cariPengembalian" class="form-control w-50"
                placeholder="Cari Nama Pengembalian...">
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
                                <td>{{ $data->pinjam?->user?->nama ?? '_' }}</td>
                                <td>{{ $data->detail?->buku?->judul ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->pinjam?->tgl_pinjam)->format('d-m-Y H:i') ?? '-' }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_kembali)->format('d-m-Y') ?? '-' }}</td>
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
                            : {{ \Carbon\Carbon::parse($tgl_kembali)->format('d-m-Y') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            Tanggal Dikembalikan
                        </div>
                        <div class="col-md-8">
                            : {{ \Carbon\Carbon::now()->format('d-m-Y') }}
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
                            : {{ $status * 500 }}
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
