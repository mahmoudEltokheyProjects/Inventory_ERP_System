@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')فئات الاصناف@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')اضافة فئة جديد@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
    اضافة فئة جديد
    <i class="fa fa-boxes"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('inv_item_card_categories.index') }}">فئات الاصناف</a>
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
            <form action="{{ route('inv_item_card_categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الاسم</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم الفئة" value="{{ old('name') }}">
                        @error('name')
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
                    <a href="{{ route('inv_item_card_categories.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
