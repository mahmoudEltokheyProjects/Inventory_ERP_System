@extends('layouts.admin')
@section('tab_title')
    تفاصيل الفئة
@endsection

@section('contentHeader')
    تفاصيل الفئة
    <i class="fa fa-store"></i>
@endsection

@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">الفئة</a>
@endsection

@section('contentHeaderActiveLink')
    الضبط العام
@endsection
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
                                <td class="width30">اسم الفئة</td>
                                <td> {{ $data->name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ status ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">حالة الفئة</td>
                                <td>
                                    @if ($data['active'] == 1)
                                        مفعل
                                    @else
                                        معطل
                                    @endif
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
                                    <a href="{{ route('admin.sales_material_types.edit', $data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                    {{-- ++++++++++ Back Button ++++++++++ --}}
                                    <a href="{{ route('admin.sales_material_types.index') }}" class="btn btn-sm btn-info">عودة</a>

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
