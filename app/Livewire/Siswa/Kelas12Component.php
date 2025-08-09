<?php

namespace App\Livewire\Siswa;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Kelas12Component extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cari;

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

        $data['siswaKelas12'] = $query->paginate(10);

        $layout['title'] = 'Siswa Kelas 12';
        return view('livewire.siswa.kelas12-component', $data)
            ->layoutData($layout);
    }
}
