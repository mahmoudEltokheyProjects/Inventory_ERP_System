@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الحسابات@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الحسابات المالية@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
 الحسابات المالية&nbsp;<i class="fa fa-money-bill-wave"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.accounts.index') }}">الحسابات المالية</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')عرض@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">

    <div class="col-12">
        <div class="row my-2">
            {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
            <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary btn-md">
                اضافة &nbsp; <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="card">
            {{-- ============= card-header ============= --}}
            <div class="card-header">
                <h5 class="text-center mb-5">بيانات الحسابات المالية</h5>
                {{-- ++++++++++++++++++++++++++ Search ++++++++++++++++++++++++++ --}}
                <div class="col-12 mb-2">
                    <div class="row">
                        {{-- Search Token --}}
                        <input type="hidden" id="token_search" value="{{csrf_token() }}">
                        {{-- Seach URL --}}
                        <input type="hidden" id="ajax_search_url" value="{{ route('admin.accounts.ajax_search') }}">
                        {{-- ////////////////// search by : "text" or "account_type" or "is_parent" ////////////////// --}}
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
                            {{-- -------- search inputField -------- --}}
                            <input type="text" id="search_by_text" placeholder="اسم - رقم الحساب" class="form-control">
                        </div>
                        {{-- =========== 2- search by : "account_type" selectbox ++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <label>نوع الحساب</label>
                            <select name="account_type" id="account_type_search" class="form-control">
                                <option value="all">بالكل</option>
                                @foreach ($account_types as $info)
                                    <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- =========== 3- search by : "is_parent" selectbox ++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <label>هل الحساب أب</label>
                            <select name="is_parent" id="is_parent_search" class="form-control">
                                <option value="all">بالكل</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
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
                                <th>رقم الحساب</th>
                                <th>النوع</th>
                                <th>هل اب</th>
                                <th>الحساب الاب</th>
                                <th>الرصيد</th>
                                <th>حالة التفعيل</th>
                                <th>حالة الارشفة</th>
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
                                        {{-- ++++++++++++++++++ account_number ++++++++++++++++++ --}}
                                        <td>{{ $info->account_number }}</td>
                                        {{-- ++++++++++++++++++ account_type  ++++++++++++++++++ --}}
                                        <td>{{ $info->account_types_name }}</td>
                                        {{-- ++++++++++++++++++ is_parent ++++++++++++++++++ --}}
                                        <td>
                                            @if( $info->is_parent == 1 ) نعم @else لا @endif
                                        </td>
                                        {{-- ++++++++++++++++++ parent_account_name ++++++++++++++++++ --}}
                                        <td>{{ $info->parent_account_name }}</td>
                                        {{-- ++++++++++++++++++ current_balance ++++++++++++++++++ --}}
                                        <td>{{ $info->current_balance }}</td>
                                        {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                                        <td>
                                            @if( $info->active == 1 ) مفعل @else معطل @endif
                                        </td>
                                        {{-- ++++++++++++++++++ is_archived ++++++++++++++++++ --}}
                                        <td>
                                            @if( $info->is_archived == 1 ) مفعل @else معطل @endif
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
                                                        <a href="{{ route('admin.accounts.show',$info->id) }}" class="dropdown-item" target="_blank">
                                                            <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                                        </a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        {{-- +++++++++ Edit Button +++++++++ --}}
                                                        <a href="{{ route('admin.accounts.edit',$info->id) }}" class="dropdown-item btn btn-sm  btn-primary" target="_blank">
                                                            <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                                        </a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        {{-- ========= Delete Button ========= --}}
                                                        <a type="button" class="dropdown-item btn btn-sm  btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#delete_account{{ $info->id }}" title="حذف">
                                                            <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- ++++++++++++++++++++++ Delete Modal ++++++++++++++++++++++ --}}
                                    @include('admin.accounts.partials.delete_modal')
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
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection
