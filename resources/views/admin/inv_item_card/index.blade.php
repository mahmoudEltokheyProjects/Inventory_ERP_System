@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')ضبط المخازن@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')الاصناف@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
الاصناف &nbsp; <i class="fa fa-table-list"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('inv_item_cards.index') }}">عرض</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')الاصناف@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
    <div class="row">
        {{-- ++++++++++++++++++++++++++ Search ++++++++++++++++++++++++++ --}}
        <div class="col-12 mb-2">
            <div class="row">
                {{-- Search Token --}}
                <input type="hidden" id="token_search" value="{{csrf_token() }}">
                {{-- Seach URL --}}
                <input type="hidden" id="ajax_search_url" value="{{ route('admin.item_card.ajax_search') }}">
                {{-- ////////////////// search by : "text" or "item_type" or "item_card_categories" ////////////////// --}}
                {{-- =========== search by : "name" or "barcode" or "item_code" =========== --}}
                <div class="col-md-4">
                    <label>بحث ب</label>
                    {{-- -------- radio button : "name" or "barcode" or "item_code" -------- --}}
                    {{-- "name" radionButton --}}
                    <input type="radio" name="search_by_text_radio" id="search_by_name_radio"      value="name" checked>
                    <label for="search_by_name_radio" style="font-weight:normal;">الاسم</label>
                    {{-- "barcode" radionButton --}}
                    <input type="radio" name="search_by_text_radio" id="search_by_barcode_radio"   value="barcode">
                    <label for="search_by_barcode_radio" style="font-weight:normal;">الباركود</label>
                    {{-- "item_code" radionButton --}}
                    <input type="radio" name="search_by_text_radio" id="search_by_item_code_radio" value="item_code">
                    <label for="search_by_item_code_radio" style="font-weight:normal;">الكود</label>
                    {{-- -------- search inputField -------- --}}
                    <input type="text" id="search_by_text" placeholder="اسم - باركود - كود الصنف" class="form-control">
                </div>
                {{-- ++++++++++++++++++ search by : item_type ++++++++++++++++++ --}}
                <div class="col-md-4 col-sm-12">
                    <label>بحث بنوع الصنف</label>
                    <select name="item_type_search" id="item_type_search" class="form-control">
                        <option value="all">بحث بالكل</option>
                        <option value="1"> مخزني</option>
                        <option value="2">استهلاكي بصلاحية</option>
                        <option value="3">عهدة</option>
                    </select>
                </div>
                {{-- ++++++++++++++++++ search by : item_card_categories ++++++++++++++++++ --}}
                <div class="col-md-4 col-sm-12">
                    <label>بحث بفئة الصنف</label>
                    <select name="inv_itemCard_category_id_search" id="inv_itemCard_category_id_search" class="form-control">
                        <option value="all">بحث بالكل</option>
                        @if ( @isset($inv_itemCard_categories) && !empty($inv_itemCard_categories) )
                            @foreach ($inv_itemCard_categories as $inv_itemCard_category)
                                <option value="{{ $inv_itemCard_category->id }}">{{ $inv_itemCard_category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        {{-- =========== Content =========== --}}
        <div class="col-12">
            <div class="card">
                {{-- ============= card-header : Inv uoms [ Inventory unit of measurments ]  ============= --}}
                <div class="card-header">
                    <h5 class="text-center">بيانات للأصناف</h5>
                    {{-- ++++++++++++++++ Create Button ++++++++++++++++ --}}
                    <a href="{{ route('inv_item_cards.create') }}" class="btn btn-primary btn-md">
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
                                    <th>الاسم</th>
                                    <th>النوع</th>
                                    <th>الفئة</th>
                                    <th>الحالة</th>
                                    <th>الصنف الاب</th>
                                    <th>الوحدة الاب</th>
                                    <th>وحدة التجزئه</th>
                                    <th>العمليات</th>
                                </thead>
                                <tbody class="all_data">
                                    @foreach ($data as $index => $info )
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                                            <td>{{ $info->name }}</td>
                                            {{-- ++++++++++++++++++ item_type ++++++++++++++++++ --}}
                                            <td>
                                                @if($info->item_type==1) مخزني
                                                @elseif($info->item_type==2) استهلاكي بصلاحية
                                                @elseif($info->item_type==3) عهدة
                                                @else غير محدد
                                                @endif
                                            </td>
                                            {{-- ++++++++++++++++++ inv_item_card_categories name ++++++++++++++++++ --}}
                                            <td>{{ $info->inv_item_card_categories_name }}</td>
                                            {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                                            <td>
                                                @if($info->active==1) مفعل @else معطل @endif
                                            </td>
                                            {{-- ++++++++++++++++++ parent_inv_item_card name ++++++++++++++++++ --}}
                                            <td>{{ $info->parent_inv_item_card_name }}</td>
                                            {{-- ++++++++++++++++++ uom_name ++++++++++++++++++ --}}
                                            <td>{{ $info->uom_name }}</td>
                                            {{-- ++++++++++++++++++ retial_uom_name ++++++++++++++++++ --}}
                                            <td>{{ $info->retial_uom_name }}</td>
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
                                                            <a href="{{ route('inv_item_cards.show',$info->id) }}" class="dropdown-item" target="_blank">
                                                                <i class="fa fa-eye text-warning"></i> &nbsp; عرض
                                                            </a>
                                                        </li>
                                                        <div class="dropdown-divider"></div>
                                                        <li>
                                                            {{-- +++++++++ Edit Button +++++++++ --}}
                                                            <a href="{{ route('inv_item_cards.edit',$info->id) }}" class="dropdown-item btn btn-sm  btn-primary" target="_blank">
                                                                <i class="fa fa-edit text-primary"></i> &nbsp; تعديل
                                                            </a>
                                                        </li>
                                                        <div class="dropdown-divider"></div>
                                                        <li>
                                                            {{-- ========= Delete Button ========= --}}
                                                            <a type="button" class="dropdown-item btn btn-sm  btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#delete_inv_item_cards{{ $info->id }}" title="حذف">
                                                                <i class="fa fa-trash text-danger"></i> &nbsp; حذف
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- ++++++++++++ Delete Modal +++++++++++ --}}
                                        @include('admin.inv_item_card.partials.delete_modal')
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
    <script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
@endsection
