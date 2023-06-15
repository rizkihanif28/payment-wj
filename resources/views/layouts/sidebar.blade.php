<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">SPP Walang Jaya</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">WJ</a>
        </div>
        <ul class="sidebar-menu">

            <!-- Sidebar user panel (optional) -->
            <li><a href="javascript:void(0)"><i class="fas fa-user"></i>
                    <span>{{ Auth::user()->username }}</span></a>
            </li>
            <hr>
            @role('admin|petugas')
                <li><a href="{{ route('home') }}" class="nav-link {{ Request::segment(1) == 'home' ? 'active' : '' }}">
                        <i class="fas fa-home"></i> <span>Home</span></a>
                </li>
                <li><a class="nav-link {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}"
                        href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <hr>
            @endrole

            {{-- Siswa --}}
            @role('siswa')
                <li><a href="{{ route('home') }}" class="nav-link {{ Request::segment(1) == 'home' ? 'active' : '' }}">
                        <i class="fas fa-home"></i> <span>Home</span></a>
                </li>
                <li><a href="{{ route('siswa.history-pembayaran') }}"
                        class="nav-link {{ Request::segment(2) == 'history-pembayaran' ? 'active' : '' }}">
                        <i class="fas fa-history"></i> <span>History Pembayaran</span></a>
                </li>
                <li><a href="{{ route('siswa.status-pembayaran.detail') }}"
                        class="nav-link {{ Request::segment(2) == 'status-pembayaran' ? 'active' : '' }}">
                        <i class="fas fa-bell"></i> <span>Status Pembayaran</span></a>
                </li>
            @endrole

            @role('petugas')
                {{-- Start Manajemen Data --}}
                <li class="menu-header">Manajemen Data</li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.manajemen') }}"
                        class="nav-link {{ Request::segment(2) == 'manajemen' ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i><span>Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('siswa.index') }}"
                        class="nav-link {{ Request::segment(2) == 'siswa' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i><span>Siswa</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('kelas.index') }}"
                        class="nav-link {{ Request::segment(2) == 'kelas' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-school"></i><span>Kelas</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('periode.index') }}"
                        class="nav-link {{ Request::segment(2) == 'periode' ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i><span>Periode</span></a>
                </li>
                {{-- End Manajemen Data --}}

                {{-- Start Pembayaran --}}
                <li class="menu-header">Pembayaran</li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.index') }}"
                        class="nav-link {{ Request::segment(2) == 'index' ? 'active' : '' }}">
                        <i class="fas fa-money-bill"></i><span>Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.status') }}"
                        class="nav-link {{ Request::segment(2) == 'status' ? 'active' : '' }}">
                        <i class="fas fa-bell"></i><span>Status Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.history-pembayaran') }}"
                        class="nav-link {{ Request::segment(2) == 'history-pembayaran' ? 'active' : '' }}">
                        <i class="fas fa-history"></i><span>History Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.laporan') }}"
                        class="nav-link {{ Request::segment(2) == 'laporan' ? 'active' : '' }}">
                        <i class="fas fa-book-open"></i><span>Laporan Pembayaran</span></a>
                </li>
                {{-- End Pembayaran --}}
            @endrole
            {{-- Manajemen Data --}}
            @role('admin')
                {{-- Start Manajemen Data --}}
                <li class="menu-header">Manajemen Data</li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.manajemen') }}"
                        class="nav-link {{ Request::segment(2) == 'manajemen' ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i><span>Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('petugas.index') }}"
                        class="nav-link {{ Request::segment(2) == 'petugas' ? 'active' : '' }}">
                        <i class="fas fa-laptop-house"></i><span>Petugas</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('user.index') }}"
                        class="nav-link {{ Request::segment(2) == 'user' ? 'active' : '' }}">
                        <i class="fas fa-users"></i><span>User</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('siswa.index') }}"
                        class="nav-link {{ Request::segment(2) == 'siswa' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i><span>Siswa</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('kelas.index') }}"
                        class="nav-link {{ Request::segment(2) == 'kelas' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-school"></i><span>Kelas</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('periode.index') }}"
                        class="nav-link {{ Request::segment(2) == 'periode' ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i><span>Periode</span></a>
                </li>
                {{-- End Manajemen Data --}}

                {{-- Start Pembayaran --}}
                <li class="menu-header">Pembayaran</li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.index') }}"
                        class="nav-link {{ Request::segment(2) == 'index' ? 'active' : '' }}">
                        <i class="fas fa-money-bill"></i><span>Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.status') }}"
                        class="nav-link {{ Request::segment(2) == 'status' ? 'active' : '' }}">
                        <i class="fas fa-bell"></i><span>Status Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.history-pembayaran') }}"
                        class="nav-link {{ Request::segment(2) == 'history-pembayaran' ? 'active' : '' }}">
                        <i class="fas fa-history"></i><span>History Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.laporan') }}"
                        class="nav-link {{ Request::segment(2) == 'laporan' ? 'active' : '' }}">
                        <i class="fas fa-book-open"></i><span>Laporan Pembayaran</span></a>
                </li>
                {{-- End Pembayaran --}}
            @endrole

            {{-- Permissions --}}
            @role('admin')
                {{-- Start Permission Manajemen --}}
                <li class="menu-header">Permission</li>

                <li class="nav-item ">
                    <a href="{{ route('roles.index') }}"
                        class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                        <i class="fas fa-th-list"></i><span>List Role</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'permission' ? 'active' : '' }}">
                        <i class="fas fa-stream"></i><span>Permission List</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'user-permission' ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i><span>User Permission</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('role-permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'role-permission' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i><span>Role Permission</span></a>
                </li>
                {{-- End Permission Manajemen --}}
            @endrole



        </ul>
    </aside>
</div>
