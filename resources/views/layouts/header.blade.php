<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right mt-3">
                <div class="dropdown-title" style="font-size: 13px">Akun</div>
                <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                {{-- <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a> --}}
                <a href="features-settings.html" class="dropdown-item has-icon disabled">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                {{-- <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a> --}}
                <form method="POST" action="{{ route('logout') }}">
                    {{-- <button type="button" class="btn btn-default mr-2" data-dismiss="modal">Close</button> --}}
                    @csrf
                    <button type="submit" class="dropdown-item text-danger" style="font-size: 15px"><i
                            class="fas fa-sign-out-alt mr-2"></i>Logout</button>
                </form>

            </div>
        </li>
    </ul>
</nav>
