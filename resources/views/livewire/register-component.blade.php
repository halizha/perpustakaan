<div class="login-container">
    <div class="login-header">
        <img src="{{ asset('assets/login.png') }}" alt="Library Logo">
        <h2>Registrasi Akun</h2>
    </div>

    <form id="registerForm">
        {{-- NAMA --}}
        <div class="form-group">
            <input type="text" wire:model="nama" class="form-control" placeholder="Nama Lengkap">
            @error('nama')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div class="form-group">
            <input type="email" wire:model="email" class="form-control" placeholder="Email Address">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- ALAMAT --}}
        <div class="form-group">
            <input type="text" wire:model="alamat" class="form-control" placeholder="Alamat">
            @error('alamat')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- TELEPON --}}
        <div class="form-group">
            <input type="text" wire:model="telepon" class="form-control" placeholder="No WA">
            @error('telepon')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- JENIS USER --}}
        <div class="form-group">
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
            <input type="text" wire:model="nis" placeholder="NIS" class="form-control">
            @error('nis')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <input type="text" wire:model="kelas" placeholder="Kelas" class="form-control mt-3 mb-3">
            @error('kelas')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- NIP untuk Guru --}}
        <div id="teacherField" class="form-group" style="{{ $jenis == 'guru' ? '' : 'display: none;' }}">
            <input type="text" wire:model="nip" class="form-control" placeholder="NIP">
            @error('nip')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div class="form-group">
            <input type="password" wire:model="password" class="form-control" placeholder="Password">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="form-group">
            <input type="password" wire:model="password_confirmation" class="form-control"
                placeholder="Konfirmasi Password">
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- BUTTON --}}
        <button type="button" wire:click="register" class="btn btn-primary btn-block">
            Daftar
            <span wire:loading wire:target="register" class="spinner-border spinner-border-sm ml-2"></span>
        </button>
    </form>

    {{-- LINK LOGIN --}}
    <div class="text-center mt-3">
        <span class="text-muted">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></span>
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
