<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class MemberProfileComponent extends Component
{
    use WithFileUploads;

    public $nama, $email, $alamat, $telepon, $foto;

    public function mount()
    {
        $user = Auth::user();
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->alamat = $user->alamat;
        $this->telepon = $user->telepon;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data user
        $user->update([
            'nama' => $this->nama,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
        ]);

        // Simpan foto kalau ada upload baru
        if ($this->foto) {
            $this->foto->storeAs('public/profile', $user->id . '.jpg');
        }

        session()->flash('success', 'Berhasil Edit Profile!');
        return redirect()->route('member.profile');
    }

    public function render()
    {
        $x['title'] = "Profil Saya";

        return view('livewire.member-profile-component', [
            'user' => Auth::user(),
        ])->layoutData($x);
    }
}
