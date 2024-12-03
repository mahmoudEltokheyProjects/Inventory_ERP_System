@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')المخازن @endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')اضافة مخزن جديد@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
    اضافة مخزن جديد
    <i class="fa fa-store"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">المخازن</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')اضافة@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.stores.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ store name ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الاسم</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم المخزن" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ store status ++++++++++++++++++ --}}
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
                    {{-- ++++++++++++++++++ store phone ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الهاتف</label>
                        <input name="phone" id="phone" class="form-control" placeholder="ادخل هاتف المخزن" value="{{ old('phone') }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ store address ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>العنوان</label>
                        <input name="address" id="address" class="form-control" placeholder="ادخل عنوان المخزن" value="{{ old('address') }}">
                        @error('address')
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
