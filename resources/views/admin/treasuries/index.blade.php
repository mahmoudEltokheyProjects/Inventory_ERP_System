@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الضبط العام@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الخزن@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
الخزن <i class="fa fa-vault"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">الخزن</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')عرض@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- ============= card-header ============= --}}
            <div class="card-header">
                {{-- <h3 class="card-title card_title_center">بيانات الخزن</h3> --}}
                {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
                <a href="{{ route('admin.treasury.create') }}" class="btn btn-primary btn-md">
                    اضافة &nbsp; <i class="fa fa-plus"></i>
                </a>
            </div>
            {{-- ============= card-body ============= --}}
            <div class="card-body">
                {{-- ++++++++ search ++++++++ --}}
                <div class="row">
                    <div class="col-md-4">
                        {{-- Search InputField --}}
                        <input type="text" name="search" id="search_by_text" placeholder="بحث" class="form-control">
                        {{-- Ajax URL : store route of ajax because route() method not recognized in js --}}
                        <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasury.ajax_search') }}">
                        {{-- Token Search URL : store token of ajax --}}
                        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    </div>
                </div> <br/>
                <div id="ajax_responce_serarchDiv">
                   @if (@isset($data) && !@empty($data) && count($data) >0 )
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>مسلسل</th>
                                <th>اسم الخزنة</th>
                                <th>نوع الخزنة</th>
                                <th>اخر ايصال صرف</th>
                                <th>اخر ايصال تحصيل</th>
                                <th>حالة الخزنة</th>
                                <th>تاريخ الاضافة</th>
                                <th>تاريخ التحديث</th>
                                <th>العمليات</th>
                            </thead>
                            <tbody class="all_data">
                                @foreach ($data as $index => $info )
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                                        <td>{{ $info->name }}</td>
                                        {{-- ++++++++++++++++++ treasury_type ++++++++++++++++++ --}}
                                        <td>
                                            @if($info->is_master == 1) رئيسية @else فرعية @endif
                                        </td>
                                        {{-- ++++++++++++++++++ last_isal_exchange : اخر ايصال تم صرفه +++++++++++++++++ --}}
                                        <td>{{ $info->last_isal_exchange }}</td>
                                        {{-- ++++++++++++++++++ last_isal_collect : اخر ايصال تم تحصيله ++++++++++++++++++ --}}
                                        <td>{{ $info->last_isal_collect }}</td>
                                        {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                                        <td>
                                            @if($info->active==1) مفعل @else معطل @endif
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
                                                        <a href="{{ route('admin.treasury.show',$info->id) }}" class="dropdown-item" target="_blank">
                                                            <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                                        </a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        {{-- +++++++++ Edit Button +++++++++ --}}
                                                        <a href="{{ route('admin.treasury.edit',$info->id) }}" class="dropdown-item btn btn-sm  btn-primary" target="_blank">
                                                            <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                                        </a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        {{-- ========= Delete Button ========= --}}
                                                        <a type="button" class="dropdown-item btn btn-sm  btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#delete_treasury{{ $info->id }}" title="حذف">
                                                            <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- ++++++++++++ Delete Modal +++++++++++ --}}
                                    @include('admin.treasuries.partials.delete_modal')
                                @endforeach
                            </tbody>
                        </table>
                        {{-- ++++++++++++ Laravel Pagination +++++++++++ --}}
                        <div class="col-md-12"> {{ $data->links() }} </div>
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
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
@endsection
