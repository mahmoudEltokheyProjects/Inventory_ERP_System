@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')حسابات الموردين @endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')فئات الموردين@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حسابات الموردين <i class="fa fa-truck-ramp-box"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.sales_material_types.index') }}">فئات الموردين</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')الحسابات@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.suppliers_categories.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="row">
                    {{-- ++++++++++++++++++ sales_material_types name ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>اسم الفئة</label>
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
                    <button type="submit" class="btn btn-primary btn-sm">اضافة</button>
                    <a href="{{ route('admin.suppliers_categories.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
