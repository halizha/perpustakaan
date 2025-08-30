<div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card mb-4">
        @if ($pending->count())
            <div class="card-header bg-primary text-white">
                Member Pending
            </div>
            <div class="card-body">
                <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari...">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>NIP</th>
                                <th>Alamat</th>
                                <th>No WA</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->nisn }}</td>
                                    <td>{{ $data->kelas }}</td>
                                    <td>{{ $data->nip }}</td>
                                    <td>{{ $data->alamat }}</td>
                                    <td>{{ $data->telepon }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->jenis }}</td>
                                    <td>
                                        <button wire:click="validasi({{ $data->id }})"
                                            class="btn btn-sm btn-success">Validasi</button>
                                        <button class="btn btn-danger btn-sm" wire:click="tolak({{ $data->id }})"
                                            onclick="return confirm('Yakin ingin menolak akun ini?')">Tolak</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pending->links() }}
                </div>
            </div>
        @endif
    </div>

   <div class="card">
    <div class="card-header bg-primary text-white">
        Member Disetujui
    </div>
    <div class="card-body">
        

        <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari...">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>No WA</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Akun</th>
                        <th>Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($disetujui as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->telepon }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->jenis }}</td>
                            <td>
                                @if($data->akun === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                @if($data->akun === 'aktif')
                                    <a href="#" wire:click="confirm({{ $data->id }})"
                                        class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#confirmNonaktif">Nonaktifkan</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $disetujui->links() }}
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addPage">Tambah</a>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Nonaktifkan -->
<div wire:ignore.self class="modal fade" id="confirmNonaktif" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin untuk menonaktifkan akun ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" wire:click="nonaktifkan" class="btn btn-warning" data-dismiss="modal">
                    Ya, Nonaktifkan
                </button>
            </div>
        </div>
    </div>
</div>



    {{-- Tambah --}}
    <div wire:ignore.self class="modal fade" id="addPage" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" wire:model="nama">
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis">Status</label>
                            <select wire:model="jenis" id="jenis" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                            </select>
                            @error('jenis')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIS & KELAS untuk Siswa --}}
                        <div id="studentFields" style="{{ $jenis == 'siswa' ? '' : 'display: none;' }}">
                            <label>NISN</label>
                            <input type="text" wire:model="nisn" class="form-control">
                            @error('nisn')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror

                            <label class="mt-3">Kelas</label>
                            <input type="text" wire:model="kelas" class="form-control mb-3">
                            @error('kelas')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIP untuk Guru --}}
                        <div id="teacherField" class="form-group"
                            style="{{ $jenis == 'guru' ? '' : 'display: none;' }}">
                            <label>NIP</label>
                            <input type="text" wire:model="nip" class="form-control">
                            @error('nip')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>No WA</label>
                            <input type="text" class="form-control" wire:model="telepon">
                            @error('telepon')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea wire:model="alamat" class="form-control" cols="30" rows="2"></textarea>
                            @error('alamat')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" wire:model="email">
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" wire:model="password">
                            @error('password')
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
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model="nama"
                                value="{{ @old('nama') }}">
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" class="form-control" wire:model="nisn"
                                value="{{ @old('nisn') }}">
                            @error('nisn')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" class="form-control" wire:model="kelas"
                                value="{{ @old('kelas') }}">
                            @error('kelas')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No WA</label>
                            <input type="text" class="form-control" wire:model="telepon"
                                value="{{ @old('telepon') }}">
                            @error('telepon')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea wire:model="alamat" class="form-control" cols="30" rows="2">{{ @old('alamat') }}</textarea>
                            @error('alamat')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" wire:model="email"
                                value="{{ @old('email') }}">
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" wire:model="jenis"
                                value="{{ @old('jenis') }}">
                            @error('jenis')
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
                    <h5 class="modal-title" id="exampleModalLabel">Hapus User</h5>
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

<script>
    document.getElementById('jenis').addEventListener('change', function() {
        const studentFields = document.getElementById('studentFields');
        const teacherField = document.getElementById('teacherField');

        if (this.value === 'siswa') {
            studentFields.style.display = 'block';
            teacherField.style.display = 'none';
        } else if (this.value === 'guru') {
            studentFields.style.display = 'none';
            teacherField.style.display = 'block';
        } else {
            studentFields.style.display = 'none';
            teacherField.style.display = 'none';
        }
    });
</script>
