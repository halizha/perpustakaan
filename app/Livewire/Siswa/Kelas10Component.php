<?php

namespace App\Livewire\Siswa;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Kelas10Component extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama, $nis, $kelas = 'X.', $alamat, $telepon, $email, $password;
    public $cari, $id;

    public function render()
    {
        $query = User::where('status', 'disetujui')
            ->where('jenis', 'siswa')
            ->whereRaw("REPLACE(UPPER(kelas), ' ', '') LIKE 'X.%'");

        if ($this->cari != '') {
            $search = str_replace(' ', '', strtoupper($this->cari));
            $query->where(function ($q) use ($search) {
                $q->whereRaw("REPLACE(UPPER(nama), ' ', '') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("REPLACE(UPPER(email), ' ', '') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("REPLACE(UPPER(kelas), ' ', '') LIKE ?", ["%{$search}%"]);
            });
        }

        // ✅ Urutkan dulu berdasarkan kelas, lalu nama
        $query->orderByRaw("CAST(SUBSTRING_INDEX(kelas, '.', -1) AS UNSIGNED) ASC")
            ->orderBy('nama', 'asc');

        $data['siswaKelas10'] = $query->paginate(10);

        $layout['title'] = 'Siswa Kelas 10';
        return view('livewire.siswa.kelas10-component', $data)
            ->layoutData($layout);
    }


    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:users,nis',
            'kelas' => 'required|string|max:10',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        // Format kelas (hapus spasi, kapitalisasi)
        $kelasFormatted = strtoupper(str_replace(' ', '', $this->kelas));

        User::create([
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $kelasFormatted,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'status' => 'disetujui',
            'akun' => 'aktif',   // ✅ default aktif
            'jenis' => 'siswa',
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['nama', 'nis', 'kelas', 'alamat', 'telepon', 'email', 'password']);
        $this->kelas = 'X.';

        session()->flash('success', 'Siswa berhasil ditambahkan.');
        return redirect()->route('siswa.kelas10');
    }

    public function confirm($id)
    {
        $this->id = $id;
    }

    public function nonaktifkan()
    {
        $member = User::find($this->id);

        if ($member && $member->akun === 'aktif') {
            $member->akun = 'nonaktif';
            $member->save();
            session()->flash('success', 'Akun berhasil dinonaktifkan.');
        }
    }
}
