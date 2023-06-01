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
                        href="{{ route('dashboard') }}"><i class="fas fa-home"></i>
                        <span>Dashboard</span></a>
                </li>
                <hr>
            @endrole

            @role('petugas|siswa')
                <li><a href="{{ route('home') }}" class="nav-link {{ Request::segment(1) == 'home' ? 'active' : '' }}">
                        <i class="fas fa-home"></i> <span>Home</span></a>
                </li>
                <hr>
            @endrole

            @role('admin')
                {{-- Start Manajemen Data --}}
                <li class="menu-header">Manajemen Data</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link"><i class="far fa-file-alt"></i>
                        <span>Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('siswa.index') }}"
                        class="nav-link {{ Request::segment(2) == 'siswa' ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> <span>Siswa</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('kelas.index') }}"
                        class="nav-link {{ Request::segment(2) == 'kelas' ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i><span>Kelas</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('periode.index') }}"
                        class="nav-link {{ Request::segment(2) == 'periode' ? 'active' : '' }}">
                        <i class="fas fa-plug"></i><span>Periode</span></a>
                </li>
                {{-- End Manajemen Data --}}

                {{-- Start Pembayaran --}}
                <li class="menu-header">Pembayaran</li>
                <li class="nav-item dropdown">
                    <a href="{{ route('pembayaran.index') }}"
                        class="nav-link {{ Request::segment(2) == 'pembayaran' ? 'active' : '' }}"><i
                            class="far fa-user"></i>
                        <span>Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link"><i class="far fa-user"></i>
                        <span>Status Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link"><i class="far fa-user"></i>
                        <span>Histori Pembayaran</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link"><i class="far fa-user"></i>
                        <span>Laporan Pembayaran</span></a>
                </li>
                {{-- End Pembayaran --}}
            @endrole

            @role('admin')
                {{-- Start Permission Manajemen --}}
                <li class="menu-header">Permission</li>
                <li class="nav-item dropdown">
                    <a href="{{ route('petugas.index') }}"
                        class="nav-link {{ Request::segment(2) == 'petugas' ? 'active' : '' }}">
                        <i class="fas fa-plug"></i><span>Petugas</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('user.index') }}"
                        class="nav-link {{ Request::segment(2) == 'user' ? 'active' : '' }}">
                        <i class="fas fa-plug"></i> <span>User</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('roles.index') }}"
                        class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}"><i class="far fa-user"></i>
                        <span>List Role</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'permission' ? 'active' : '' }}"><i
                            class="far fa-user"></i>
                        <span>Permission List</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'user-permission' ? 'active' : '' }}"><i
                            class="far fa-user"></i>
                        <span>User Permission</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('role-permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'role-permission' ? 'active' : '' }}"><i
                            class="far fa-user"></i>
                        <span>Role Permission</span></a>
                </li>
                {{-- End Permission Manajemen --}}
            @endrole



        </ul>
    </aside>
</div>
