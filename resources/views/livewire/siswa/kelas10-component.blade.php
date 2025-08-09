<div>
    <div class="card">
        <div class="card-header">
            Siswa Kelas 10
        </div>

        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50 mb-3"
                placeholder="Cari nama, kelas atau email...">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>No WA</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswaKelas10 as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->nis }}</td>
                                <td>{{ $data->kelas }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->telepon }}</td>
                                <td>{{ $data->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $siswaKelas10->links() }}

            <button class="btn btn-primary " data-toggle="modal" data-target="#addSiswa">
                Tambah
            </button>
        </div>
    </div>

    {{-- Modal Tambah Siswa --}}
    <div wire:ignore.self class="modal fade" id="addSiswa" tabindex="-1" aria-labelledby="addSiswaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa Kelas 10</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" wire:model="nama" class="form-control">
                            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" wire:model="nis" class="form-control">
                            @error('nis') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" wire:model="kelas" class="form-control" value="X.">
                            @error('kelas') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea wire:model="alamat" class="form-control"></textarea>
                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>No WA</label>
                            <input type="text" wire:model="telepon" class="form-control">
                            @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" wire:model="email" class="form-control">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" wire:model="password" class="form-control">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" wire:click="store" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
