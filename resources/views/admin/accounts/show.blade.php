@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تفاصيل الحساب المالي@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تفاصيل الحساب المالي@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
تفاصيل الحساب المالي <i class="fa fa-truck-ramp-box"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.sales_material_types.index') }}">الحساب المالي</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')الحسابات@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        {{-- ============================== sales_material_types Details Table ============================== --}}
                        <table id="example1" class="table table-bordered table-hover">
                            {{-- ++++++++++++++++ name ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">اسم الحساب</td>
                                <td> {{ $data->name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ account_number ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">رقم الحساب</td>
                                <td> {{ $data->account_number }}</td>
                            </tr>
                            {{-- ++++++++++++++++ account_type ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">النوع</td>
                                <td>{{ $data->account_types_name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ is_parent ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">هل اب</td>
                                <td> @if( $data->is_parent == 1 ) نعم @else لا @endif </td>
                            </tr>
                            {{-- ++++++++++++++++ parent_account_name ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">الحساب الاب</td>
                                <td> {{ $data->parent_account_name }} </td>
                            </tr>
                            {{-- ++++++++++++++++++ start_balance_status ++++++++++++++++++ --}}
                            <tr class="col-md-6  col-sm-6">
                                <td class="width30">حالة رصيد اول مدة</td>
                                <td>
                                    @if($data->start_balance_status == 1)
                                    دائن
                                    @elseif($data->start_balance_status == 2)
                                    مدين
                                    @elseif($data->start_balance_status == 3)
                                    متزن
                                    @else
                                    غير محدد
                                    @endif
                                </td>
                            </tr>
                            {{-- ++++++++++++++++ start_balance ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">الرصيد الابتدائي</td>
                                <td> {{ $data->start_balance }} </td>
                            </tr>
                           {{-- ++++++++++++++++ current_balance ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">الرصيد الحالي</td>
                                <td> {{ $data->current_balance }} </td>
                            </tr>
                            {{-- ++++++++++++++++ status ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">حالة الفئة</td>
                                <td>
                                    @if ($data['active'] == 1) مفعل @else معطل @endif
                                </td>
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
                                    <a href="{{ route('admin.accounts.edit', $data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                    {{-- ++++++++++ Back Button ++++++++++ --}}
                                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-sm btn-info">عودة</a>

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





@endsection
