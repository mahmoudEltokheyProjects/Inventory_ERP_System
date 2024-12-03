@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل بيانات فئة فواتير@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تعديل بيانات فئة فواتير@endsection
{{-- ++++++++ css ++++++++ --}}
@section("css")

@endsection
{{-- ++++++++ contentHeader ++++++++ --}}
@section('contentHeader')
    فئات الفواتير
    <i class="fa fa-file-invoice"></i>
@endsection
{{-- ++++++++ contentHeaderLink ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">فئات الفواتير</a>
@endsection
{{-- ++++++++ contentHeaderActiveLink ++++++++ --}}
@section('contentHeaderActiveLink')تعديل@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="card">
    {{-- ============= card-body ============= --}}
    <div class="card-body">
        @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.sales_material_types.update') }}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    {{-- ++++++++++++++ sales_material_type_id hidden ++++++++++++++ --}}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{-- ++++++++++++++++++ treasury_name ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>اسم فئة الفواتير</label>
                            <input name="name" id="name" class="form-control" value="{{ old('name', $data['name']) }}" placeholder="ادخل اسم الفئة">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>حالة الفئة</label>
                            <select name="active" id="active" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option @if( old('active',$data['active']) == 1) selected="selected" @endif value="1"> مفعل</option>
                                <option @if( old('active',$data['active']) == 0) selected="selected" @endif value="0">معطل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- ++++++++++++++++++ Edit Button ++++++++++++++++++ --}}
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
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
