<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class GuruComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama, $nip, $alamat, $telepon, $email, $password;
    public $cari, $id;
    public $selected = [];     // id guru yang dipilih
    public $selectAll = false; // checkbox pilih semua

    public function render()
    {
        $query = User::where('status', 'disetujui')
            ->where('jenis', 'guru');

        if ($this->cari != '') {
            $search = str_replace(' ', '', strtoupper($this->cari));
            $query->where(function ($q) use ($search) {
                $q->whereRaw("REPLACE(UPPER(nama), ' ', '') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("REPLACE(UPPER(email), ' ', '') LIKE ?", ["%{$search}%"]);
            });
        }

        // ✅ Urutkan langsung berdasarkan nama A–Z
        $query->orderBy('nama', 'asc');

        $data['guru'] = $query->paginate(10);

        $layout['title'] = 'Data Guru';
        return view('livewire.guru-component', $data)
            ->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        User::create([
            'nama' => $this->nama,
            'nip' => $this->nip,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'status' => 'disetujui',
            'akun' => 'aktif',   // ✅ default aktif
            'jenis' => 'guru',
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['nama', 'nip', 'alamat', 'telepon', 'email', 'password']);

        session()->flash('success', 'Guru berhasil ditambahkan.');
        return redirect()->route('guru');
    }

    public function confirm($id)
    {
        $this->id = $id;
    }

    public function nonaktifkan()
    {
        $guru = User::find($this->id);

        if ($guru && $guru->akun === 'aktif') {
            $guru->akun = 'nonaktif';
            $guru->save();
            session()->flash('success', 'Akun guru berhasil dinonaktifkan.');
        }
    }

    public function cetakKartu()
{
    if (count($this->selected) == 0) {
        session()->flash('error', 'Tidak ada guru yang dipilih.');
        return;
    }

    session()->put('cetak_ids', $this->selected);
    return redirect()->route('guru.kartu.cetak'); // pastikan route ini ada
}


    public function toggleSelectAll()
    {
        $idsDiHalaman = $this->getIdsDiHalaman();

        if ($this->selectAll) {
            // kalau dicentang -> pilih semua id guru di halaman ini
            $this->selected = $idsDiHalaman;
        } else {
            // kalau di-uncheck -> kosongkan
            $this->selected = [];
        }
    }

    private function getIdsDiHalaman()
    {
        return User::where('status', 'disetujui')
            ->where('jenis', 'guru')
            ->orderBy('nama', 'asc')
            ->paginate(10) // sesuai jumlah per halaman guru
            ->pluck('id')
            ->toArray();
    }

    public function updatingPage()
    {
        $this->reset(['selected', 'selectAll']);
    }
}
