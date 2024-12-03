@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')عرض تفاصيل حساب مورد@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تفاصيل حسابات الموردين@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
حسابات الموردين&nbsp;<i class="fa fa-truck-field"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.suppliers.index') }}">حسابات الموردين</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')عرض@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        {{-- ============================== Store Details Table ============================== --}}
                        <table id="example1" class="table table-bordered table-hover">
                            {{-- ++++++++++++++++ supplier name ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">اسم المورد</td>
                                <td> {{ $data->name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ supplier_category_name ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">الفئة</td>
                                <td> {{ $data->supplier_category_name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ supplier code ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">كود المورد</td>
                                <td> {{ $data->supplier_code }}</td>
                            </tr>
                            {{-- ++++++++++++++++ account_type ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">نوع الحساب</td>
                                <td> {{ $data->account_types_name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ account_number ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">رقم الحساب</td>
                                <td> {{ $data->account_number }}</td>
                            </tr>
                            {{-- ++++++++++++++++++ "start_balance_status" ++++++++++++++++++ --}}
                            <tr>
                                <td>حالة رصيد اول مدة</td>
                                <td>
                                    @if( $data->start_balance_status == 1 )
                                    دائن
                                    @elseif( $data->start_balance_status == 2 )
                                    مدين
                                    @elseif( $data->start_balance_status == 3 )
                                    متزن
                                    @else
                                    لا يوجد
                                    @endif
                                </td>
                            </tr>
                            {{-- ++++++++++++++++++ "start_balance" ++++++++++++++++++ --}}
                            <tr>
                                <td>رصيد اول المدة  للحساب </td>
                                <td>{{ $data['start_balance'] }}</td>
                            </tr>
                            {{-- ++++++++++++++++ address ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">عنوان العميل</td>
                                <td> {{ $data->address }}</td>
                            </tr>
                            {{-- ++++++++++++++++ added_by ++++++++++++++++ --}}
                            <tr>
                                <td class="width30"> تاريخ الاضافة</td>
                                <td>
                                    @php
                                        $dt = new DateTime($data['created_at']);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i');
                                        $newDateTime = date('A', strtotime($time));
                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';
                                    @endphp
                                    {{ $date }}
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    بواسطة
                                    {{ $data['added_by_admin'] }}
                                </td>
                            </tr>
                            {{-- ++++++++++++++++ updated_by ++++++++++++++++ --}}
                            <tr>
                                <td class="width30"> تاريخ اخر تحديث</td>
                                <td>
                                    @if ($data->updated_by > 0 and $data->updated_by != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h:i');
                                            $newDateTime = date('A', strtotime($time));
                                            $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newDateTimeType }}
                                        بواسطة
                                        {{ $data->updated_by_admin }}
                                    @else
                                        لايوجد تحديث
                                    @endif
                                    {{-- ++++++++++ Edit Button ++++++++++ --}}
                                    <a href="{{ route('admin.suppliers.edit', $data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                    {{-- ++++++++++ Back Button ++++++++++ --}}
                                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-sm btn-info">عودة</a>

                                </td>
                            </tr>
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
    <!-- row closed -->
@endsection
