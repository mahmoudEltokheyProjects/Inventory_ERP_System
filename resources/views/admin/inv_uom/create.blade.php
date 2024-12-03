@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')وحدات القياس @endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')اضافة وحدة جديد@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
    اضافة وحدة جديد
    <i class="fa fa-scale-balanced"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">الوحدات</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')اضافة@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        <!-- /.card-header -->
        {{-- ++++++++++++ Notes : Inv uoms => [ Inventory unit of measurments ] ++++++++++++ --}}
        <div class="card-body">
            <form action="{{ route('admin.uoms.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الاسم</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم الوحدة" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ type ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>النوع</label>
                        <select name="is_master" id="is_master" class="form-control select2">
                            <option value="">اختر النوع</option>
                            <option {{ old('is_master') == 1  ? "selected" : "" }} value="1">وحدة اب اساسية</option>
                            <option {{ old('is_master') == 0  ? "selected" : "" }} value="0">وحدة تجزئة فرعية</option>
                        </select>
                        @error('is_master')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ status ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الحالة</label>
                        <select name="active" id="active" class="form-control select2">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br/>
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                    <a href="{{ route('admin.uoms.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
