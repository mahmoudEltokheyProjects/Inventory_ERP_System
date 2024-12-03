@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الموردين@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الموردين@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حسابات الموردين&nbsp;<i class="fa fa-truck-field"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.suppliers.index') }}">الموردين</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')عرض@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">

    <div class="col-12">
        <div class="row my-2 mr-1">
            {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary btn-md">
                اضافة &nbsp; <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="card">
            {{-- ============= card-header ============= --}}
            <div class="card-header">
                <h5 class="text-center mb-5">بيانات الموردين</h5>
                {{-- ++++++++++++++++++++++++++ Search ++++++++++++++++++++++++++ --}}
                <div class="col-12 mb-2">
                    <div class="row">
                        {{-- Search Token --}}
                        <input type="hidden" id="token_search" value="{{csrf_token() }}">
                        {{-- Seach URL --}}
                        <input type="hidden" id="ajax_search_url" value="{{ route('admin.suppliers.ajax_search') }}">
                        {{-- ////////////////// search by : "text" or "account_number" or "customer_code" ////////////////// --}}
                        {{-- =========== 1- search by : "name" or "account_number" =========== --}}
                        <div class="col-md-4">
                            <label>بحث ب</label>
                            {{-- -------- radio button : "name" or "account_number" -------- --}}
                            {{-- "name" radionButton --}}
                            <input type="radio" name="search_by_text_radio" id="search_by_name_radio" value="name" checked>
                            <label for="search_by_name_radio" style="font-weight:normal;">الاسم</label>
                            {{-- "account_number" radionButton --}}
                            <input type="radio" name="search_by_text_radio" id="search_by_account_number_radio" value="account_number">
                            <label for="search_by_account_number_radio" style="font-weight:normal;">رقم الحساب</label>
                            {{-- "supplier_code" radionButton --}}
                            <input type="radio" name="search_by_text_radio" id="search_by_supplier_code_radio" value="supplier_code">
                            <label for="search_by_supplier_code_radio" style="font-weight:normal;">كود المورد</label>
                            {{-- -------- search inputField -------- --}}
                            <input type="text" id="search_by_text" placeholder="اسم - رقم الحساب - كود المورد" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            {{-- ============= card-body ============= --}}
            <div class="card-body">
                <div id="ajax_responce_serarchDiv">
                    @if ( @isset($data) && !@empty($data) && count($data) > 0 )
                        <table id="example2" class="table table-bordered table-hover">
                            {{-- ///////// thead ///////// --}}
                            <thead class="custom_thead">
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الفئة</th>
                                <th>الكود</th>
                                <th>رقم الحساب</th>
                                <th>حالة التفعيل</th>
                                <th>تاريخ الاضافة</th>
                                <th>تاريخ التحديث</th>
                                <th>العمليات</th>
                            </thead>
                            {{-- ///////// tbody ///////// --}}
                            <tbody class="all_data">
                                @foreach ($data as $index => $info )
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                                        <td>{{ $info->name }}</td>
                                        {{-- ++++++++++++++++++ supplier_category_name ++++++++++++++++++ --}}
                                        <td>{{ $info->supplier_category_name }}</td>
                                        {{-- ++++++++++++++++++ supplier_code ++++++++++++++++++ --}}
                                        <td>{{ $info->supplier_code }}</td>
                                        {{-- ++++++++++++++++++ account_number ++++++++++++++++++ --}}
                                        <td>{{ $info->account_number }}</td>
                                        {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                                        <td>
                                            @if( $info->active == 1 ) مفعل @else معطل @endif
                                        </td>
                                        {{-- ++++++++++++++++++ created_at ++++++++++++++++++ --}}
                                        <td>
                                            @php
                                                $dt = new DateTime($info->created_at);
                                                $date = $dt->format('Y-m-d');
                                                $time = $dt->format('H:i');
                                                $newDateTime = date("A",strtotime($time));
                                                $newDateTimeType = (($newDateTime == 'AM') ? 'صباحا' : 'مساءا')
                                            @endphp
                                            {{ $date }}
                                            {{ $time }}
                                            {{ $newDateTimeType }} <br/>
                                            بواسطة
                                            {{ $info->added_by_admin }}
                                        </td>
                                        {{-- ++++++++++++++++++ updated_at ++++++++++++++++++ --}}
                                        <td>
                                            @if( $info->updated_by  > 0 && $info->updated_by != null )
                                                @php
                                                    $dt   = new DateTime($info->updated_at);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('H:i');
                                                    $newDateTime = date("A",strtotime($time));
                                                    $newDateTimeType = (($newDateTime == 'AM') ? 'صباحا' : 'مساءا')
                                                @endphp
                                                {{ $date }}
                                                {{ $time }}
                                                {{ $newDateTimeType }} <br/>
                                                بواسطة
                                                {{ $info->updated_by_admin }}
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
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
                                                        <a href="{{ route('admin.suppliers.show',$info->id) }}" class="dropdown-item" target="_blank">
                                                            <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                                        </a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        {{-- +++++++++ Edit Button +++++++++ --}}
                                                        <a href="{{ route('admin.suppliers.edit',$info->id) }}" class="dropdown-item btn btn-sm  btn-primary" target="_blank">
                                                            <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                                        </a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        {{-- ========= Delete Button ========= --}}
                                                        <a type="button" class="dropdown-item btn btn-sm btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#delete_supplier{{ $info->id }}" title="حذف">
                                                            <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- ++++++++++++++++++++++ Delete Modal ++++++++++++++++++++++ --}}
                                    @include('admin.suppliers.partials.delete_modal')
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
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/suppliers.js') }}"></script>
@endsection
