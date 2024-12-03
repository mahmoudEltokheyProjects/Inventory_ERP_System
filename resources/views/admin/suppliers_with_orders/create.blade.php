@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')اضافة حركة مخزنية@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')حركات مخزنية@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
فواتير المشتريات &nbsp;<i class="fa fa-truck-fast"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.suppliers.index') }}">فواتير المشتريات</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')اضافة@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة  فاتورة مشتريات من مورد </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.suppliers_orders.store') }}" method="post" >
               @csrf
               <div class="row">
                    {{-- ++++++++++++++++++ "order_date" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>تاريخ الفاتورة</label>
                        <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
                        @error('order_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "doc_no" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>رقم الفاتورة</label>
                        <input name="doc_no" id="doc_no" type="text" class="form-control" title="رقم الفاتورة المسجل بأصل فاتورة المشتريات" value="{{ old('doc_no') }}">
                        @error('doc_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "suppliers" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>بيانات الموردين</label>
                        <select name="supplier_code" id="supplier_code" class="form-control select2">
                            <option value="">اختر المورد</option>
                            @if (@isset($suppliers) && !@empty($suppliers))
                                @foreach ($suppliers as $info )
                                    <option @if(old('supplier_code')==$info->supplier_code) selected="selected" @endif value="{{ $info->supplier_code }}"> {{ $info->name }} </option>
                                @endforeach
                            @endif
                        </select>
                        @error('supplier_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "pill_type" ++++++++++++++++++ --}}
                    <div class="col-md-3 col-sm-6">
                        <label>نوع الفاتورة</label>
                        <select name="pill_type" id="pill_type" class="form-control">
                            <option @if(old('pill_type')==1) selected="selected"  @endif value="1">كاش</option>
                            <option @if(old('pill_type')==2) selected="selected"  @endif value="2">اجل</option>
                        </select>
                        @error('pill_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
               </div>
                {{-- ++++++++++++++++++ "notes" ++++++++++++++++++ --}}
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label>الملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="5" placeholder="ادخل الملاحظات" value="{{ old('notes') }}"></textarea>
                    </div>
                </div><br />
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                  <a href="{{ route('admin.suppliers_orders.index') }}" class="btn btn-sm btn-danger">الغاء</a>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection
