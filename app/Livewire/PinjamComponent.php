<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\DetailPinjam;
use App\Models\Pinjam;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PinjamComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $id, $user, $tgl_pinjam, $tgl_kembali, $cari;
    public $buku = []; // awalnya string, sekarang array

    public function render()
    {
        $data['member'] = User::where('jenis', 'siswa')
            ->where('akun', 'aktif') // hanya siswa dengan akun aktif
            ->get();
        $data['pinjam'] = Pinjam::with(['detail.buku', 'user'])
            ->whereHas('user', function ($q) {
                if ($this->cari) {
                    $q->where('nama', 'like', '%' . $this->cari . '%');
                }
            })
            ->paginate(10);
        $data['book'] = Buku::all();
        $layout['title'] = 'Pinjam Buku';
        return view('livewire.pinjam-component', $data)->layoutData($layout);
    }

    public function store()
    {

        $this->validate([
            'buku' => 'required|array|min:1',
            'user' => 'required',
        ], [
            'buku.required' => 'Pilih minimal satu buku!',
            'user.required' => 'Member wajib dipilih!',
        ]);

        $this->tgl_pinjam = Carbon::now();
        $this->tgl_kembali = Carbon::now()->addDays(7);

        $pinjam = Pinjam::create([
            'user_id' => $this->user,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => 'pinjam'
        ]);

        foreach ($this->buku as $bukuId) {
            $buku = Buku::find($bukuId);

            if (!$buku || $buku->jumlah < 1) {
                session()->flash('error', 'Stok buku "' . ($buku->judul ?? 'Tidak ditemukan') . '" habis!');
                continue;
            }

            $buku->decrement('jumlah');

            if ($buku->jumlah == 0) {
                $buku->status = 'dipinjam';
                $buku->save();
            }

            DetailPinjam::create([
                'pinjam_id' => $pinjam->id,
                'buku_id' => $bukuId,
            ]);
        }

        $this->reset(['user', 'buku']);
        session()->flash('success', 'Berhasil Proses Data!');
        return redirect()->route('pinjam');
    }

    public function edit($id)
    {
        $pinjam = Pinjam::find($id);
        $this->id = $pinjam->id;
        $this->user = $pinjam->user_id;
        $this->buku = $pinjam->buku_id;
        $this->tgl_kembali = $pinjam->tgl_kembali;
    }

    public function update()
    {
        $pinjam = Pinjam::find($this->id);
        $this->tgl_pinjam = date('Y-m-d');
        $this->tgl_kembali = date('Y-m-d', strtotime($this->tgl_pinjam . '+7 days'));
        $pinjam->update([
            'user_id' => $this->user,
            'buku_id' => $this->buku,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => 'pinjam'
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil Ubah!');
        return redirect()->route('pinjam');
    }

    public function confirm($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        $pinjam = Pinjam::find($this->id);
        $pinjam->delete();
        $this->reset();
        session()->flash('success', 'Berhasil Hapus!');
        return redirect()->route('pinjam');
    }
}
