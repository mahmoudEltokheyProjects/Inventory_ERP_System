{{-- ===================================== Show Search Result ===================================== --}}
@if (@isset($data) && !@empty($data) && count($data) > 0)
    <table id="example2" class="table table-bordered table-hover">
        {{-- +++++++++++++++++++ thead +++++++++++++++++++ --}}
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
        {{-- +++++++++++++++++++ tbody +++++++++++++++++++ --}}
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
    {{-- ++++++++++++ Ajax Search Pagination +++++++++++ --}}
    <div class="col-md-12" id="ajax_pagination_in_search">
        {{ $data->links() }}
    </div>
@else
    <div class="alert alert-danger">
        عفوا لاتوجد بيانات لعرضها !!
    </div>
@endif
