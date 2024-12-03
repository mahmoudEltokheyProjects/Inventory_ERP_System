@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الرئيسية@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الرئيسية@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')الرئيسية@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.dashboard') }}">الرئيسية</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')عرض@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- +++++++++++++++++++ treasuries : الخزن +++++++++++++++++++ -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
          <div class="small-box bg-info">
            <div class="inner">
                @php
                    $treasuries = App\Models\Treasury\Treasury::all();
                @endphp
              <h3>{{ $treasuries->count() }}</h3>
              <p>الخزن</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <a href="{{ route('admin.treasury.index') }}" class="small-box-footer" target="_blank">عرض المزيد
                <i class="fas fa-arrow-circle-left"></i>
            </a>
          </div>
        </div>
        <!-- +++++++++++++++++++ stores : المخازن +++++++++++++++++++ -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="small-box bg-success">
                <div class="inner">
                    @php
                        $stores = App\Models\Store::all();
                    @endphp
                    <h3>{{ $stores->count() }}</h3>
                    <p>المخازن</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-store"></i>
                </div>
                <a href="{{ route('admin.stores.index') }}" class="small-box-footer" target="_blank">عرض المزيد
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
            </div>
        </div>
        <!-- +++++++++++++++++++ sales_material_types : فئات الفواتير +++++++++++++++++++ -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    @php
                        $sales_material_types = App\Models\SalesMaterialType::all();
                    @endphp
                    <h3>{{ $sales_material_types->count() }}</h3>
                    <p>فئات الفواتير</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <a href="{{ route('admin.sales_material_types.index') }}" class="small-box-footer" target="_blank">عرض المزيد
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
            </div>
        </div>
        <!-- +++++++++++++++++++ uoms : الوحدات +++++++++++++++++++ -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="small-box bg-danger">
                <div class="inner">
                    @php
                        $inv_uoms = App\Models\Units\InvUom::all();
                    @endphp
                    <h3>{{ $inv_uoms->count() }}</h3>
                    <p>الوحدات</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <a href="{{ route('admin.uoms.index') }}" class="small-box-footer" target="_blank">عرض المزيد
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
            </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
    @php
        $photo = App\Models\Admin\AdminPanelSetting::where('com_code',auth()->user()->com_code)->value('photo');
    @endphp
    {{-- +++++++++++++ Photo +++++++++++++ --}}
    @if (!empty($photo) && file_exists(public_path('assets/admin/uploads/'.$photo)))
        <div class="row"
            style="background-image: url({{ asset('assets/admin/uploads/'.$photo) }});
            background-size: cover; background-repeat: no-repeat; min-height: 600px;">
        </div>
    @else
        <div class="row"
            style="background-image: url({{ asset('assets/admin/imgs/dash.jpg') }});
            background-size: cover; background-repeat: no-repeat; min-height: 600px;">
        </div>
    @endif


@endsection

