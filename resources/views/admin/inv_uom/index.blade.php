@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')وحدات القياس@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')وحدات القياس@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
وحدات القياس &nbsp;<i class="fa fa-scale-balanced"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.stores.index') }}">عرض</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')وحدات القياس@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
    <div class="row">
        {{-- ++++++++++++++++++++++++++ Search ++++++++++++++++++++++++++ --}}
        <div class="col-12">
            <div class="row">
                {{-- Search Token --}}
                <input type="hidden" id="token_search" value="{{csrf_token() }}">
                {{-- Seach URL --}}
                <input type="hidden" id="ajax_search_url" value="{{ route('admin.uoms.ajax_search') }}">
                {{-- =========== search by name =========== --}}
                <div class="col-md-4">
                    <label>بحث بالاسم</label>
                    <input type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control">
                </div>
                {{-- =========== search by type =========== --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>بحث بالنوع</label>
                        <select name="is_master_search" id="is_master_search" class="form-control select2">
                            <option value="all"> بحث بالكل</option>
                            <option value="1"> وحدة اب</option>
                            <option value="0"> وحدة تجزئة</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- =========== Content =========== --}}
        <div class="col-12">
            <div class="card">
                {{-- ============= card-header : Inv uoms [ Inventory unit of measurments ]  ============= --}}
                <div class="card-header">
                    <h5 class="text-center">بيانات وحدات القياس للأصناف</h5>
                    {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
                    <a href="{{ route('admin.uoms.create') }}" class="btn btn-primary btn-md">
                        اضافة &nbsp; <i class="fa fa-plus"></i>
                    </a>
                </div>
                {{-- ============= card-body : uoms [ unit of measurments ]  ============= --}}
                <div class="card-body">
                    <div id="ajax_responce_serarchDiv">
                        @if (@isset($data) && !@empty($data) && count($data) >0 )
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم الوحدة</th>
                                    <th>نوع الوحدة</th>
                                    <th>حالة الوحدة</th>
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
                                            {{-- ++++++++++++++++++ type ++++++++++++++++++ --}}
                                            <td>
                                                @if($info->is_master==1) وحدة أب اساسية@else وحدة تجزئة فرعية@endif
                                            </td>
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
                                                            <a href="{{ route('admin.uoms.show',$info->id) }}" class="dropdown-item" target="_blank">
                                                                <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                                            </a>
                                                        </li>
                                                        <div class="dropdown-divider"></div>
                                                        <li>
                                                            {{-- +++++++++ Edit Button +++++++++ --}}
                                                            <a href="{{ route('admin.uoms.edit',$info->id) }}" class="dropdown-item btn btn-sm  btn-primary" target="_blank">
                                                                <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                                            </a>
                                                        </li>
                                                        <div class="dropdown-divider"></div>
                                                        <li>
                                                            {{-- ========= Delete Button ========= --}}
                                                            <a type="button" class="dropdown-item btn btn-sm  btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#delete_uoms{{ $info->id }}" title="حذف">
                                                                <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- ++++++++++++ Delete Modal +++++++++++ --}}
                                        @include('admin.inv_uom.partials.delete_modal')
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
    <script src="{{ asset('assets/admin/js/inv_uom.js') }}"></script>
@endsection
