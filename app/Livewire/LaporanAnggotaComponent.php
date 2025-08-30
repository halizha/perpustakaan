<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User; // asumsinya tabel anggota pakai model User
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanAnggotaComponent extends Component
{
    use WithPagination;

    public $status = '';
    public $jenis = '';
    public $kelas = '';
    public $showTable = false;
    public $judul = 'Laporan Anggota';
    public $tanggalMulai;
    public $tanggalAkhir;


    protected $paginationTheme = 'bootstrap';

    public function tampilkan()
    {
        $this->showTable = true;

        // Mulai bikin judul
        $judul = 'Laporan Anggota';

        // Tambahkan status
        if ($this->status) {
            $judul .= ' ' . ucfirst($this->status); // misal: Aktif / Nonaktif
        }

        // Tambahkan jenis dan kelas dalam tanda kurung
        $detail = [];

        if ($this->jenis) {
            $detail[] = ucfirst($this->jenis);
        }

        if ($this->jenis === 'siswa' && $this->kelas) {
            $detail[] = 'Kelas ' . strtoupper($this->kelas);
        }

        if (!empty($detail)) {
            $judul .= ' (' . implode(' ', $detail) . ')';
        }

        $this->judul = $judul;
    }

    public function render()
    {
        $query = User::query();

        // filter akun
        if ($this->status) {
            $query->where('akun', $this->status);
        }

        // filter jenis
        if ($this->jenis) {
            $query->where('jenis', $this->jenis);
        }

        // filter kelas (kalau siswa)
        if ($this->jenis === 'siswa' && $this->kelas) {
            $query->where('kelas', 'like', $this->kelas . '%');
        }


        $anggota = $this->showTable
            ? $query->paginate(10)
            : collect();

        return view('livewire.laporan-anggota-component', [
            'anggota' => $anggota,
        ]);
    }


    public function exportPdf()
    {
        // Locale Indonesia
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');
        mb_internal_encoding("UTF-8");
        
        $query = User::query();

        if ($this->status) {
            $query->where('akun', $this->status);
        }

        if ($this->jenis) {
            $query->where('jenis', $this->jenis);
        }

        if ($this->jenis === 'siswa' && $this->kelas) {
            $query->where('kelas', 'like', $this->kelas . '%');
        }

        $anggota = $query->get();

        $pdf = Pdf::loadView('pdf.laporan-anggota', [
            'anggota' => $anggota,
            'jenis' => $this->jenis,
            'judul' => $this->judul,
            'tanggalMulai' => $this->tanggalMulai,
            'tanggalAkhir' => $this->tanggalAkhir,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'laporan-anggota.pdf'
        );
    }
}
