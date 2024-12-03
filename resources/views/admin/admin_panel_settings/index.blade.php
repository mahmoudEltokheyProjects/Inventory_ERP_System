@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الضبط العام@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الضبط العام@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')الضبط@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">الضبط</a>
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
                <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
            </div>
            {{-- ============= card-body ============= --}}
            <div class="card-body">
                @if (@isset($data) && !@empty($data))
                    <table id="example2" class="table table-bordered table-hover">
                        {{-- ++++++++++++++++++ system_name ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">اسم الشركة</td>
                            <td > {{ $data['system_name'] }}</td>
                        </tr>
                        {{-- ++++++++++++++++++ com_code ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">كود الشركة</td>
                            <td > {{ $data['com_code'] }}</td>
                        </tr>
                        {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">حالة الشركة</td>
                            <td> @if($data['active']==1) مفعل @else معطل @endif</td>
                        </tr>
                        {{-- ++++++++++++++++++ address ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">عنوان الحي</td>
                            <td>
                                {{ $data['address'] }},
                            </td>
                        </tr>
                        {{-- ++++++++++++++++++ address ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">عنوان الشركة</td>
                            <td>
                                @if ($data->countries)
                                    {{ $data->countries->name }} ,
                                @endif
                                @if ($data->states)
                                    {{ $data->states->name }} ,
                                @endif
                                @if ($data->cities)
                                    {{ $data->cities->name }}
                                @endif
                            </td>
                        </tr>
                        {{-- ++++++++++++++++++ phone ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">هاتف الشركة</td>
                            <td> {{ $data['phone'] }}</td>
                        </tr>
                        {{-- ++++++++++++++++++ phone ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">البريد الالكتروني للشركة</td>
                            <td> {{ $data['email'] }}</td>
                        </tr>
                        {{-- ++++++++++++++++++ customer_parent_account_number ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30"> اسم الحساب المالي الاب للعملاء</td>
                            <td>
                                <span class="text-danger">{{ $data['customer_parent_account_name'] }}</span> رقم حساب مالي
                                (<span class="text-info">{{ $data['customer_parent_account_number'] }}</span>)
                            </td>
                        </tr>
                        {{-- ++++++++++++++++++ supplier_parent_account_number ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30"> اسم الحساب المالي الاب للموردين</td>
                            <td>
                                <span class="text-danger">{{ $data['supplier_parent_account_name'] }}</span> رقم حساب مالي
                                (<span class="text-info">{{ $data['supplier_parent_account_number'] }}</span>)
                            </td>
                        </tr>
                        {{-- ++++++++++++++++++ general_alert ++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">رسالة التنبية اعلي الشاشة للشركة</td>
                            <td> {{ $data['general_alert'] }}</td>
                        </tr>
                        <tr>
                            {{-- ++++++++++++++++++ photo ++++++++++++++++++ --}}
                            <td class="width30">صورة الشركة</td>
                            {{-- ++++++++++++++++++ Photo ++++++++++++++++++ --}}
                            <td>
                                <div class="image">
                                    @if ($data['photo'])
                                        <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}"  alt="صورة الشركة">
                                    @else
                                        <img class="custom_img" src="{{ asset('assets/admin/uploads/dash.jpg') }}"  alt="صورة الشركة">
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            {{-- ++++++++++++++++++ Logo ++++++++++++++++++ --}}
                            <td class="width30">لوجو الشركة</td>
                            {{-- ++++++++++++++++++ Logo ++++++++++++++++++ --}}
                            <td>
                                <div class="image">
                                    @if ($data['logo'])
                                        <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['logo'] }}"  alt="لوجو الشركة">
                                    @else
                                        <img class="custom_img" src="{{ asset('assets/admin/uploads/logo.png') }}"  alt="لوجو الشركة">
                                    @endif
                                </div>
                            </td>
                        </tr>
                        {{-- ++++++++++++++++++++++++ Last Update ++++++++++++++++++++++++ --}}
                        <tr>
                            <td class="width30">تاريخ اخر تحديث</td>
                            <td >
                                @if( $data['updated_by'] > 0 and $data['updated_by'] != null )
                                    @php
                                        $dt = new DateTime($data['updated_at']);
                                        $date = $dt->format("Y-m-d");
                                        $time = $dt->format("h:i");
                                        $newDateTime = date("A",strtotime($time));
                                        $newDateTimeType = (($newDateTime=='AM')?'صباحا ':'مساء');
                                    @endphp
                                {{ $date }}
                                {{ $time }}
                                {{ $newDateTimeType }}
                                    بواسطة
                                {{ $data['updated_by_admin'] }}
                                @else
                                    لايوجد تحديث
                                @endif
                                {{-- ====== Edit Button ====== --}}
                                <a href="{{ route('admin.adminPanelSetting.edit') }}" class="btn btn-sm btn-success">تعديل</a>
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
