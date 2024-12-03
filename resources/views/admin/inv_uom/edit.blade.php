@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل بيانات الوحدة@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تعديل بيانات الوحدة@endsection
{{-- ++++++++ css ++++++++ --}}
@section("css")

@endsection
{{-- ++++++++ contentHeader ++++++++ --}}
@section('contentHeader')
    تعديل الوحدات
    <i class="fa fa-scale-balanced"></i>
@endsection
{{-- ++++++++ contentHeaderLink ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.uoms.index') }}">الوحدات</a>
@endsection
{{-- ++++++++ contentHeaderActiveLink ++++++++ --}}
@section('contentHeaderActiveLink')تعديل@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="card">
    {{-- ============= card-body ============= --}}
    <div class="card-body">
        @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.uoms.update') }}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    {{-- ++++++++++++++ store_id hidden ++++++++++++++ --}}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{-- ++++++++++++++++++ store_name ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>اسم الوحدة</label>
                            <input name="name" id="name" class="form-control" value="{{ old('name', $data['name']) }}" placeholder="ادخل اسم الوحدة">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ type ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>النوع</label>
                        <select name="is_master" id="is_master" class="form-control select2">
                            <option value="">اختر النوع</option>
                            <option {{ old('is_master',$data['is_master']) == 1  ? "selected" : "" }} value="1">وحدة اب اساسية</option>
                            <option {{ old('is_master',$data['is_master']) == 0  ? "selected" : "" }} value="0">وحدة تجزئة فرعية</option>
                        </select>
                        @error('is_master')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ status ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>حالة الوحدة</label>
                            <select name="active" id="active" class="form-control select2">
                                <option value="">اختر الحالة</option>
                                <option {{ old('active',$data['active']) == 1  ? "selected" : "" }} value="1"> مفعل</option>
                                <option {{ old('active',$data['active']) == 0  ? "selected" : "" }} value="0">معطل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div> <br />
                {{-- ++++++++++++++++++ Edit Button ++++++++++++++++++ --}}
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                        <a href="{{ route('admin.uoms.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                    </div>
                </div>
            </form>
        @else
            {{-- ++++++++++++++++++ Error Message ++++++++++++++++++ --}}
            <div class="alert alert-danger">
                عفوا لاتوجد بيانات لعرضها !!
            </div>
        @endif
    </div>
</div>
@endsection
@section("script")

@endsection
