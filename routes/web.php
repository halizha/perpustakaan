<?php

use App\Http\Controllers\SearchController;
use App\Livewire\AdminComponent;
use App\Livewire\BukuComponent;
use App\Livewire\DetailPinjamComponent;
use App\Livewire\GuruComponent;
use App\Livewire\GuruDashboard;
use App\Livewire\HomeComponent;
use App\Livewire\KategoriComponent;
use App\Livewire\LoginComponent;
use App\Livewire\MemberBukuComponent;
use App\Livewire\MemberBukuDetailComponent;
use App\Livewire\MemberComponent;
use App\Livewire\MemberDashboardComponent;
use App\Livewire\PengembalianComponent;
use App\Livewire\PinjamComponent;
use App\Livewire\RegisterComponent;
use App\Livewire\Siswa\Kelas10Component;
use App\Livewire\Siswa\Kelas11Component;
use App\Livewire\Siswa\Kelas12Component;
use App\Livewire\UserComponent;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeComponent::class)->middleware('auth')->name('home');
Route::get('/register', RegisterComponent::class)->name('register');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', AdminComponent::class)->name('admin.dashboard');
    Route::get('/member/dashboard', MemberDashboardComponent::class)->name('member.dashboard');
    Route::get('/member/buku', MemberBukuComponent::class)->name('member.buku');
    Route::get('/member/buku/{id}/detail', MemberBukuDetailComponent::class)->name('member.buku.detail');
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

Route::get('/login', LoginComponent::class)->name('login');
Route::get('/logout', LoginComponent::class, 'keluar')->name('logout');

Route::get('/search-buku', [SearchController::class, 'searchBuku'])->name('search.buku');
Route::get('/search-member', [SearchController::class, 'searchMember'])->name('search.member');

//FRONT END
//Route::get('/', function () {
//    return view('frontend.beranda'); // arahkan ke home.blade.php
//});
