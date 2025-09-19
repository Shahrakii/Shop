<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">AdminLTE</span>
        </a>
    </div>

    <div class="sidebar-wrapper d-flex flex-column justify-content-between" style="height: 100%;">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                @can('view admin dashboard')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>داشبورد</p>
                    </a>
                </li>
                @endcan

                @can('view roles section')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-shield-lock"></i>
                        <p>نقش‌ها</p>
                    </a>
                </li>
                @endcan

                @can('view admins section')
                <li class="nav-item">
                    <a href="{{ route('admin.admins.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>ادمین‌ها</p>
                    </a>
                </li>
                @endcan

            </ul>
        </nav>

        <div class="p-3">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    خروج
                    <i class="bi bi-box-arrow-right" style="margin-right: 5px;"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
