@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')المشتريات@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')حركات مخزنية@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حركات مخزنية&nbsp;<i class="fa-solid fa-truck-fast"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.suppliers.index') }}"> فواتير المشتريات</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')عرض@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">فواتير المشتريات</h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.suppliers_orders.ajax_search') }}">
      <a href="{{ route('admin.suppliers_orders.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <input checked type="radio" name="searchbyradio" id="searchbyradio" value="auto_serial"> بالكود الآلي
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="DOC_NO"> بكود  اصل الشراء
            <input style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder="" class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>بحث  بالموردين</label>
               <select name="supplier_code_search" id="supplier_code_search" class="form-control select2">
                  <option value="all">بحث بكل الموردين</option>
                  @if (@isset($suppliers) && !@empty($suppliers))
                    @foreach ($suppliers as $info )
                        <option value="{{ $info->supplier_code }}"> {{ $info->name }} </option>
                    @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    بيانات المخازن</label>
               <select name="store_id_search" id="store_id_search" class="form-control select2">
                  <option value="all">بحث بكل المخازن</option>
                  @if (@isset($stores) && !@empty($stores))
                    @foreach ($stores as $info )
                        <option  value="{{ $info->id }}"> {{ $info->name }} </option>
                    @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث  من تاريخ</label>
               <input name="order_date_form" id="order_date_form" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث  الي تاريخ</label>
               <input name="order_date_to" id="order_date_to" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="col-md-12">
            <div id="ajax_responce_serarchDiv">
               @if (@isset($data) && !@empty($data) && count($data) >0)
               @php
               $i=1;
               @endphp
               <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                     <th>كود</th>
                     <th> المورد</th>
                     <th> تاريخ الفاتورة</th>
                     <th>  نوع الفاتورة</th>
                     {{-- <th>   المخزن المستلم</th>
                     <th>    اجمالي الفاتورة</th> --}}
                     <th>حالة الفاتورة</th>
                     <th>العمليات</th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $info->auto_serial }}</td>
                        <td>{{ $info->supplier_name }}</td>
                        <td>{{ $info->order_date }}</td>
                        <td>@if($info->pill_type==1)  كاش  @elseif($info->pill_type==2)  اجل  @else  غير محدد @endif</td>
                        {{-- <td>{{ $info->store_name }}</td>
                        <td>{{ $info->total_cost*(1) }}</td> --}}
                        <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td>

                        {{-- ++++++++++++++++++ Actions ++++++++++++++++++ --}}
                        <td class="dropdown show">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    {{-- +++++++++ Show Button +++++++++ --}}
                                    <li>
                                        <a href="{{ route('admin.suppliers_orders.show',$info->id) }}" class="dropdown-item" target="_blank">
                                            <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                        </a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <a href="{{ route('admin.suppliers_orders.edit',$info->id) }}" class="dropdown-item" target="_blank">
                                            <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                        </a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        {{-- ========= Delete Button ========= --}}
                                        <a type="button" class="dropdown-item btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#delete_suppliers_order{{ $info->id }}" title="حذف">
                                            <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                     </tr>
                    {{-- ++++++++++++++++++++++ Delete Modal ++++++++++++++++++++++ --}}
                    @include('admin.suppliers_with_orders.partials.delete_modal')
                    @endforeach
                </tbody>
            </table>
            {{-- ++++++++++++ Laravel Pagination +++++++++++ --}}
            {{ $data->links() }}
        @else
            <div class="alert alert-danger">
                عفوا لاتوجد بيانات لعرضها !!
            </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/suppliers_with_order.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection
