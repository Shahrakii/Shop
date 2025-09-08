<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img
                src="{{ asset('assets/img/AdminLTELogo.png') }}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">AdminLTE</span>
        </a>
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper d-flex flex-column justify-content-between" style="height: 100%;">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link @cannot('view admin dashboard') disabled text-muted @endcannot">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>داشبورد</p>
                    </a>
                </li>

                <!-- Roles -->
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}"
                        class="nav-link @cannot('view roles section') disabled text-muted @endcannot">
                        <i class="nav-icon bi bi-shield-lock"></i>
                        <p>نقش ها</p>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Button at the bottom -->
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
    <!--end::Sidebar Wrapper-->
</aside>

<style>
    /* Gray out disabled sidebar links */
    .nav-link.disabled {
        pointer-events: none; /* prevents clicking */
        opacity: 0.5;
        background-color: #f8f9fa; /* optional light gray background */
        color: #6c757d !important; /* muted text */
    }
</style>
