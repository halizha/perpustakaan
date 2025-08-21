<div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Peminjaman Buku
        </div>
        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th scope="col">Jumlah Buku</th> <!-- Tambahan -->
                            <th scope="col">Status</th>
                            <th>Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjam as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->user->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d-m-Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_kembali)->format('d-m-Y') }}</td>
                                <td>{{ $data->detail->count() }}</td> <!-- Tambahan -->
                                <td>{{ $data->status }}</td>
                                <td>
                                    <a href="{{ route('pinjam.detail', $data->id) }}"
                                        class="btn btn-sm btn-success">Detail</a>
                                    <a href="#" wire:click="edit({{ $data->id }})" class="btn btn-sm btn-info"
                                        data-toggle="modal" data-target="#editPage">Ubah</a>
                                    <a href="#" wire:click="confirm({{ $data->id }})"
                                        class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#deletePage">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pinjam->links() }}
            </div>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addPage">Tambah</a>
        </div>
    </div>
    {{-- Tambah --}}
    <div wire:ignore.self class="modal fade" id="addPage" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <div wire:ignore>
                                <select id="select-member" class="form-control" style="width: 100%">
                                    <option value="">--Cari Nama Anggota--</option>
                                </select>
                            </div>
                            @error('user')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Judul Buku</label>
                            <div wire:ignore>
                                <select id="select-buku" class="form-control" multiple="multiple" style="width: 100%">
                                    <option value="">--Cari Buku--</option>
                                </select>
                            </div>
                            @error('buku')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click="store" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Ubah --}}
    <div wire:ignore.self class="modal fade" id="editPage" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Peminjaman Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Judul</label>
                            <select wire:model="buku" class="form-control">
                                <option value="">--Pilih--</option>
                                @foreach ($book as $data)
                                    <option value="{{ $data->id }}">{{ $data->judul }}</option>
                                @endforeach
                            </select>
                            @error('judul')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Member</label>
                            <select wire:model="user" class="form-control">
                                <option value="">--Pilih--</option>
                                @foreach ($member as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                            @error('user')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click="update" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete --}}
    <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Peminjaman Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Yakin Hapus Data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click="destroy" class="btn btn-primary"
                        data-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Select2 Buku (sudah benar)
            $('#select-buku').select2({
                placeholder: '--Cari Buku--',
                dropdownParent: $('#addPage'), // ⬅ ini penting
                ajax: {
                    url: '{{ url('/search-buku') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on('change', function() {
                let selectedBuku = $(this).val() || [];
                @this.set('buku', selectedBuku);
            });

            $('#select-member').select2({
                placeholder: '--Cari Member--',
                dropdownParent: $('#addPage'), // ⬅ ini juga
                ajax: {
                    url: '{{ url('/search-member') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on('change', function() {
                let selectedMember = $(this).val();
                @this.set('user', selectedMember);
            });
        });
    </script>
@endpush
