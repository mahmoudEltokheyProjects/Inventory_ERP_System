@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل حساب مورد@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')حسابات الموردين@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حسابات الموردين&nbsp;<i class="fa fa-truck-field"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.suppliers.create') }}">حسابات الموردين</a>
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
            <h3 class="card-title card_title_center">تعديل حساب المورد</h3>
        </div>
        {{-- ============= card-body ============= --}}
        <div class="card-body">
            <form action="{{ route('admin.suppliers.update') }}" method="post">
                @csrf
                @method('POST')
                <div class="row">
                    {{-- +++++++++++++++ "customer_id" hidden +++++++++++++++ --}}
                    <input type="hidden" name="id" id="id" class="form-control" value="{{ $data['id'] }}">
                    {{-- ++++++++++++++++++ "name" ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>اسم المورد</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم الحساب" value="{{ old('name', $data['name']) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "supplier_categories" selectbox ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label>فئة المورد <span class="text-danger">*</span> </label>
                        <select name="supplier_categories_id" id="supplier_categories_id" class="form-control">
                            <option value="">اختر الفئة</option>
                            @if ( !empty($supplier_categories) )
                                @foreach ( $supplier_categories as $info)
                                    <option {{ old('supplier_categories_id',$data['supplier_categories_id']) == $info->id  ? "selected" : "" }} value="{{  $info->id }}">{{  $info->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('active')
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
                        <input name="address" id="address" class="form-control" placeholder="ادخل عنوان المورد" value="{{ old('address',$data['address']) }}">
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
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
