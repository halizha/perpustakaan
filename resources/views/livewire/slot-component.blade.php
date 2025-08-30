<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            Slot Rak: {{ $rak->nama_rak }}
        </div>
        <div class="card-body">
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Slot</th>
                            <th>Nama Slot</th>
                            <th>Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rak->slots as $slot)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $slot->kode_slot }}</td>
                                <td>{{ $slot->nama_slot }}</td>
                                <td>
                                    <a href="#" wire:click="edit({{ $slot->id_slot }})" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPage">Ubah</a>
                                    <a href="#" wire:click="confirm({{ $slot->id_slot }})" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletePage">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addPage">Tambah </a>
                {{--<a href="{{ route('rak') }}" class="btn btn-secondary">Kembali</a>--}}
            </div>
        </div>
    </div>

    {{-- Tambah Slot --}}
    <div wire:ignore.self class="modal fade" id="addPage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Slot</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Slot</label>
                        <input type="text" class="form-control" wire:model="kode_slot">
                    </div>
                    <div class="form-group">
                        <label>Nama Slot</label>
                        <input type="text" class="form-control" wire:model="nama_slot">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="store">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Slot --}}
    <div wire:ignore.self class="modal fade" id="editPage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Slot</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Slot</label>
                        <input type="text" class="form-control" wire:model="kode_slot">
                    </div>
                    <div class="form-group">
                        <label>Nama Slot</label>
                        <input type="text" class="form-control" wire:model="nama_slot">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="update">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hapus Slot --}}
    <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Slot</h5>
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
