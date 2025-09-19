<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
            <!-- User Dropdown -->
            <li class="nav-item dropdown user-menu" style="margin-right: 88%;">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->avatar ?? asset('assets/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end position-absolute" style="left: 0;">
                    <li class="user-header text-bg-primary">
                        <img src="{{ auth()->user()->avatar ?? asset('assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow" alt="User Image" />
                        <p>
                            {{ auth()->user()->name }} - {{ auth()->user()->roles->pluck('label')->join(', ') }}
                            <small>عضو از {{ auth()->user()->created_at->format('Y/m') }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <form method="POST" action="{{ route('admin.logout') }}" class="d-inline float-end">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat">خروج</button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
<!--end::Header-->

<style>
    /* ===========================
   Admin Header & User Menu
=========================== */

.app-header {
    background: #f8f9fa; /* Light gray background */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 0.5rem 1rem;
    font-family: 'Vazirmatn', sans-serif;
    z-index: 1000;
}

.app-header .nav-link {
    color: #495057;
    transition: all 0.3s ease;
    z-index: 1100;
}

.app-header .nav-link:hover {
    color: #007bff;
}

/* User Dropdown */
.user-menu .nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    z-index: 100;
}

.user-menu .user-image {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border: 2px solid #007bff;
    transition: all 0.3s ease;
}

.user-menu .user-image:hover {
    transform: scale(1.1);
    border-color: #00c6ff;
}

/* Dropdown Menu */
.user-menu .dropdown-menu {
    border-radius: 15px;
    padding: 0;
    min-width: 250px;
    background: linear-gradient(145deg, #0072ff, #00c6ff);
    color: #fff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    z-index: 100;
}

/* User Header */
.user-menu .user-header {
    background: linear-gradient(145deg, #00c6ff, #0072ff);
    text-align: center;
    padding: 15px;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.user-menu .user-header img {
    width: 70px;
    height: 70px;
    border: 3px solid #fff;
    margin-bottom: 10px;
}

.user-menu .user-header p {
    margin: 0;
    font-weight: 600;
    font-size: 0.95rem;
}

.user-menu .user-header small {
    display: block;
    margin-top: 3px;
    font-weight: 400;
    color: rgba(255,255,255,0.85);
}

/* Footer */
.user-menu .user-footer {
    padding: 10px 15px;
    display: flex;
    justify-content: center;
    gap: 10px;
    background: rgba(255,255,255,0.1);
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}

.user-menu .user-footer .btn {
    background: #fff;
    color: #0072ff;
    font-weight: 600;
    border-radius: 10px;
    padding: 5px 15px;
    transition: all 0.3s ease;
}

.user-menu .user-footer .btn:hover {
    background: #00c6ff;
    color: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

li {
    list-style: none;
}

/* Small Screens */
@media (max-width: 768px) {
    .user-menu .dropdown-menu {
        min-width: 200px;
    }

    .user-menu .user-header img {
        width: 60px;
        height: 60px;
    }
}

</style>