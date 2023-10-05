<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link">
        <img src="{{ url('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;" />
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @if(auth()->user()->display_photo)
            <div class="image">
                <img src="{{ auth()->user()->display_photo }}" class="img-circle elevation-2" alt="User Image" />
            </div>
            @endif
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->fullname }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(auth()->user()->display_photo)
                <li class="nav-item">
                    <a href="{{ url('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ url('judge/contest') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @endif
                @if(auth()->user()->display_photo)
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Contests
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('client/contests/create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Contest</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('client/contests') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Contest</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('client/participants') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Participants</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Judges
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('client/judges/create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Judge</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('client/judges') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Judges</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Criterias
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('client/criteria/create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Criteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('client/criteria') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Criteria</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Setting</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>