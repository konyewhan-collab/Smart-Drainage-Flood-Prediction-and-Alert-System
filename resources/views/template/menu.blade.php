<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="{{ url('/') }}" class="nav-item nav-link @yield('aktif-home')">Home</a></li>
        <li><a href="{{ url('/about') }}" class="nav-item nav-link @yield('aktif-about')">About</a></li>
        <li><a href="{{ url('/service') }}" class="nav-item nav-link @yield('aktif-service') ">Service</a></li>
        <li><a href="{{ url('/contact') }}" class="nav-item nav-link @yield('aktif-contact')">Contact</a></li>


        {{-- LOGIC: Check if user is logged in securely using Auth --}}
        @if(Auth::check())

            <li><a href="{{ url('/logout-confirm') }}" class="nav-item nav-link text-danger">Logout</a></li>

            {{-- Show Role-Specific Links using strtolower() to fix case-sensitivity --}}
            @if(strtolower(Auth::user()->userlevel) == "admin")
                <li><a href="{{ url('/admin/reports') }}" class="nav-item nav-link @yield('aktif-admin-report')">Admin Page</a></li>
                <li><a href="{{ url('/admin/services') }}" class="nav-item nav-link @yield('aktif-admin-service')">ManageIoT</a></li>
                <li class="nav-item"><a class="nav-link @yield('aktif-manage-iot')" href="{{ url('/admin/manage-iot') }}">IoT Data</a></li>
                <li><a href="{{ url('/manageuser') }}" class="nav-item nav-link @yield('aktif-admin')">Manage User</a></li>

            @elseif(strtolower(Auth::user()->userlevel) == "user")
                <li><a href="{{ url('/userpage') }}" class="nav-item nav-link @yield('aktif-user')">User Page</a></li>
                <li><a href="{{ url('/location') }}" class="nav-item nav-link @yield('aktif-location')">Live Map</a></li>
                <li><a href="{{ url('/history') }}" class="nav-item nav-link @yield('aktif-history')">Data History</a></li>
                <li><a href="{{ url('/userprofile') }}" class="nav-item nav-link @yield('aktif-user-profile')">Profile</a></li>
            @endif

        @else
            {{-- If NOT logged in, show LOGIN --}}
            <li><a href="{{ url('/login') }}" class="nav-item nav-link @yield('aktif-login')">Login</a></li>
        @endif
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>