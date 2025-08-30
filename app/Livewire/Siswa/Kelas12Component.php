<?php

namespace App\Livewire\Siswa;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Kelas12Component extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama, $nisn, $kelas = 'XII.', $alamat, $telepon, $email, $password;
    public $cari, $id;

    public $selected = [];
    public $selectAll = false;

     public function toggleSelectAll()
    {
        $idsDiHalaman = $this->getIdsDiHalaman();

        if ($this->selectAll) {
            // kalau udah dicentang -> pilih semua di halaman ini
            $this->selected = $idsDiHalaman;
        } else {
            // kalau uncheck -> hapus semua
            $this->selected = [];
        }
    }

    private function getIdsDiHalaman()
    {
        return User::where('status', 'disetujui')
            ->where('jenis', 'siswa')
            ->whereRaw("REPLACE(UPPER(kelas), ' ', '') LIKE 'XII.%'")
            ->orderByRaw("CAST(SUBSTRING_INDEX(kelas, '.', -1) AS UNSIGNED) ASC")
            ->orderBy('nama', 'asc')
            ->paginate(15)
            ->pluck('id')
            ->toArray();
    }

    public function updatingPage()
    {
        $this->reset(['selected', 'selectAll']);
    }

    public function cetakKartu()
    {
        if (count($this->selected) == 0) {
            session()->flash('success', 'Tidak ada siswa yang dipilih.');
            return;
        }

        session()->put('cetak_ids', $this->selected);
        return redirect()->route('siswa.kartu.cetak');
    }

    public function render()
    {
        $query = User::where('status', 'disetujui')
            ->where('jenis', 'siswa')
            ->whereRaw("REPLACE(UPPER(kelas), ' ', '') LIKE 'XII.%'");

        if ($this->cari != '') {
            $search = str_replace(' ', '', strtoupper($this->cari));
            $query->where(function ($q) use ($search) {
                $q->whereRaw("REPLACE(UPPER(nama), ' ', '') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("REPLACE(UPPER(email), ' ', '') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("REPLACE(UPPER(kelas), ' ', '') LIKE ?", ["%{$search}%"]);
            });
        }

        $query->orderByRaw("CAST(SUBSTRING_INDEX(kelas, '.', -1) AS UNSIGNED) ASC")
              ->orderBy('nama', 'asc');

        $data['siswaKelas12'] = $query->paginate(15);

        $layout['title'] = 'Siswa Kelas 12';
        return view('livewire.siswa.kelas12-component', $data)
            ->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:50|unique:users,nisn',
            'kelas' => 'required|string|max:10',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $kelasFormatted = strtoupper(str_replace(' ', '', $this->kelas));

        User::create([
            'nama' => $this->nama,
            'nisn' => $this->nisn,
            'kelas' => $kelasFormatted,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'status' => 'disetujui',
            'akun' => 'aktif',
            'jenis' => 'siswa',
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['nama', 'nisn', 'kelas', 'alamat', 'telepon', 'email', 'password']);
        $this->kelas = 'XII.';

        session()->flash('success', 'Siswa berhasil ditambahkan.');
        return redirect()->route('siswa.kelas12');
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
