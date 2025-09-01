@php
    use Illuminate\Support\Str;
@endphp

<div class="d-flex">
    <nav class="bg-dark sidebar">
        <div class="sidebar-sticky">
            {{-- Profil Admin / User --}}
            <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center px-3 text-center">
                <div class="image mb-2">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="rounded-circle"
                        style="width:80px; height:80px; object-fit:contain; background:white; padding:5px;">
                </div>
                <div class="info">
                    <span class="d-block text-white mb-0 fw-bold" style="font-size: 1.4rem;">
                        SIPERPUS
                    </span>
                </div>
            </div>

            @if (Auth::check())
                {{-- Sidebar Admin --}}
                @if (Auth::user()->jenis == 'admin')
                    <ul class="nav flex-column">

                        {{-- Dashboard --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i data-feather="home"></i> Dashboard
                            </a>
                        </li>

                        {{-- Master --}}
                        @php
                            $isActiveMaster = request()->routeIs('rak') || request()->routeIs('rak.detail');
                        @endphp

                        <li class="nav-item {{ $isActiveMaster ? 'menu-open' : '' }}">
                            <div class="nav-toggle">
                                <a href="#" class="nav-link {{ $isActiveMaster ? 'active' : '' }}">
                                    <i data-feather="layers"></i> Master
                                </a>
                                <button type="button" class="toggle-btn" onclick="toggleSubmenu(event)">
                                    <i data-feather="{{ $isActiveMaster ? 'chevron-down' : 'chevron-right' }}"
                                        class="dropdown-icon"></i>
                                </button>
                            </div>

                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('rak') }}"
                                        class="nav-link {{ request()->routeIs('rak') || request()->routeIs('rak.detail') ? 'active' : '' }}">
                                        <i data-feather="archive"></i> Kelola Rak
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Kelola Member --}}
                        @php
                            $isActiveMainMenu =
                                request()->routeIs('member') ||
                                request()->routeIs('siswa.kelas10') ||
                                request()->routeIs('siswa.kelas11') ||
                                request()->routeIs('siswa.kelas12') ||
                                request()->routeIs('guru');
                        @endphp
                        <li class="nav-item {{ $isActiveMainMenu ? 'menu-open' : '' }}">
                            <div class="nav-toggle">
                                <a href="{{ route('member') }}"
                                    class="nav-link {{ $isActiveMainMenu ? 'active' : '' }}">
                                    <i data-feather="users"></i> Kelola Member
                                </a>
                                <button type="button" class="toggle-btn" onclick="toggleSubmenu(event)">
                                    <i data-feather="{{ $isActiveMainMenu ? 'chevron-down' : 'chevron-right' }}"
                                        class="dropdown-icon"></i>
                                </button>
                            </div>
                            <ul class="submenu">
                                <li><a href="{{ route('siswa.kelas10') }}"
                                        class="nav-link {{ request()->routeIs('siswa.kelas10') ? 'active' : '' }}"><i
                                            data-feather="user"></i> Kelas 10</a></li>
                                <li><a href="{{ route('siswa.kelas11') }}"
                                        class="nav-link {{ request()->routeIs('siswa.kelas11') ? 'active' : '' }}"><i
                                            data-feather="user"></i> Kelas 11</a></li>
                                <li><a href="{{ route('siswa.kelas12') }}"
                                        class="nav-link {{ request()->routeIs('siswa.kelas12') ? 'active' : '' }}"><i
                                            data-feather="user"></i> Kelas 12</a></li>
                                <li><a href="{{ route('guru') }}"
                                        class="nav-link {{ request()->routeIs('guru') ? 'active' : '' }}"><i
                                            data-feather="user-check"></i> Guru</a></li>
                            </ul>
                        </li>

                        {{-- Menu admin lainnya --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'buku' || Route::currentRouteName() == 'buku.eksemplar' ? 'active' : '' }}"
                                href="{{ route('buku') }}">
                                <i data-feather="book-open"></i> Kelola Buku
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'pinjam') ? 'active' : '' }}"
                                href="{{ route('pinjam') }}">
                                <i data-feather="book"></i> Kelola Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'pengembalian' ? 'active' : '' }}"
                                href="{{ route('pengembalian') }}">
                                <i data-feather="check-circle"></i> Kelola Pengembalian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'kategori' ? 'active' : '' }}"
                                href="{{ route('kategori') }}">
                                <i data-feather="tag"></i> Kelola Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'user' ? 'active' : '' }}"
                                href="{{ route('user') }}">
                                <i data-feather="user"></i> Kelola Staff
                            </a>
                        </li>

                        {{-- Laporan --}}
                        @php
                            $isActiveLaporan =
                                request()->routeIs('laporan.peminjaman') ||
                                request()->routeIs('laporan.buku') ||
                                request()->routeIs('laporan.anggota');
                        @endphp

                        <li class="nav-item {{ $isActiveLaporan ? 'menu-open' : '' }}">
                            <div class="nav-toggle">
                                <a href="#" class="nav-link {{ $isActiveLaporan ? 'active' : '' }}">
                                    <i data-feather="file-text"></i> Laporan
                                </a>
                                <button type="button" class="toggle-btn" onclick="toggleSubmenu(event)">
                                    <i data-feather="{{ $isActiveLaporan ? 'chevron-down' : 'chevron-right' }}"
                                        class="dropdown-icon"></i>
                                </button>
                            </div>

                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('laporan.peminjaman') }}"
                                        class="nav-link {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}">
                                        <i data-feather="book"></i> Laporan Peminjaman
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('laporan.buku') }}"
                                        class="nav-link {{ request()->routeIs('laporan.buku') ? 'active' : '' }}">
                                        <i data-feather="book-open"></i> Laporan Buku
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('laporan.anggota') }}"
                                        class="nav-link {{ request()->routeIs('laporan.anggota') ? 'active' : '' }}">
                                        <i data-feather="users"></i> Laporan Anggota
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">
                                <i data-feather="log-out"></i> Logout
                            </a>
                        </li>
                    </ul>

                    {{-- Sidebar Siswa --}}
                @elseif (Auth::user()->jenis === 'siswa')
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'member.dashboard' ? 'active' : '' }}"
                                href="{{ route('member.dashboard') }}">
                                <i data-feather="home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Str::contains(Route::currentRouteName(), 'buku') || Str::contains(Route::currentRouteName(), 'kategori') ? 'active' : '' }}"
                                href="{{ route('member.kategori') }}">
                                <i data-feather="book-open"></i> Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'riwayat') ? 'active' : '' }}"
                                href="{{ route('riwayat') }}">
                                <i data-feather="clock"></i> Riwayat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'member.profile' ? 'active' : '' }}"
                                href="{{ route('member.profile') }}">
                                <i data-feather="user"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">
                                <i data-feather="log-out"></i> Logout
                            </a>
                        </li>
                    </ul>

                    {{-- Sidebar Guru --}}
                @elseif (Auth::user()->jenis === 'guru')
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'guru.dashboard' ? 'active' : '' }}"
                                href="{{ route('guru.dashboard') }}">
                                <i data-feather="home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Str::contains(Route::currentRouteName(), 'buku') || Str::contains(Route::currentRouteName(), 'kategori') ? 'active' : '' }}"
                                href="{{ route('member.kategori') }}">
                                <i data-feather="book-open"></i> Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'riwayat') ? 'active' : '' }}"
                                href="{{ route('riwayat') }}">
                                <i data-feather="clock"></i> Riwayat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'member.profile' ? 'active' : '' }}"
                                href="{{ route('member.profile') }}">
                                <i data-feather="user"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">
                                <i data-feather="log-out"></i> Logout
                            </a>
                        </li>
                    </ul>
                @endif
            @endif
        </div>
    </nav>
</div>

{{-- JS --}}
<script>
    function toggleSubmenu(event) {
        event.stopPropagation();
        const parent = event.currentTarget.closest('li');
        const icon = parent.querySelector('.dropdown-icon');
        const isOpen = parent.classList.contains('menu-open');

        parent.classList.toggle('menu-open', !isOpen);
        icon.setAttribute('data-feather', isOpen ? 'chevron-right' : 'chevron-down');
        feather.replace();
    }

    document.addEventListener('DOMContentLoaded', () => feather.replace());
</script>

{{-- CSS --}}
<style>
    .sidebar {
        position: fixed;
        /* Biar sidebar nempel kiri */
        top: 0;
        left: 0;
        width: 250px;
        /* Lebar fix */
        height: 100vh;
        /* Full tinggi layar */
        background: #212529;
        /* Warna dark */
        flex: 0 0 250px;
        /* Fix width, tidak mengecil */
        z-index: 1000;
        /* Biar selalu di atas */
        overflow-y: auto;
        /* Scroll kalau konten panjang */
    }

    .content-wrapper {
        margin-left: 250px;
        /* Biar tidak ketiban sidebar */
        flex: 1;
        /* Sisa layar buat konten */
        padding: 20px;
    }

    .nav-link {
        color: #ddd;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all .2s;
        flex-shrink: 0;
    }

    .nav-link:hover {
        background: #495057;
        color: #fff;
    }

    .nav-link.active {
        background: #0d6efd;
        color: #fff !important;
    }

    .nav-toggle {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .nav-toggle .nav-link {
        flex: 1;
        /* isi full sisa space */
        margin-right: 5px;
        /* kasih ruang buat tombol */
    }

    .nav-toggle .toggle-btn {
        width: 40px;
        /* space fix buat tombol */
        text-align: center;
        flex-shrink: 0;
    }

    .toggle-btn {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
    }

    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height .3s ease;
        padding-left: 15px;
    }

    .menu-open .submenu {
        max-height: 500px;
        /* cukup besar biar semua item muat */
    }
</style>
