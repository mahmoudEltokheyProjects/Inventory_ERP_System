@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الضبط العام@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')المخازن@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
المخازن<i class="fa fa-store"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.stores.index') }}">المخازن</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')الضبط العام@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- ============= card-header ============= --}}
            <div class="card-header">
                <h4 class="text-center">بيانات المخازن</h4>
                {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
                <a href="{{ route('admin.stores.create') }}" class="btn btn-primary btn-md">
                    اضافة &nbsp; <i class="fa fa-plus"></i>
                </a>
            </div>
            {{-- ============= card-body ============= --}}
            <div class="card-body">
                @if (@isset($data) && !@empty($data) && count($data) >0 )
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>مسلسل</th>
                            <th>الاسم</th>
                            <th>الحالة</th>
                            <th>الهاتف</th>
                            <th>العنوان</th>
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
                                    {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                                    <td>
                                        @if($info->active==1) مفعل @else معطل @endif
                                    </td>
                                    {{-- ++++++++++++++++++ phone ++++++++++++++++++ --}}
                                    <td>
                                        {{ $info->phone }}
                                    </td>
                                    {{-- ++++++++++++++++++ address ++++++++++++++++++ --}}
                                    <td>
                                        {{ $info->address }}
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
                                                    <a href="{{ route('admin.stores.show',$info->id) }}" class="dropdown-item" target="_blank">
                                                        <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                                    </a>
                                                </li>
                                                <div class="dropdown-divider"></div>
                                                <li>
                                                    {{-- +++++++++ Edit Button +++++++++ --}}
                                                    <a href="{{ route('admin.stores.edit',$info->id) }}" class="dropdown-item btn btn-sm  btn-primary" target="_blank">
                                                        <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                                    </a>
                                                </li>
                                                <div class="dropdown-divider"></div>
                                                <li>
                                                    {{-- ========= Delete Button ========= --}}
                                                    <a type="button" class="dropdown-item btn btn-sm  btn-danger"
                                                        data-toggle="modal"
                                                        data-target="#delete_store{{ $info->id }}" title="حذف">
                                                        <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                {{-- ++++++++++++ Delete Modal +++++++++++ --}}
                                @include('admin.stores.partials.delete_modal')
                            @endforeach
                        </tbody>
                    </table>
                    {{-- ++++++++++++ Laravel Pagination +++++++++++ --}}
                    <div class="col-md-12 mt-3"> {{ $data->links() }} </div>
                @else
                    <div class="alert alert-danger">
                        عفوا لاتوجد بيانات لعرضها !!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
