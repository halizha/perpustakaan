@php
    use Illuminate\Support\Str;
@endphp
<nav class="col-md-2 bg-dark sidebar">
    <div class="sidebar-sticky">
        {{-- Profil Admin / User --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center px-3">
            <div class="image">
                <img src="{{ asset('assets/login.png') }}" class="img-circle elevation-2" alt="Login"
                    style="width:40px; height:40px; object-fit:cover;">
            </div>
            <div class="info ms-2">
                <a href="#" class="d-block text-white mb-0" style="font-size: 0.9rem;">
                    {{ Auth::check() ? Auth::user()->nama : 'Tamu' }}
                </a>
                <small class="text-white-50">
                    {{ Auth::check() ? Auth::user()->jenis : '-' }}
                </small>
            </div>
        </div>

        @if (Auth::check())
            @if (Auth::user()->jenis == 'admin')
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'bg-primary text-white' : 'text-white' }}"
                            href="{{ route('home') }}">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>

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
                            <!-- Link utama -->
                            <a href="{{ route('member') }}"
                                class="nav-link text-white flex-grow-1 {{ $isActiveMainMenu ? 'active' : '' }}">
                                <i data-feather="users"></i> Kelola Member
                            </a>

                            <!-- Tombol toggle -->
                            <button type="button" class="btn btn-link p-0 text-white" onclick="toggleSubmenu(event)">
                                <i data-feather="chevron-{{ $menuOpen ? 'down' : 'right' }}" class="dropdown-icon"></i>
                            </button>
                        </div>

                        <!-- Submenu -->
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

                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'buku' ? 'bg-primary text-white' : 'text-white' }}"
                            href="{{ route('buku') }}">
                            <span data-feather="book"></span>
                            Kelola Buku
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'pinjam') ? 'bg-primary text-white' : 'text-white' }}"
                            href="{{ route('pinjam') }}">
                            <span data-feather="file"></span>
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
                </ul>
            @elseif (in_array(Auth::user()->jenis, ['siswa', 'guru']))
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'member.dashboard' ? 'bg-primary text-white' : 'text-white' }}"
                            href="{{ route('member.dashboard') }}">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'member.buku') ? 'bg-primary text-white' : 'text-white' }}"
                            href="{{ route('member.buku') }}">
                            <span data-feather="book"></span>
                            Buku
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
