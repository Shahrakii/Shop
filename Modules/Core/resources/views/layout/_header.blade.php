<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">خانه</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">تماس</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!--end::Navbar Search-->
            <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">۳</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img
                                    src="{{ asset('assets/img/user1-128x128.jpg') }}"
                                    alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    سعید رضایی
                                    <span class="float-end fs-7 text-danger">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">هر وقت تونستی تماس بگیر...</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> ۴ ساعت پیش
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img
                                    src="{{ asset('assets/img/user8-128x128.jpg') }}"
                                    alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    مهسا کرمی
                                    <span class="float-end fs-7 text-secondary">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">پیامت رسید، ممنون</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> ۴ ساعت پیش
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img
                                    src="{{ asset('assets/img/user3-128x128.jpg') }}"
                                    alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    نرگس موسوی
                                    <span class="float-end fs-7 text-warning">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">موضوع اینجا نوشته می‌شود</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> ۴ ساعت پیش
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">مشاهده همه پیام‌ها</a>
                </div>
            </li>
            <!--end::Messages Dropdown Menu-->
            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">۱۵</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">۱۵ اعلان</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> ۴ پیام جدید
                        <span class="float-end text-secondary fs-7">۳ دقیقه پیش</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-people-fill me-2"></i> ۸ درخواست دوستی
                        <span class="float-end text-secondary fs-7">۱۲ ساعت پیش</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-file-earmark-fill me-2"></i> ۳ گزارش جدید
                        <span class="float-end text-secondary fs-7">۲ روز پیش</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">مشاهده همه اعلان‌ها</a>
                </div>
            </li>
            <!--end::Notifications Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img
                        src="{{ asset('assets/img/user2-160x160.jpg') }}"
                        class="user-image rounded-circle shadow"
                        alt="User Image"
                    />
                    <span class="d-none d-md-inline">علیرضا محسنی</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        <img
                            src="{{ asset('assets/img/user2-160x160.jpg') }}"
                            class="rounded-circle shadow"
                            alt="User Image"
                        />
                        <p>
                            علیرضا محسنی - توسعه‌دهنده وب
                            <small>عضو از آبان ۱۴۰۲</small>
                        </p>
                    </li>
                    <!--end::User Image-->
                    <!--begin::Menu Body-->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center"><a href="#">دنبال‌کننده‌ها</a></div>
                            <div class="col-4 text-center"><a href="#">فروش</a></div>
                            <div class="col-4 text-center"><a href="#">دوستان</a></div>
                        </div>
                    </li>
                    <!--end::Menu Body-->
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">پروفایل</a>
                        <a href="#" class="btn btn-default btn-flat float-end">خروج</a>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
