@extends('layouts.admin')
@section('tab_title')
الضبط العام 
@endsection

@section('contentHeader')
    تفاصيل الخزنة
    <i class="fa fa-vault"></i>
@endsection

@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">الخزنة</a>
@endsection

@section('contentHeaderActiveLink')
    عرض تفاصيل الخزنة
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        {{-- ============================== Treasury Details Table ============================== --}}
                        <table id="example1" class="table table-bordered table-hover">
                            {{-- ++++++++++++++++ treasury name ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">اسم الخزنة</td>
                                <td> {{ $data->name }}</td>
                            </tr>
                            {{-- ++++++++++++++++ last_isal_exchange ++++++++++++++++ --}}
                            <tr>
                                <td class="width30"> اخر ايصال صرف</td>
                                <td> {{ $data->last_isal_exchange }}</td>
                            </tr>
                            {{-- ++++++++++++++++ last_isal_collect ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">اخر ايصال تحصيل</td>
                                <td> {{ $data->last_isal_collect }}</td>
                            </tr>
                            {{-- ++++++++++++++++ treasury type ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">نوع الخزنة</td>
                                <td>
                                    @if ($data['is_master'] == 1)
                                        رئيسية
                                    @else
                                        فرعية
                                    @endif
                                </td>
                            </tr>
                            {{-- ++++++++++++++++ status ++++++++++++++++ --}}
                            <tr>
                                <td class="width30">حالة الخزنة</td>
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
                                    <a href="{{ route('admin.treasury.edit', $data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                    {{-- ++++++++++ Back Button ++++++++++ --}}
                                    <a href="{{ route('admin.treasury.index') }}" class="btn btn-sm btn-info">عودة</a>

                                </td>
                            </tr>

                        </table>
                        {{-- ============================== Treasury Deliveries Table ============================== --}}
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title card_title_center">الخزن الفرعية التي سوف تسلم عهدتها الي الخزنة : ( {{ $data->name }} )
                                            <a href="{{ route('admin.treasury.add_treasury_delivery',$data->id) }}" class="btn btn-sm btn-primary" target="_blank">اضافة جديد</a>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        @if( @isset($treasury_delivery) && !@empty($treasury_delivery) )
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead class="custom_thead">
                                                <th>مسلسل</th>
                                                <th>اسم الخزنة</th>
                                                <th>تاريخ الاضافة</th>
                                                <th>العمليات</th>
                                            </thead>
                                            <tbody class="all_data">
                                                @foreach ($treasury_delivery as $index => $info )
                                                    <tr>
                                                        <td>{{ $index+1 }}</td>
                                                        {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                                                        <td>{{ $info->name }}</td>
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
                                                        {{-- ++++++++++++++++++ delete button ++++++++++++++++++ --}}
                                                        <td>
                                                            <a type="button" class="dropdown-item btn btn-sm btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#delete_treasury{{ $info->id }}" title="حذف">
                                                                <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    {{-- ++++++++++++ Delete Modal +++++++++++ --}}
                                                    @include('admin.treasuries.partials.delete_treasury_delivery_modal')
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
