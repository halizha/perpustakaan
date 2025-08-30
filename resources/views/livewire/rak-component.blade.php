<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header bg-primary text-white">Kelola Rak</div>
        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari...">
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Rak</th>
                            <th>Nama Rak</th>
                            <th>Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rak as $data)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $data->kode_rak }}</td>
                                <td>{{ $data->nama_rak }}</td>
                                <td>
                                    <a href="{{ route('rak.detail', $data->id_rak) }}" class="btn btn-success btn-sm">
                                        Detail
                                    </a>
                                    <a href="#" wire:click="edit({{ $data->id_rak }})" class="btn btn-sm btn-info"
                                        data-toggle="modal" data-target="#editPage">Ubah</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $rak->links() }}
            </div>
            <a href="#" class="btn btn-primary mt-2" data-toggle="modal" data-target="#addPage">Tambah</a>
        </div>
    </div>

    {{-- Tambah --}}
    <div wire:ignore.self class="modal fade" id="addPage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rak</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Rak</label>
                        <input type="text" class="form-control" wire:model="kode_rak">
                    </div>
                    <div class="form-group">
                        <label>Nama Rak</label>
                        <input type="text" class="form-control" wire:model="nama_rak">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="store">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit --}}
    <div wire:ignore.self class="modal fade" id="editPage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Rak</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Rak</label>
                        <input type="text" class="form-control" wire:model="kode_rak">
                    </div>
                    <div class="form-group">
                        <label>Nama Rak</label>
                        <input type="text" class="form-control" wire:model="nama_rak">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="update">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hapus --}}
    <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Rak</h5>
                </div>
                <div class="modal-body">
                    <p>Yakin hapus data?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" wire:click="destroy" data-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
