<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            {{-- ========= Content Page Header ========= --}}
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">
                    @yield('contentHeader')
                </h4>
            </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                {{-- ========= Content Page Header Link ========= --}}
                <li class="breadcrumb-item">@yield('contentHeaderLink')</li>
                {{-- ========= Content Page Header Link Active ========= --}}
                <li class="breadcrumb-item active">@yield('contentHeaderActiveLink')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- +++++++++++++++++ Start : Main content +++++++++++++++++ -->
    <div class="content">
      <div class="container-fluid">
        {{-- ========= Start : Content ========= --}}
        @yield('content')
        {{-- ========= End : Content ========= --}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- +++++++++++++++++ End : Main Content +++++++++++++++++ -->
  </div>
  <!-- /.content-wrapper -->
