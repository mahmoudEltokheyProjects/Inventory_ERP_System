  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        {{-- ++++++++++++ dashboard ++++++++++++  --}}
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">الرئيسية</a>
        </li>
    </ul>
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- +++++++++++++++++++++ Right navbar links +++++++++++++++++++++ -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('assets/admin/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('assets/admin/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('assets/admin/dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                    class="fas fa-th-large"></i></a>
        </li>
        @php
            $phone = \App\Models\Admin\AdminPanelSetting::where('com_code', auth()->user()->com_code)->value('phone');
        @endphp
        {{-- ++++++++++++ WhatsApp ++++++++++++ --}}
        <li class="nav-item mt-2">
            <a href="http://wa.me/+2{{ $phone }}" class="ml-3 fa-lg" aria-label="WhatsApp">
                <i class="fa-brands fa-whatsapp fa-lg text-success"></i>
            </a>
        </li>

        {{-- ++++++++++++ Telephone ++++++++++++ --}}
        <li class="nav-item mt-2">
            <a href="tel:+2{{ $phone }}" aria-label="Telephone">
                <i class="fa fa-square-phone fa-lg text-info"></i>
            </a>
        </li>

        {{-- ++++++++++++ SMS ++++++++++++ --}}
        <li class="nav-item mt-2">
            <a href="sms:+2{{ $phone }}" class="ml-3" aria-label="SMS">
                <i class="fa fa-message fa-lg text-secondary"></i>
            </a>
        </li>
        {{-- ++++++++++++ mail ++++++++++++ --}}
        @php
            $email = \App\Models\Admin\AdminPanelSetting::where('com_code', auth()->user()->com_code)->value('email');
        @endphp
        <li class="nav-item mt-1">
            <a href="mailto:{{ $email }}" aria-label="mail">
                <i class="fa fa-envelope-open fa-lg text-secondary"></i>
            </a>
        </li>

        {{-- ++++++++++++ Logout ++++++++++++ --}}
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link" href="#" aria-label="Logout"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-power-off fa-lg text-danger"></i>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>


    </ul>
    <!-- ++++++++++++++ logo ++++++++++++++ -->
    <div class="text-left navbar-brand-wrapper" style="width:200px !important;height:50px !important;">
        @php
            $logo = \App\Models\Admin\AdminPanelSetting::where('com_code', auth()->user()->com_code)->value('logo');
        @endphp
        <a class="w-10" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/admin/uploads/' . ($logo ?? 'dash.jpg')) }}" alt=""
                style="width: 100% !important;height:50px !important;">
        </a>

    </div>
  </nav>
  <!-- /.navbar -->
