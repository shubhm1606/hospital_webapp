<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('opd') }}">
                <i class="bi bi-hospital"></i>
                <span>OPD</span>
            </a>
        </li><!-- End OPD Nav -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('ipd') }}">
            <i class="bi bi-hospital"></i>
                <span>IPD</span>
            </a>
        </li><!-- End IPD Nav -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('records') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Report</span>
            </a>
        </li><!-- End Report Nav -->

        <!-- Dropdown Menu for Settings -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="settings-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('opdSearch')}}">
                        <i class="bi bi-circle"></i><span>OPD SEARCH</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('listpage')}}">
                        <i class="bi bi-circle"></i><span>LIST</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Settings Dropdown -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li><!-- End Logout Nav -->

    </ul>

</aside><!-- End Sidebar -->
