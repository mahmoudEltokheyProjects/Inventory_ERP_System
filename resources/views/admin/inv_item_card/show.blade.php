@extends('layouts.admin')
@section('tab_title')
تفاصيل الصنف
@endsection

@section('contentHeader')
    تفاصيل الصنف
    <i class="fa fa-boxes"></i>
@endsection

@section('contentHeaderLink')
    <a href="{{ route('inv_item_card_categories.index') }}">فئات الاصناف</a>
@endsection

@section('contentHeaderActiveLink')
    عرض تفاصيل الصنف
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-body">
                        <div class="tab nav-border">
                            {{-- ==================== Tab_Panel Header ==================== --}}
                            <ul class="nav nav-tabs" role="tablist">
                                {{-- +++++++++ Tab1 : تفاصيل الصنف +++++++++ --}}
                                <li class="nav-item">
                                    <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                       role="tab" aria-controls="home-02"
                                       aria-selected="true">تفاصيل الصنف
                                    </a>
                                </li>
                                {{-- +++++++++ Tab2 : وحدات الصنف +++++++++ --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02"
                                       role="tab" aria-controls="profile-02"
                                       aria-selected="false">وحدات الصنف</a>
                                </li>
                                {{-- +++++++++ Tab3 : الاسعار +++++++++ --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-03-tab" data-toggle="tab" href="#profile-03"
                                       role="tab" aria-controls="profile-03"
                                       aria-selected="false">الاسعار</a>
                                </li>
                                @if ($info->photo !='')
                                    {{-- +++++++++ Tab4 : المرفقات +++++++++ --}}
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-04-tab" data-toggle="tab" href="#profile-04"
                                        role="tab" aria-controls="profile-04"
                                        aria-selected="false">المرفقات</a>
                                    </li>
                                @endif
                            </ul>
                            {{-- =========================== Tab_Panel Body =========================== --}}
                            <div class="tab-content">
                                {{-- /////////////// Tab1 Body : تفاصيل الصنف /////////////// --}}
                                <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                     aria-labelledby="home-02-tab">
                                    <table class="table table-striped table-hover" style="text-align:center">
                                        <tbody>
                                            {{-- +++++++++++ Row 1 +++++++++++ --}}
                                            <tr>
                                                <!-- barcode -->
                                                <th scope="row" style="width: 15%;">باركود الصنف</th>
                                                <td style="width: 15%;">{{ $info->barcode }}</td>
                                            </tr>
                                            <tr>
                                                <!-- barcode -->
                                                <th scope="row" style="width: 15%;">كود الصنف</th>
                                                <td style="width: 15%;">{{ $info->item_code }}</td>
                                            </tr>
                                            <tr>
                                                <!-- name -->
                                                <th scope="row" style="width: 15%;">اسم الصنف</th>
                                                <td style="width: 15%;">{{ $info->name }}</td>
                                            </tr>
                                            <tr>
                                                <!-- item_type -->
                                                <th scope="row" style="width: 15%;">نوع الصنف</th>
                                                <td style="width: 15%;">
                                                    @if ($info->item_type == 1) {{ 'مخزني' }}
                                                    @elseif($info->item_type == 2) {{ 'استهلاكي بصلاحية' }}
                                                    @elseif($info->item_type == 3) {{ 'عهدة' }}
                                                    @else {{ 'غير محدد' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- inv_item_card_categories_id -->
                                                <th scope="row" style="width: 15%;">فئة الصنف</th>
                                                <td style="width: 15%;">{{ $info->inv_item_card_categories->name }}</td>
                                            </tr>
                                            {{-- +++++++++++ Row 11 +++++++++++ --}}
                                            <tr>
                                                <!-- active -->
                                                <th scope="row" style="width: 15%;">
                                                    تاريخ الاضافة
                                                </th>
                                                <td style="width: 15%;">
                                                   {{-- ++++++++++++++++++ created_at ++++++++++++++++++ --}}
                                                    @if( $info->added_by  > 0 && $info->added_by != null )
                                                        @php
                                                            $dt   = new DateTime($info->created_at);
                                                            $date = $dt->format('Y-m-d');
                                                            $time = $dt->format('H:i');
                                                            $newDateTime = date("A",strtotime($time));
                                                            $newDateTimeType = (($newDateTime == 'AM') ? 'صباحا' : 'مساءا')
                                                        @endphp
                                                        {{ $date }}
                                                        {{ $time }}
                                                        {{ $newDateTimeType }}
                                                        بواسطة
                                                        {{ $info->added_by_admin }}
                                                    @else
                                                        لايوجد
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- +++++++++++ Row 11 +++++++++++ --}}
                                            <tr>
                                                <!-- active -->
                                                <th scope="row" style="width: 15%;">
                                                    تاريخ اخر تحديث
                                                </th>
                                                <td style="width: 15%;">
                                                   {{-- ++++++++++++++++++ updated_at ++++++++++++++++++ --}}
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
                                                        {{ $newDateTimeType }}
                                                        بواسطة
                                                        {{ $info->updated_by_admin }}
                                                    @else
                                                        لايوجد تحديث
                                                    @endif
                                                    {{-- ++++++++++ Edit Button ++++++++++ --}}
                                                    <a href="{{ route('inv_item_cards.edit', $info['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- /////////////// Tab2 Body : وحدات الصنف /////////////// --}}
                                <div class="tab-pane fade" id="profile-02" role="tabpanel"
                                     aria-labelledby="profile-02-tab">
                                     <table class="table table-striped table-hover" style="text-align:center">
                                        <tbody>
                                            {{-- +++++++++++ Row 1 +++++++++++ --}}
                                            <tr>
                                                <!-- parent_inv_item_card_id -->
                                                <th scope="row" style="width: 15%;">الصنف الاب له</th>
                                                <td style="width: 15%;">
                                                    {{ $info->parent_inv_item_card_id == 0 ? 'هو اب' : $info['Uom_name'] }}
                                                </td>
                                            </tr>
                                            {{-- +++++++++++ Row 2 +++++++++++ --}}
                                            <tr>
                                                <!-- inv_uom_parent_id -->
                                                <th scope="row" style="width: 15%;">وحدة القياس الاب(الاساسية)</th>
                                                <td style="width: 15%;">{{ $info->inv_uom_parent->name }}</td>
                                            </tr>
                                            {{-- +++++++++++ Row 3 +++++++++++ --}}
                                            <tr>
                                                <!-- does_has_retail_unit -->
                                                <th scope="row" style="width: 15%;">هل للصنف وحدة تجزئه </th>
                                                <td style="width: 15%;">
                                                    @if ($info->does_has_retail_unit == 1) {{ 'نعم' }}
                                                    @else {{ 'لا' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- لو الصنف له وحدة تجزئه --}}
                                            @if ($info->does_has_retail_unit == 1)
                                                <tr>
                                                    <!-- retail_uom_id -->
                                                    <th scope="row" style="width: 15%;">وحدة القياس التجزئه الابن بالنسبة للاب</th>
                                                    <td style="width: 15%;">{{ $info['retail_uom_name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <!-- retail_uom_to_uom -->
                                                    <th scope="row" style="width: 15%;">عدد وحدات التجزئه بالنسبة للاب</th>
                                                    {{-- ضربة في 1 عشان اشيل الاصفار اللي بعد العلامة العشرية --}}
                                                    <td style="width: 15%;">{{ $info->retail_uom_to_uom*1 }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{-- /////////////// Tab3 Body : الاسعار /////////////// --}}
                                <div class="tab-pane fade" id="profile-03" role="tabpanel"
                                     aria-labelledby="profile-03-tab">
                                     <table class="table table-striped table-hover" style="text-align:center">
                                        <tbody>
                                            {{-- ---------------- الوحدة الاساسية -------------- --}}
                                            {{-- +++++++++++ Row 1 +++++++++++ --}}
                                            <tr>
                                                <!-- price -->
                                                <th scope="row" style="width: 15%;">السعر القطاعي بوحدة القياس الاساسية
                                                    (<span class="text-danger">{{ $info['Uom_name'] }}</span>)
                                                </th>
                                                <td style="width: 15%;">
                                                    {{ $info->price}}
                                                </td>
                                            </tr>
                                            {{-- +++++++++++ Row 2 +++++++++++ --}}
                                            <tr>
                                                <!-- gomla_price -->
                                                <th scope="row" style="width: 15%;">سعر الجملة بوحدة القياس الاساسية
                                                    (<span class="text-danger">{{ $info['Uom_name'] }}</span>)
                                                </th>
                                                <td style="width: 15%;">{{ $info->gomla_price }}</td>
                                            </tr>
                                            {{-- +++++++++++ Row 3 +++++++++++ --}}
                                            <tr>
                                                <!-- nos_gomla_price -->
                                                <th scope="row" style="width: 15%;">
                                                    سعر النص جملة قطاعي مع الوحدة الاساسية
                                                    (<span class="text-danger">{{ $info['Uom_name'] }}</span>)
                                                </th>
                                                <td style="width: 15%;">{{ $info->nos_gomla_price }}</td>
                                            </tr>
                                            {{-- +++++++++++ Row 4 +++++++++++ --}}
                                            <tr>
                                                <!-- cost_price -->
                                                <th scope="row" style="width: 15%;">سعر تكلفة الشراء للصنف بوحدة القياس الاساسية
                                                    (<span class="text-danger">{{ $info['Uom_name'] }}</span>)
                                                </th>
                                                <td style="width: 15%;">
                                                    {{ $info->cost_price }}
                                                </td>
                                            </tr>
                                            {{-- ---------------- وحدة التجزئه -------------- --}}
                                            {{-- لو الصنف له وحدة تجزئه --}}
                                            @if ($info->does_has_retail_unit == 1)
                                                {{-- +++++++++++ Row 5 +++++++++++ --}}
                                                <tr>
                                                    <!-- price_retail -->
                                                    <th scope="row" style="width: 15%;">السعر القطاعي بوحدة قياس التجزئه
                                                        (<span class="text-info">{{ $info['retail_uom_name'] }}</span>)
                                                    </th>
                                                    <td style="width: 15%;">{{ $info->price_retail }}</td>
                                                </tr>
                                                {{-- +++++++++++ Row 6 +++++++++++ --}}
                                                <tr>
                                                    <!-- gomla_price_retail -->
                                                    <th scope="row" style="width: 15%;">سعر الجملة بوحدة القياس التجزئه
                                                        (<span class="text-info">{{ $info['retail_uom_name'] }}</span>)
                                                    </th>
                                                    <td style="width: 15%;">{{ $info->gomla_price_retail }}</td>
                                                </tr>
                                                {{-- +++++++++++ Row 7 +++++++++++ --}}
                                                <tr>
                                                    <!-- nos_gomla_price_retail -->
                                                    <th scope="row" style="width: 15%;">
                                                        سعر النص جملة قطاعي مع الوحدة التجزئه
                                                        (<span class="text-info">{{ $info['retail_uom_name'] }}</span>)
                                                    </th>
                                                    <td style="width: 15%;">{{ $info->nos_gomla_price_retail }}</td>
                                                </tr>
                                                {{-- +++++++++++ Row 8 +++++++++++ --}}
                                                <tr>
                                                    <!-- cost_price_retail -->
                                                    <th scope="row" style="width: 15%;">
                                                        سعر تكلفة الشراء للصنف بوحدة قياس التجزئه
                                                        (<span class="text-info">{{ $info['retail_uom_name'] }}</span>)
                                                    </th>
                                                    <td style="width: 15%;">{{ $info->cost_price_retail }}</td>
                                                </tr>
                                            @endif
                                             {{-- +++++++++++ Row 9 +++++++++++ --}}
                                             <tr>
                                                <!-- has_fixed_price -->
                                                <th scope="row" style="width: 15%;">
                                                    هل للصنف سعر ثابت
                                                </th>
                                                <td style="width: 15%;">
                                                    @if ($info->has_fixed_price == 1) {{ 'نعم' }}
                                                    @else {{ 'لا' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- +++++++++++ Row 10 +++++++++++ --}}
                                            <tr>
                                                <!-- active -->
                                                <th scope="row" style="width: 15%;">
                                                    حالة الصنف
                                                </th>
                                                <td style="width: 15%;">
                                                    @if ($info->active == 1) {{ ' مفعل' }}
                                                    @else {{ 'معطل' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if ($info->photo !='')
                                    {{-- /////////////// Tab4 Body : مرفقات الصنف /////////////// --}}
                                    <div class="tab-pane fade" id="profile-04" role="tabpanel"
                                        aria-labelledby="profile-04-tab">
                                        <table class="table center-aligned-table mb-0 table table-hover" style="text-align:center">
                                            <thead>
                                                <tr class="table-secondary">
                                                    <th scope="col">اسم الصورة</th>
                                                    <th scope="col">الصورة</th>
                                                    <th scope="col">العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style='text-align:center;vertical-align:middle'>
                                                    <td>{{$info->photo}}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/admin/uploads/item_card/'.$info->photo) }}" alt="image" style="width:300px;height:200px;">
                                                    </td>
                                                    <td>
                                                        {{-- +++++++++++++++++++ عرض +++++++++++++++++++ --> --}}
                                                        <a class="btn btn-outline-warning btn-sm"
                                                            target="_blank" role="button"
                                                            href="{{ route('admin.item_card.view_attachment',$info->photo) }}">
                                                            <i class="fa fa-eye"></i>&nbsp; عرض
                                                        </a>
                                                        {{-- ++++++++++++++++++ Download Button ++++++++++++++++++ --}}
                                                        <a class="btn btn-outline-info btn-sm"
                                                            href="{{ route('admin.item_card.Download_attachment',$info->photo) }}" role="button"
                                                            role="button">
                                                            <i class="fa fa-download"></i>&nbsp; تنزيل
                                                        </a>
                                                        {{-- ++++++++++++++++++ Delete Button ++++++++++++++++++ --}}
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#delete_item_photo_cards{{ $info->id }}"
                                                                title="حذف الصورة">حذف
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- ++++++++++++ Delete Modal +++++++++++ --}}
                                                @include('admin.inv_item_card.partials.delete_photo_modal')
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- row closed -->
@endsection
