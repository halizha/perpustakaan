<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email, $password;
    public $errorMessage;

    public function mount()
    {
        $this->email = session('old_email', '');
    }

    public function render()
    {
        return view('livewire.login-component')->layout('components.layouts.login');
    }

    public function proses()
    {
        $credential = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!'
        ]);

        if (Auth::attempt($credential)) {
            session()->regenerate();

            $user = Auth::user();

            // Tambahan cek status
            if ($user->status == 'pending') {
                session()->flash('message', 'Akun Anda belum disetujui oleh admin. Silakan kembali lagi nanti.');
                session()->flash('old_email', $this->email);
                return redirect()->route('login');
            }

            if ($user->jenis === 'admin') {
    return redirect()->route('home');
} elseif ($user->jenis === 'siswa') {
    return redirect()->route('member.dashboard');
} elseif ($user->jenis === 'guru') {
    return redirect()->route('guru.dashboard');
} else {
    Auth::logout();
    return redirect()->route('home')->withErrors([
        'email' => 'Role tidak dikenali!',
    ]);
}

        }

        $this->errorMessage = 'Email atau password salah!';
        return back()->withErrors([
            'email' => 'Autentikasi gagal!',
        ])->onlyInput('email');
    }

    public function keluar()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
}
