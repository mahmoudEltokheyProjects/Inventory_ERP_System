@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الحسابات المالية@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')انواع الحسابات@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
انواع الحسابات &nbsp;<i class="fa fa-hand-holding-usd"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.accountTypes.create') }}">انواع الحسابات</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')اضافة@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        {{-- ============= card-header ============= --}}
        <div class="card-header">
            <h3 class="card-title card_title_center">اضافة حساب مالي جديد</h3>
        </div>
        {{-- ============= card-body ============= --}}
        <div class="card-body">
            <form action="{{ route('admin.accountTypes.store') }}" method="post">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ accountTypes "name" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الاسم</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم الحساب" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ accountTypes "status" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>نوع الحساب</label>
                        <select name="active" id="active" class="form-control">
                            <option value="">اختر النوع</option>
                            @foreach ($account_types as $account_type)
                                {{-- <option value="{{ old(' ') }}" --}}
                            @endforeach
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ accountTypes "status" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>الحالة</label>
                        <select name="active" id="active" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ accountTypes "relatedInternalAccounts" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>هل يُضاف من الشاشة الداخلية</label>
                        <select name="relatedInternalAccounts" id="relatedInternalAccounts" class="form-control">
                            <option value="">اختر</option>
                            <option {{ old('relatedInternalAccounts') == 1  ? "selected" : "" }} value="1">نعم</option>
                            <option {{ old('relatedInternalAccounts') == 0  ? "selected" : "" }} value="0">لا</option>
                        </select>
                        @error('relatedInternalAccounts')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br />
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                    <a href="{{ route('admin.accountTypes.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
