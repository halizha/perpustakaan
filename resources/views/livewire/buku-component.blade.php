<div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-primary text-white">
            Kelola Buku
        </div>
        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Jumlah</th>
                            <th>Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buku as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->judul }}</td>
                                <td>{{ $data->kategori->nama }}</td>
                                <td>{{ $data->penulis }}</td>
                                <td>{{ $data->penerbit }}</td>
                                <td>{{ $data->tahun }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>
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
                {{ $buku->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" wire:model="judul" value="{{ old('judul') }}">
                            @error('judul')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- SINOPSIS --}}
                        <div class="form-group">
                            <label>Sinopsis</label>
                            <textarea class="form-control" rows="4" wire:model="sinopsis">{{ old('sinopsis') }}</textarea>
                            @error('sinopsis')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select wire:model="kategori" class="form-control">
                                <option value="">--Pilih--</option>
                                @foreach ($categori as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Penulis</label>
                            <input type="text" class="form-control" wire:model="penulis"
                                value="{{ old('penulis') }}">
                            @error('penulis')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Penerbit</label>
                            <input type="text" class="form-control" wire:model="penerbit"
                                value="{{ old('penerbit') }}">
                            @error('penerbit')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" class="form-control" wire:model="isbn" value="{{ old('isbn') }}">
                            @error('isbn')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" class="form-control" wire:model="tahun" value="{{ old('tahun') }}">
                            @error('tahun')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control" wire:model="jumlah" value="{{ old('jumlah') }}">
                            @error('jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- KODE RAK --}}
                        <div class="form-group">
                            <label>Kode Rak</label>
                            <input type="text" class="form-control" wire:model="kode_rak"
                                value="{{ old('kode_rak') }}">
                            @error('kode_rak')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" wire:model="status">
                                <option value="">--Pilih--</option>
                                <option value="tersedia">Tersedia</option>
                                <option value="dipinjam">Dipinjam</option>
                            </select>
                            @error('status')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Sampul Buku</label>
                            <input type="file" class="form-control" wire:model="sampul">
                            @error('sampul')
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
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" wire:model="judul"
                                value="{{ old('judul') }}">
                            @error('judul')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- SINOPSIS --}}
                        <div class="form-group">
                            <label>Sinopsis</label>
                            <textarea class="form-control" rows="4" wire:model="sinopsis">{{ old('sinopsis') }}</textarea>
                            @error('sinopsis')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select wire:model="kategori" class="form-control">
                                <option value="">--Pilih--</option>
                                @foreach ($categori as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Penulis</label>
                            <input type="text" class="form-control" wire:model="penulis"
                                value="{{ old('penulis') }}">
                            @error('penulis')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Penerbit</label>
                            <input type="text" class="form-control" wire:model="penerbit"
                                value="{{ old('penerbit') }}">
                            @error('penerbit')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" class="form-control" wire:model="isbn"
                                value="{{ old('isbn') }}">
                            @error('isbn')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" class="form-control" wire:model="tahun"
                                value="{{ old('tahun') }}">
                            @error('tahun')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control" wire:model="jumlah"
                                value="{{ old('jumlah') }}">
                            @error('jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- KODE RAK --}}
                        <div class="form-group">
                            <label>Kode Rak</label>
                            <input type="text" class="form-control" wire:model="kode_rak"
                                value="{{ old('kode_rak') }}">
                            @error('kode_rak')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" wire:model="status">
                                <option value="">--Pilih--</option>
                                <option value="tersedia">Tersedia</option>
                                <option value="dipinjam">Dipinjam</option>
                            </select>
                            @error('status')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Sampul Buku</label>
                            <input type="file" class="form-control" wire:model="sampul">
                            @error('sampul')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click="update" class="btn btn-info">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete --}}
    <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Yakin Hapus Data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click="destroy" class="btn btn-danger"
                        data-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
