@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')اضافة حساب مالي@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الحسابات المالية@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
الحسابات المالية&nbsp;<i class="fa  fa-money-bill-wave"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.accountTypes.create') }}">الحسابات المالية</a>
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
            <form action="{{ route('admin.accounts.store') }}" method="post">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ "name" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>اسم الحساب المالي</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم الحساب" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "account_type" selectbox ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>نوع الحساب</label>
                        <select name="account_type" id="account_type" class="form-control">
                            <option value="">اختر النوع</option>
                            @foreach ($account_types as $info)
                                <option {{ old('account_type') == $info->id ? 'selected' : '    '}} value="{{ $info->id }}">{{ $info->name }}</option>
                            @endforeach
                        </select>
                        @error('account_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "is_parent" selectbox ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>هل الحساب أب</label>
                        <select name="is_parent" id="is_parent" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('is_parent') == 1  ? "selected" : "" }} value="1">نعم</option>
                            <option {{ old('is_parent') == 0  ? "selected" : "" }} value="0">لا</option>
                        </select>
                        @error('is_parent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "parent_account_number" selectbox ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6" id="parentDiv" @if(old('is_parent') == 1 || old('is_parent')==' ') style="display: none;" @endif >
                        <label>الحسابات الاب</label>
                        <select name="parent_account_number" id="parent_account_number" class="form-control">
                            <option value="">اختر النوع</option>
                            @foreach ($parent_accounts as $info)
                                <option {{ old('parent_account_number') == $info->account_number ? 'selected' : ''}} value="{{ $info->account_number }}">{{ $info->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_account_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "start_balance_status" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>حالة رصيد اول مدة</label>
                        <select name="start_balance_status" id="start_balance_status" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('start_balance_status') == 1  ? "selected" : "" }} value="1">دائن</option>
                            <option {{ old('start_balance_status') == 2  ? "selected" : "" }} value="2">مدين</option>
                            <option {{ old('start_balance_status') == 3  ? "selected" : "" }} value="3">متزن</option>
                        </select>
                        @error('start_balance_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "start_balance" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>رصيد اول المدة  للحساب</label>
                        <input name="start_balance" id="start_balance" class="form-control" placeholder="ادخل رصيد اول المدة للحساب" value="{{ old('start_balance') }}" oninput="this.value = this.value.replace(/[^0-9]/g,'');">
                        @error('start_balance')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "active" ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>حالة التفعيل</label>
                        <select name="active" id="active" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "archive" ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>حالة الارشفة</label>
                        <select name="is_archived" id="is_archived" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('is_archived') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('is_archived') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br />
                {{-- ++++++++++++++++++ "notes" ++++++++++++++++++ --}}
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label>الملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="5" placeholder="ادخل الملاحظات" value="{{ old('notes') }}"></textarea>
                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br />
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" id="submit"> اضافة</button>
                    <a href="{{ route('admin.accountTypes.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection
