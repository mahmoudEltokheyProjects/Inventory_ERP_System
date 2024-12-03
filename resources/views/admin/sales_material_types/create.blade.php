@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')فئات الفواتير @endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')اضافة فئة جديدة@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
    اضافة  فئة جديدة
    <i class="fa fa-file-invoice"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">فئات الفواتير </a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')اضافة@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
            <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
        </div> --}}
         <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.sales_material_types.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ sales_material_types name ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>اسم فئة الفواتير</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل الفئة" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>حالة الفئة</label>
                        <select name="active" id="active" class="form-control select2">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br />
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                    <a href="{{ route('admin.sales_material_types.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
