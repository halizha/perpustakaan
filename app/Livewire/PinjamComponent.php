<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\DetailPinjam;
use App\Models\EksemplarBuku;
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
    public $id, $user, $tgl_pinjam, $tgl_kembali, $cari, $kelas;
    public $buku = []; // awalnya string, sekarang array
    public $kodePerBuku = [];

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
            'kodePerBuku' => 'array',
        ], [
            'buku.required' => 'Pilih minimal satu buku!',
            'user.required' => 'Member wajib dipilih!',
        ]);

        // cek semua buku wajib punya eksemplar
        foreach ($this->buku as $bukuId) {
            if (empty($this->kodePerBuku[$bukuId])) {
                session()->flash('error', 'Pilih kode eksemplar untuk semua buku yang dipilih.');
                return;
            }
        }

        $this->tgl_pinjam = Carbon::now();
        $this->tgl_kembali = Carbon::now()->addDays(7);

        // simpan data pinjam utama
        $pinjam = Pinjam::create([
            'user_id'     => $this->user,
            'tgl_pinjam'  => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status'      => 'pinjam'
        ]);

        // loop langsung berdasarkan mapping buku → eksemplar
        foreach ($this->kodePerBuku as $bukuId => $eksemplarId) {
            $buku = Buku::find($bukuId);
            $eksemplar = EksemplarBuku::find($eksemplarId);

            if (!$buku || !$eksemplar) {
                continue;
            }

            if ($eksemplar->status === 'dipinjam') {
                session()->flash('error', "Eksemplar {$eksemplar->kode_eksemplar} sudah dipinjam!");
                continue;
            }

            // update status eksemplar
            $eksemplar->update(['status' => 'dipinjam']);

            // update stok buku
            $buku->jumlah = EksemplarBuku::where('buku_id', $buku->id)
                ->where('status', 'tersedia')
                ->count();
            $buku->status = $buku->jumlah > 0 ? 'tersedia' : 'habis';
            $buku->save();

            // simpan detail pinjam
            DetailPinjam::firstOrCreate([
                'pinjam_id'    => $pinjam->id,
                'buku_id'      => $bukuId,
                'eksemplar_id' => $eksemplarId,
            ], [
                'kode_eksemplar' => $eksemplar->kode_eksemplar,
                'tgl_kembali'    => $this->tgl_kembali,
            ]);
        }

        // reset form
        $this->reset(['user', 'buku', 'kelas', 'kodePerBuku', 'tgl_pinjam', 'tgl_kembali']);
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
