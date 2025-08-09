<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterComponent extends Component
{
    public $nama, $email, $alamat, $telepon, $password, $password_confirmation;
    public $jenis;
    public $nis, $nip, $kelas;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'alamat' => 'required|string|min:5',
        'telepon' => [
            'required',
            'regex:/^08[0-9]{10,11}$/'
        ],
        'password' => 'required|min:6|same:password_confirmation',
        'password_confirmation' => 'required',
        'jenis' => 'required',
        'nis' => 'required_if:jenis,siswa',
        'kelas' => 'required_if:jenis,siswa',
        'nip' => 'required_if:jenis,guru',
    ];

    protected $messages = [
        'nama.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.min' => 'Alamat terlalu pendek.',
        'telepon.required' => 'Nomor WhatsApp wajib diisi.',
        'telepon.regex' => 'Nomor WA harus diawali 08 dan terdiri dari 12–13 digit angka.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.same' => 'Password dan konfirmasi harus sama.',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        'jenis.required' => 'Jenis wajib dipilih.',
        'nis.required' => 'NIS wajib diisi.',
        'kelas.required' => 'Kelas wajib diisi.',
        'nip.required' => 'NIP wajib diisi.',
    ];

    // ⬅️ DITAMBAHKAN
    protected $validationAttributes = [
        'nama' => 'Nama',
        'email' => 'Email',
        'alamat' => 'Alamat',
        'telepon' => 'Nomor WhatsApp',
        'password' => 'Password',
        'password_confirmation' => 'Konfirmasi Password',
        'jenis' => 'Jenis',
        'nis' => 'NIS',
        'kelas' => 'Kelas',
        'nip' => 'NIP',
    ];

    public function register()
    {
        $this->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'alamat' => 'required|string|min:5',
        'telepon' => [
            'required',
            'regex:/^08[0-9]{10,11}$/'
        ],
        'password' => 'required|min:6|same:password_confirmation',
        'password_confirmation' => 'required',
        'jenis' => 'required',
        'nis' => 'required_if:jenis,siswa|max:5',
        'nip' => 'required_if:jenis,guru',
        'kelas' => 'required_if:jenis,siswa',
    ], [
        'nama.required' => 'Nama Lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.min' => 'Alamat terlalu pendek.',
        'telepon.required' => 'Nomor WhatsApp wajib diisi.',
        'telepon.regex' => 'Nomor WA harus diawali 08 dan terdiri dari 12–13 digit angka.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.same' => 'Password dan konfirmasi harus sama.',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        'jenis.required' => 'Silahkan pilih status.',
        'nis.required_if' => 'NIS wajib diisi untuk siswa.',
        'nip.required_if' => 'NIP wajib diisi untuk guru.',
        'kelas.required_if' => 'Kelas wajib diisi untuk siswa.',
    ]);

        User::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'password' => Hash::make($this->password),
            'jenis' => $this->jenis,
            'status' => 'pending',
            'nis' => $this->jenis === 'siswa' ? $this->nis : null,
            'kelas' => $this->jenis === 'siswa' ? $this->kelas : null,
            'nip' => $this->jenis === 'guru' ? $this->nip : null,
        ]);

        session()->flash('success', 'Registrasi berhasil! Tunggu validasi dari admin.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.register-component')->layout('components.layouts.auth');
    }
}
