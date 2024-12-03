@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل بيانات المخزن@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تعديل بيانات المخزن@endsection
{{-- ++++++++ css ++++++++ --}}
@section("css")

@endsection
{{-- ++++++++ contentHeader ++++++++ --}}
@section('contentHeader')
    المخازن
    <i class="fa fa-file-invoice"></i>
@endsection
{{-- ++++++++ contentHeaderLink ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">المخازن</a>
@endsection
{{-- ++++++++ contentHeaderActiveLink ++++++++ --}}
@section('contentHeaderActiveLink')تعديل@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="card">
    {{-- ============= card-body ============= --}}
    <div class="card-body">
        @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.stores.update') }}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    {{-- ++++++++++++++ store_id hidden ++++++++++++++ --}}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{-- ++++++++++++++++++ store_name ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>اسم المخزن</label>
                            <input name="name" id="name" class="form-control" value="{{ old('name', $data['name']) }}" placeholder="ادخل اسم المخزن">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>حالة الفئة</label>
                            <select name="active" id="active" class="form-control select2">
                                <option value="">اختر الحالة</option>
                                <option @if( old('active',$data['active']) == 1) selected="selected" @endif value="1"> مفعل</option>
                                <option @if( old('active',$data['active']) == 0) selected="selected" @endif value="0">معطل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ phone ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الهاتف</label>
                        <input name="phone" id="phone" class="form-control" placeholder="ادخل هاتف المخزن" value="{{ old('phone',$data['phone']) }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ address ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>العنوان</label>
                        <input name="address" id="address" class="form-control" placeholder="ادخل عنوان المخزن" value="{{ old('address',$data['address']) }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br />
                </div>
                {{-- ++++++++++++++++++ Edit Button ++++++++++++++++++ --}}
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
