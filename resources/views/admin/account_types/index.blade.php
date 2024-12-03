@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الحسابات المالية@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')انواع الحسابات@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
انواع الحسابات &nbsp;<i class="fa fa-hand-holding-usd"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.accountTypes.index') }}">انواع الحسابات</a>
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
                <h5 class="text-center">بيانات انواع الحسابات</h5>
                {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
                {{-- <a href="{{ route('admin.accountTypes.create') }}" class="btn btn-primary btn-md">
                    اضافة &nbsp; <i class="fa fa-plus"></i>
                </a> --}}
            </div>
            {{-- ============= card-body ============= --}}
            <div class="card-body">
                @if (@isset($data) && !@empty($data) && count($data) >0 )
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>مسلسل</th>
                            <th>اسم نوع الحساب</th>
                            <th>الحالة</th>
                            <th>هل يُضاف من الشاشة الداخلية</th>
                            <th>تاريخ الاضافة</th>
                            {{-- <th>تاريخ التحديث</th> --}}
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
                                    {{-- ++++++++++++++++++ relatedInternalAccounts ++++++++++++++++++ --}}
                                    <td>
                                        @if($info->relatedInternalAccounts == 1)
                                            نعم و يُضاف من الشاشة الداخلية
                                        @else
                                            لا و يُضاف من شاشة الحسابات
                                        @endif
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
                                    {{-- <td>
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
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
