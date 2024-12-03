@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل حساب عميل@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')حسابات العملاء@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حسابات العملاء&nbsp;<i class="fa fa-users"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('customers.create') }}">حسابات العملاء</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')تعديل@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        {{-- ============= card-header ============= --}}
        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل حساب العميل</h3>
        </div>
        {{-- ============= card-body ============= --}}
        <div class="card-body">
            <form action="{{ route('customers.update',$data['id']) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- +++++++++++++++ "customer_id" hidden +++++++++++++++ --}}
                    <input type="hidden" name="id" id="id" class="form-control" value="{{ $data['id'] }}">
                    {{-- ++++++++++++++++++ "name" ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>اسم العميل</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم الحساب" value="{{ old('name', $data['name']) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- حالة رصيد اول مدة" , "رصيد اول المدة للحساب هذه الحقول بيتم ادخلها مرة واحدة فقط في صفحة الاضافة" وبيتم تعديلها في صفحة ضبط الانشطة" --}}
                    {{-- ++++++++++++++++++ "active" ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>حالة التفعيل <span class="text-danger">*</span> </label>
                        <select name="active" id="active" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active',$data['active']) == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active',$data['active']) == 0  ? "selected" : "" }} value="0">معطل</option>
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
                            <option {{ old('is_archived',$data['is_archived']) == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('is_archived',$data['is_archived']) == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('is_archived')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "address" ++++++++++++++++++ --}}
                    <div class="col-md-6  col-sm-6">
                        <label>العنوان</label>
                        <input name="address" id="address" class="form-control" placeholder="ادخل عنوان العميل" value="{{ old('address',$data['address']) }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br />
                {{-- ++++++++++++++++++ "notes" ++++++++++++++++++ --}}
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label>الملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="5" placeholder="ادخل الملاحظات" value="{{ old('notes',$data['notes']) }}">{{ old('notes',$data['notes']) }}</textarea>
                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br />
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" id="submit">تعديل</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
