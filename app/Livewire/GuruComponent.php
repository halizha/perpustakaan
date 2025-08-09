<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Features\SupportPagination\WithoutUrlPagination;

class GuruComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';
    public $cari;

    public function render()
    {
        $query = User::where('status', 'disetujui')
            ->where('jenis', 'guru');

        if ($this->cari != '') {
            $search = str_replace(' ', '', strtoupper($this->cari));
            $query->where(function ($q) use ($search) {
                $q->whereRaw("REPLACE(UPPER(nama), ' ', '') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("REPLACE(UPPER(email), ' ', '') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("REPLACE(UPPER(nip), ' ', '') LIKE ?", ["%{$search}%"]);
            });
        }

        $data['guru'] = $query->paginate(10);

        $layout['title'] = 'Data Guru';
        return view('livewire.guru-component', $data)->layoutData($layout);
    }
}
