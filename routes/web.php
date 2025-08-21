<?php

use App\Http\Controllers\SearchController;
use App\Livewire\RiwayatComponent;
use App\Livewire\AdminComponent;
use App\Livewire\BukuComponent;
use App\Livewire\DetailPinjamComponent;
use App\Livewire\Frontend\BukuByKategori;
use App\Livewire\Frontend\BukuDetail;
use App\Livewire\GuruComponent;
use App\Livewire\GuruDashboard;
use App\Livewire\HomeComponent;
use App\Livewire\KategoriComponent;
use App\Livewire\LaporanBukuComponent;
use App\Livewire\LaporanPeminjamanComponent;
use App\Livewire\LoginComponent;
use App\Livewire\MemberBukuComponent;
use App\Livewire\MemberBukuDetailComponent;
use App\Livewire\MemberComponent;
use App\Livewire\MemberDashboardComponent;
use App\Livewire\MemberKategoriComponent;
use App\Livewire\PengembalianComponent;
use App\Livewire\PinjamComponent;
use App\Livewire\RegisterComponent;
use App\Livewire\Siswa\Kelas10Component;
use App\Livewire\Siswa\Kelas11Component;
use App\Livewire\Siswa\Kelas12Component;
use App\Livewire\UserComponent;
use Illuminate\Support\Facades\Route;

use App\Models\Kategori;
use App\Services\FonnteService;
use App\Models\Pinjam;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', HomeComponent::class)->middleware('auth')->name('home');
Route::get('/register', RegisterComponent::class)->name('register');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', AdminComponent::class)->name('admin.dashboard');
    Route::get('/member/dashboard', MemberDashboardComponent::class)->name('member.dashboard');
    Route::get('/member/kategori', MemberKategoriComponent::class)->name('member.kategori');
    Route::get('/member/kategori/{id}/buku', MemberBukuComponent::class)->name('member.kategori.buku');
    Route::get('/member/buku/{id}/detail', MemberBukuDetailComponent::class)->name('member.buku.detail');
    Route::get('/member/profile', \App\Livewire\MemberProfileComponent::class)->name('member.profile');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/guru/dashboard', GuruDashboard::class)->name('guru.dashboard');
});

Route::get('/user', UserComponent::class)->name('user')->middleware('auth');

Route::get('/member', MemberComponent::class)->name('member')->middleware('auth');
Route::get('/siswa/kelas10', Kelas10Component::class)->name('siswa.kelas10');
Route::get('/siswa/kelas11', Kelas11Component::class)->name('siswa.kelas11');
Route::get('/siswa/kelas12', Kelas12Component::class)->name('siswa.kelas12');
Route::get('/guru', GuruComponent::class)->name('guru');

Route::get('/kategori', KategoriComponent::class)->name('kategori')->middleware('auth');
Route::get('/buku', BukuComponent::class)->name('buku')->middleware('auth');

Route::get('/pinjam', PinjamComponent::class)->name('pinjam')->middleware('auth');
Route::get('/pinjam/{id}', DetailPinjamComponent::class)->name('pinjam.detail')->middleware('auth');

Route::get('/pengembalian', PengembalianComponent::class)->name('pengembalian')->middleware('auth');

Route::get('/laporan/peminjaman', LaporanPeminjamanComponent::class)->name('laporan.peminjaman');
Route::get('/laporan/buku', LaporanBukuComponent::class)->name('laporan.buku');

Route::get('/login', LoginComponent::class)->name('login');
Route::get('/logout', LoginComponent::class, 'keluar')->name('logout');

Route::get('/search-buku', [SearchController::class, 'searchBuku'])->name('search.buku');
Route::get('/search-member', [SearchController::class, 'searchMember'])->name('search.member');

Route::get('/riwayat', RiwayatComponent::class)->name('riwayat')->middleware('auth');

Route::get('/', function () {
    $kategori = Kategori::all(); // ambil semua kategori dari database
    return view('frontend.home', compact('kategori'));
});
Route::get('/kategori/{id}', BukuByKategori::class)->name('kategori.buku');
Route::get('/buku/{id}', BukuDetail::class)->name('buku.detail');

Route::get('/test-wa', function () {
    $today = Carbon::now()->toDateString();
    $besok = Carbon::now()->addDay()->toDateString();

    // H-1 → pengingat besok
    $pinjamanH1 = Pinjam::with(['user', 'detail.buku'])
        ->whereDate('tgl_kembali', $besok)
        ->where('status', 'pinjam')
        ->get();

    foreach ($pinjamanH1 as $pinjam) {
        $nama = $pinjam->user->nama;
        $telepon = $pinjam->user->telepon;
        $judulBuku = $pinjam->detail->map(fn($d) => $d->buku->judul)->join(', ');
        $tglKembali = $pinjam->tgl_kembali;

        $pesan = "Halo {$nama}, 👋\n"
            . "Ingat ya, buku \"{$judulBuku}\" yang kamu pinjam akan jatuh tempo besok ({$tglKembali}).\n"
            . "Pastikan buku dikembalikan tepat waktu supaya nggak kena denda 📚.";

        FonnteService::sendMessage($telepon, $pesan);
    }

    // H → pengingat hari ini
    $pinjamanH = Pinjam::with(['user', 'detail.buku'])
        ->whereDate('tgl_kembali', $today)
        ->where('status', 'pinjam')
        ->get();

    foreach ($pinjamanH as $pinjam) {
        $nama = $pinjam->user->nama;
        $telepon = $pinjam->user->telepon;
        $judulBuku = $pinjam->detail->map(fn($d) => $d->buku->judul)->join(', ');
        $tglKembali = $pinjam->tgl_kembali;

        $pesan = "Halo {$nama}, 👋\n"
            . "Buku \"{$judulBuku}\" yang kamu pinjam jatuh tempo hari ini ({$tglKembali}).\n"
            . "Segera dikembalikan ya supaya tidak terkena denda 📚.";

        FonnteService::sendMessage($telepon, $pesan);
    }

    // H+1 → peminjaman terlambat
    $pinjamanTerlambat = Pinjam::with(['user', 'detail.buku'])
        ->whereDate('tgl_kembali', '<', $today)
        ->where('status', 'pinjam')
        ->get();

    foreach ($pinjamanTerlambat as $pinjam) {
        $nama = $pinjam->user->nama;
        $telepon = $pinjam->user->telepon;
        $judulBuku = $pinjam->detail->map(fn($d) => $d->buku->judul)->join(', ');
        $tglKembali = $pinjam->tgl_kembali;

        $hariTerlambat = Carbon::now()->diffInDays(Carbon::parse($tglKembali));
        $denda = $hariTerlambat * 500;

        $pesan = "Halo {$nama}, ⚠️\n"
            . "Buku \"{$judulBuku}\" yang kamu pinjam seharusnya dikembalikan pada {$tglKembali}.\n"
            . "Saat ini terlambat {$hariTerlambat} hari, denda sebesar Rp{$denda}.\n"
            . "Segera kembalikan buku ya 📚.";

        FonnteService::sendMessage($telepon, $pesan);
    }

    return "WA H-1, H, H+1 berhasil dijalankan (cek log terminal atau WA).";
});
