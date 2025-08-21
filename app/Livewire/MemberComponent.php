<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class MemberComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama, $telepon, $email, $alamat, $password, $cari, $id, $status, $nis, $nip, $kelas, $jenis;

    public function render()
    {
        $query = User::whereIn('jenis', ['siswa', 'guru']);

        if ($this->cari != '') {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->cari . '%')
                    ->orWhere('email', 'like', '%' . $this->cari . '%');
            });
        }

        $data['pending'] = (clone $query)->where('status', 'pending')->paginate(10, ['*'], 'pending');
        $data['disetujui'] = (clone $query)->where('status', 'disetujui')->paginate(10, ['*'], 'disetujui');

        $layout['title'] = 'Kelola Member';
        return view('livewire.member-component', $data)->layoutData($layout);
    }

    public function validasi($id)
    {
        $user = User::find($id);

        if ($user && $user->status === 'pending') {
            $user->status = 'disetujui';
            $user->save();

            session()->flash('success', 'Akun berhasil divalidasi.');
        } else {
            session()->flash('error', 'Akun tidak ditemukan atau sudah divalidasi.');
        }
    }

    public function tolak($id)
    {
        $user = User::find($id);

        if ($user && $user->status === 'pending') {
            $user->status = 'ditolak';
            $user->save();
            $user->delete(); // soft delete
            session()->flash('success', 'Akun berhasil ditolak dan dihapus.');
        } else {
            session()->flash('error', 'Akun tidak valid atau sudah diproses.');
        }
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'email' => 'required'
        ], [
            'nama.required' => 'Nama Lengkap Tidak Boleh Kosong!',
            'nis.required' => 'NIS Tidak Boleh Kosong!',
            'kelas.required' => 'Kelas Tidak Boleh Kosong!',
            'telepon.required' => 'Telepon Tidak Boleh Kosong!',
            'alamat.required' => 'Alamat Tidak Boleh Kosong!',
            'email.required' => 'Email Tidak Boleh Kosong!',
        ]);

        User::create([
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'jenis' => $this->jenis,
            'status' => 'disetujui',
            'akun' => 'aktif', // default aktif
        ]);

        session()->flash('success', 'Berhasil Simpan!');
        return redirect()->route('member');
    }

    public function edit($id)
    {
        $member = User::find($id);
        $this->id = $member->id;
        $this->nama = $member->nama;
        $this->nis = $member->nis;
        $this->nip = $member->nip;
        $this->kelas = $member->kelas;
        $this->alamat = $member->alamat;
        $this->telepon = $member->telepon;
        $this->email = $member->email;
        $this->jenis = $member->jenis;
    }

    public function update()
    {
        $member = User::find($this->id);
        $member->update([
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'jenis' => $this->jenis
        ]);

        session()->flash('success', 'Berhasil Ubah!');
        return redirect()->route('member');
    }

    // ✅ simpan ID untuk konfirmasi nonaktifkan
    public function confirm($id)
    {
        $this->id = $id;
    }

    // ✅ method nonaktifkan akun
    public function nonaktifkan()
    {
        $member = User::find($this->id);

        if ($member && $member->akun === 'aktif') {
            $member->akun = 'nonaktif';
            $member->save();
            session()->flash('success', 'Akun berhasil dinonaktifkan.');
        } else {
            session()->flash('error', 'Akun tidak valid atau sudah nonaktif.');
        }
    }
}
