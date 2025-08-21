<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <img src="{{ asset('storage/profile/' . Auth::id() . '.jpg') }}" alt="Profile"
                        class="img-thumbnail rounded-circle" style="width:120px; height:120px; object-fit:cover;">

                    <h4 class="mb-0">Profil Saya</h4>
                </div>

                <!-- Body -->
                <div class="card-body px-5 py-4">
                    <div class="row mb-3">
                        <div class="col-4 text-muted fw-bold">Nama</div>
                        <div class="col-8">{{ $user->nama }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 text-muted fw-bold">Email</div>
                        <div class="col-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 text-muted fw-bold">Status</div>
                        <div class="col-8">
                            <span class="badge bg-info text-dark">{{ ucfirst($user->jenis) }}</span>
                        </div>
                    </div>

                    @if ($user->jenis === 'guru')
                        <div class="row mb-3">
                            <div class="col-4 text-muted fw-bold">NIP</div>
                            <div class="col-8">{{ $user->nip ?? '-' }}</div>
                        </div>
                    @elseif($user->jenis === 'siswa')
                        <div class="row mb-3">
                            <div class="col-4 text-muted fw-bold">NIS</div>
                            <div class="col-8">{{ $user->nis ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-muted fw-bold">Kelas</div>
                            <div class="col-8">{{ $user->kelas ?? '-' }}</div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-4 text-muted fw-bold">Alamat</div>
                        <div class="col-8">{{ $user->alamat ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 text-muted fw-bold">No. WhatsApp</div>
                        <div class="col-8">{{ $user->telepon ?? '-' }}</div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer text-center bg-light py-3">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i data-feather="edit"></i> Edit Profil
                    </button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i data-feather="lock"></i> Ganti Password
                    </button>
                </div>

            </div>
        </div>
       <!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Edit Profil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                <!-- Foto Profil -->
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/profile/' . Auth::id() . '.jpg') }}" 
                         onerror="this.src='{{ asset('assets/default.png') }}'" 
                         class="rounded-circle mb-3"
                         style="width:100px; height:100px; object-fit:cover;">
                    
                    <input type="file" class="form-control" wire:model="foto">
                    @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" wire:model="nama">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" wire:model="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" wire:model="alamat">
                </div>
                <div class="mb-3">
                    <label class="form-label">No WhatsApp</label>
                    <input type="text" class="form-control" wire:model="telepon">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
  </div>
</div>


        <!-- Modal Ganti Password -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title">Ganti Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updatePassword">
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" wire:model="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" wire:model="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-secondary">Ganti</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => feather.replace());
</script>
