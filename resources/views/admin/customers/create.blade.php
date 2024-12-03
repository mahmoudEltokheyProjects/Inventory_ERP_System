@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')اضافة حساب عميل@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')حسابات العملاء@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حسابات العملاء&nbsp;<i class="fa fa-users"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('customers.index') }}">حسابات العملاء</a>
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
            <h3 class="card-title card_title_center">اضافة حساب للعميل</h3>
        </div>
        {{-- ============= card-body ============= --}}
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="post">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ "name" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>اسم العميل <span class="text-danger">*</span> </label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم العميل" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                            {{-- حالة رصيد اول مدة" , "رصيد اول المدة للحساب هذه الحقول بيتم ادخلها مرة واحدة فقط في صفحة الاضافة" وبيتم تعديلها في صفحة ضبط الانشطة" --}}
                    {{-- ++++++++++++++++++ "start_balance_status" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>حالة رصيد اول مدة <span class="text-danger">*</span> </label>
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
                        <label>رصيد اول المدة  للحساب <span class="text-danger">*</span> </label>
                        <input name="start_balance" id="start_balance" class="form-control" placeholder="ادخل رصيد اول المدة للحساب" value="{{ old('start_balance') }}" oninput="this.value = this.value.replace(/[^0-9]/g,'');">
                        @error('start_balance')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "active" ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>حالة التفعيل <span class="text-danger">*</span> </label>
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
                        <label>حالة الارشفة <span class="text-danger">*</span> </label>
                        <select name="is_archived" id="is_archived" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('is_archived') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('is_archived') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('is_archived')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "address" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>العنوان</label>
                        <input name="address" id="address" class="form-control" placeholder="ادخل عنوان العميل" value="{{ old('address') }}">
                        @error('address')
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
    <script src="{{ asset('assets/admin/js/customers.js') }}"></script>
@endsection
