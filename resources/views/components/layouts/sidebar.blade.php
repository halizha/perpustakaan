@php
    use Illuminate\Support\Str;
@endphp
<nav class="col-md-2 bg-dark sidebar">
    <div class="sidebar-sticky">
        {{-- Profil Admin / User --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center px-3 text-center">
            <div class="image mb-2">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="rounded-circle"
                    style="width:80px; height:80px; object-fit:contain; background:white; padding:5px;">

            </div>
            <div class="info">
                <span class="d-block text-white mb-0"
                    style="font-size: 1.4rem; font-family: Arial, sans-serif; font-weight: bold;">
                    SIPERPUS
                </span>
            </div>
        </div>

        @if (Auth::check())
    {{-- Sidebar Admin --}}
    @if (Auth::user()->jenis == 'admin')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('home') }}">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>

            {{-- Kelola Member --}}
            @php
                $isActiveMainMenu =
                    request()->routeIs('member') ||
                    request()->routeIs('siswa.kelas10') ||
                    request()->routeIs('siswa.kelas11') ||
                    request()->routeIs('siswa.kelas12') ||
                    request()->routeIs('guru');

                $menuOpen =
                    request()->routeIs('siswa.kelas10') ||
                    request()->routeIs('siswa.kelas11') ||
                    request()->routeIs('siswa.kelas12') ||
                    request()->routeIs('guru');
            @endphp
            <li class="nav-item {{ $isActiveMainMenu ? 'menu-open' : '' }}">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <a href="{{ route('member') }}"
                        class="nav-link text-white flex-grow-1 {{ $isActiveMainMenu ? 'active' : '' }}">
                        <i data-feather="users"></i> Kelola Member
                    </a>
                    <button type="button" class="btn btn-link p-0 text-white" onclick="toggleSubmenu(event)">
                        <i data-feather="chevron-{{ $menuOpen ? 'down' : 'right' }}" class="dropdown-icon"></i>
                    </button>
                </div>

                <ul class="submenu ps-4" style="display: {{ $menuOpen ? 'block' : 'none' }};">
                    <li><a href="{{ route('siswa.kelas10') }}"
                            class="nav-link text-white {{ request()->routeIs('siswa.kelas10') ? 'active' : '' }}"><i
                                data-feather="user"></i> Kelas 10</a></li>
                    <li><a href="{{ route('siswa.kelas11') }}"
                            class="nav-link text-white {{ request()->routeIs('siswa.kelas11') ? 'active' : '' }}"><i
                                data-feather="user"></i> Kelas 11</a></li>
                    <li><a href="{{ route('siswa.kelas12') }}"
                            class="nav-link text-white {{ request()->routeIs('siswa.kelas12') ? 'active' : '' }}"><i
                                data-feather="user"></i> Kelas 12</a></li>
                    <li><a href="{{ route('guru') }}"
                            class="nav-link text-white {{ request()->routeIs('guru') ? 'active' : '' }}"><i
                                data-feather="user-check"></i> Guru</a></li>
                </ul>
            </li>

            {{-- Menu admin lainnya --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'buku' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('buku') }}">
                    <span data-feather="book-open"></span>
                    Kelola Buku
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'pinjam') ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('pinjam') }}">
                    <span data-feather="book"></span>
                    Kelola Peminjaman
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'pengembalian' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('pengembalian') }}">
                    <span data-feather="check-circle"></span>
                    Kelola Pengembalian
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'kategori' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('kategori') }}">
                    <span data-feather="tag"></span>
                    Kelola Kategori
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'user' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('user') }}">
                    <span data-feather="user"></span>
                    Kelola Staff
                </a>
            </li>

            {{-- Laporan --}}
            @php
                $isActiveLaporan =
                    request()->routeIs('laporan.peminjaman') || request()->routeIs('laporan.buku');
                $menuLaporanOpen = $isActiveLaporan;
            @endphp
            <li class="nav-item {{ $isActiveLaporan ? 'menu-open' : '' }}">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <a href="#"
                        class="nav-link text-white flex-grow-1 {{ $isActiveLaporan ? 'active' : '' }}">
                        <i data-feather="file-text"></i> Laporan
                    </a>
                    <button type="button" class="btn btn-link p-0 text-white" onclick="toggleSubmenu(event)">
                        <i data-feather="chevron-{{ $menuLaporanOpen ? 'down' : 'right' }}"
                            class="dropdown-icon"></i>
                    </button>
                </div>
                <ul class="submenu ps-4" style="display: {{ $menuLaporanOpen ? 'block' : 'none' }};">
                    <li><a href="{{ route('laporan.peminjaman') }}"
                            class="nav-link text-white {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}">
                            <i data-feather="book"></i> Laporan Peminjaman
                        </a></li>
                    <li><a href="{{ route('laporan.buku') }}"
                            class="nav-link text-white {{ request()->routeIs('laporan.buku') ? 'active' : '' }}">
                            <i data-feather="book-open"></i> Laporan Buku
                        </a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('logout') }}">
                    <span data-feather="log-out"></span> Logout
                </a>
            </li>
        </ul>

    {{-- Sidebar Siswa --}}
    @elseif (Auth::user()->jenis === 'siswa')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'member.dashboard' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('member.dashboard') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Str::contains(Route::currentRouteName(), 'buku') || Str::contains(Route::currentRouteName(), 'kategori') ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('member.kategori') }}">
                    <span data-feather="book-open"></span> Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'riwayat') ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('riwayat') }}">
                    <span data-feather="clock"></span> Riwayat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'member.profile' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('member.profile') }}">
                    <span data-feather="user"></span> Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('logout') }}">
                    <span data-feather="log-out"></span> Logout
                </a>
            </li>
        </ul>

    {{-- Sidebar Guru --}}
    @elseif (Auth::user()->jenis === 'guru')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'guru.dashboard' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('guru.dashboard') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Str::contains(Route::currentRouteName(), 'buku') || Str::contains(Route::currentRouteName(), 'kategori') ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('member.kategori') }}">
                    <span data-feather="book-open"></span> Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'riwayat') ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('riwayat') }}">
                    <span data-feather="clock"></span> Riwayat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'member.profile' ? 'bg-primary text-white' : 'text-white' }}"
                    href="{{ route('member.profile') }}">
                    <span data-feather="user"></span> Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('logout') }}">
                    <span data-feather="log-out"></span> Logout
                </a>
            </li>
        </ul>
    @endif
@endif

    </div>
</nav>

<script>
    function toggleSubmenu(event) {
        event.stopPropagation(); // biar klik panah nggak klik link utama
        const btn = event.currentTarget;
        const parent = btn.closest('li');
        const submenu = parent.querySelector('.submenu');
        const icon = btn.querySelector('.dropdown-icon');

        // Toggle submenu
        const isHidden = submenu.style.display === 'none' || submenu.style.display === '';
        submenu.style.display = isHidden ? 'block' : 'none';

        // Ganti ikon
        icon.setAttribute('data-feather', isHidden ? 'chevron-down' : 'chevron-right');
        feather.replace();
    }

    document.addEventListener('DOMContentLoaded', () => feather.replace());
</script>

<style>
    .submenu {
        transition: all 0.3s ease;
    }

    .nav-item .nav-link {
        cursor: pointer;
    }

    .dropdown-icon {
        transition: transform 0.3s ease;
    }
</style>
