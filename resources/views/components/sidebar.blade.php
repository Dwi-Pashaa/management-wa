<nav class="pcoded-navbar">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">
            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="{{asset('')}}images/user/avatar-2.jpg" alt="User-Profile-Image">
                    <div class="user-details">
                        <span>{{ Auth::user()->name }}</span>
                        <div id="more-details">{{ Auth::user()->email }}<i class="fa fa-chevron-down m-l-5"></i></div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item">
                            <a href="#">
                                <i class="feather icon-user m-r-5"></i>
                                View Profile
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('logout') }}">
                                <i class="feather icon-log-out m-r-5"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Dashboard</label>
                </li>
                <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link ">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                @role('Admin')
                    <li class="nav-item pcoded-menu-caption">
                        <label>Master Data</label>
                    </li>
                    <li class="nav-item {{ Route::is('users*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Users</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('subscription*') ? 'active' : '' }}">
                        <a href="{{ route('subscription.index') }}" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-bar-chart"></i>
                            </span>
                            <span class="pcoded-mtext">Monitor & Subscribtion</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="index.html" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-monitor"></i>
                            </span>
                            <span class="pcoded-mtext">Monitor & Subscribtion</span>
                        </a>
                    </li> --}}
                    <li class="nav-item pcoded-menu-caption">
                        <label>Setting</label>
                    </li>
                    <li class="nav-item {{ Route::is('setting') ? 'active' : '' }}">
                        <a href="{{ route('setting') }}" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-settings"></i>
                            </span>
                            <span class="pcoded-mtext">Platform Setting</span>
                        </a>
                    </li>
                @endrole
                @role('User')
                    <li class="nav-item pcoded-menu-caption">
                        <label>Menu</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu {{ Route::is('form*') ? 'active' : '' }}">
                        <a href="#!" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-clipboard"></i>
                            </span>
                            <span class="pcoded-mtext">Create & Customize Form</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li>
                                <a href="{{ route('form.create') }}">
                                    Create Form
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('form.index') }}">
                                    List Form
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Route::is('auto.message*') ? 'active' : '' }}">
                        <a href="{{ route('auto.message.index') }}" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-message-circle"></i>
                            </span>
                            <span class="pcoded-mtext">Auto Messages</span>
                        </a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Setting</label>
                    </li>
                    <li class="nav-item {{ Route::is('apikey*') ? 'active' : '' }}">
                        <a href="{{ route('apikey.index') }}" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-cpu"></i>
                            </span>
                            <span class="pcoded-mtext">Set Api Key Wasapmatic</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('change.password*') ? 'active' : '' }}">
                        <a href="{{ route('change.password.index') }}" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-lock"></i>
                            </span>
                            <span class="pcoded-mtext">Change Password</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
    </div>
</nav>