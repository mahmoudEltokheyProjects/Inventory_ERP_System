@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')ضبط المخازن@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')اضافة صنف@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
اضافة صنف جديد &nbsp; <i class="fa fa-table-list"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('inv_item_cards.index') }}">اضافة</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')الاصناف@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        <!-- /.card-header -->
        {{-- ++++++++++++ Notes : Inv uoms => [ Inventory unit of measurments ] ++++++++++++ --}}
        <div class="card-body">
            <form action="{{ route('inv_item_cards.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-2">
                    {{-- ++++++++++++++++++ barcode ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>باركود الصنف - في حالة عدم الادخال سيولد بشكل تلقائي</label>
                        <input name="barcode" id="barcode" class="form-control" placeholder="ادخل باركود الصنف" value="{{ old('barcode') }}">
                        @error('barcode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ name ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>اسم الصنف <span class="text-danger">*</span></label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم الصنف" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-2">
                    {{-- ++++++++++++++++++ item_type ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>نوع الصنف <span class="text-danger">*</span></label>
                        <select name="item_type" id="item_type" class="form-control select2">
                            <option value="">اختر النوع</option>
                            <option {{ old('item_type') == 1  ? "selected" : "" }} value="1"> مخزني</option>
                            <option {{ old('item_type') == 2  ? "selected" : "" }} value="2">استهلاكي بصلاحية</option>
                            <option {{ old('item_type') == 3  ? "selected" : "" }} value="3">عهدة</option>
                        </select>
                        @error('item_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ item_card_categories ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>فئة الصنف <span class="text-danger">*</span></label>
                        <select name="inv_itemCard_category_id" id="inv_itemCard_category_id" class="form-control select2">
                            <option value="">اختر الفئة</option>
                            @if ( @isset($inv_itemCard_categories) && !empty($inv_itemCard_categories) )
                                @foreach ($inv_itemCard_categories as $inv_itemCard_category)
                                    <option {{ old('inv_itemCard_category_id') == $inv_itemCard_category->id  ? "selected" : "" }} value="{{ $inv_itemCard_category->id }}">{{ $inv_itemCard_category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('inv_itemCard_category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="row mb-2">
                    {{-- ++++++++++++++++++ item_card parent ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>الصنف الاب له <span class="text-danger">*</span></label>
                        <select name="parent_inv_item_card_id" id="parent_inv_item_card_id" class="form-control select2">
                            <option selected value="0">هو اب</option>
                            @if ( @isset($item_card_data) && !empty($item_card_data) )
                                @foreach ($item_card_data as $item_card)
                                    <option {{ old('parent_inv_item_card_id') == $item_card->id  ? "selected" : "" }} value="{{ $item_card->id }}">{{ $item_card->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('parent_inv_item_card_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ inv_uom_parent ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>وحدة القياس الاب(الاساسية) <span class="text-danger">*</span></label>
                        <select name="inv_uom_parent_id" id="inv_uom_parent_id" class="form-control">
                            <option value="">اختر الوحدة</option>
                            @if ( @isset($inv_uom_parent) && !empty($inv_uom_parent) )
                                @foreach ($inv_uom_parent as $info)
                                    <option {{ old('inv_uom_parent_id') ==  $info->id  ? "selected" : "" }} value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('inv_uom_parent_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ item_type ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>هل للصنف وحدة تجزئه <span class="text-danger">*</span></label>
                        <select name="does_has_retail_unit" id="does_has_retail_unit" class="form-control">
                            <option value="">اختر</option>
                            <option {{ old('does_has_retail_unit') == 1  ? "selected" : "" }} value="1">نعم</option>
                            <option {{ old('does_has_retail_unit') == 0 && old('does_has_retail_unit') != ""  ? "selected" : "" }} value="0">لا</option>
                        </select>
                        @error('does_has_retail_unit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    {{-- ++++++++++++++++++ inv_uom_child : وحدة القياس التجزئه الابن بالنسبة للاب ++++++++++++++++++ --}}
                    {{-- "مش هيظهر إلا في حالة ان "الصنف ليه وحدة تجزئه --}}
                    <div class="col-md-6 col-sm-12" id="retial_uom_id_div" @if (old('does_has_retail_unit') == "") style="display:none;" @endif >
                        <label>
                            وحدة القياس التجزئه الابن بالنسبة للاب
                            (<span class="parent_uom_name_span text-danger"></span>)
                            <span class="text-danger">*</span>
                        </label><br />
                        <select name="retail_uom_id" id="retial_uom_id" class="form-control">
                            @if ( @isset($inv_uom_child) && !empty($inv_uom_child) )
                                <option value="">اختر الوحدة</option>
                                @foreach ($inv_uom_child as $info)
                                    <option {{ old('retial_uom_id') == $info->id  ? "selected" : "" }} value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('retial_uom_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ retail_uom_to_uom : عدد وحدات التجزئه بالوحدة الاب ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_retail_counter" @if (old('retial_uom_id') == "") style="display: none;" @endif >
                        <label>
                            عدد وحدات التجزئه
                            (<span class="child_uom_name_span text-info"></span>)
                            بالنسبة للاب
                            (<span class="parent_uom_name_span text-danger"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري--}}
                        <input name="retail_uom_to_uom" id="retail_uom_to_uom" class="form-control" placeholder="ادخل عدد وحدات التجزئه بالوحدة الاب" value="{{ old('retail_uom_to_uom') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('retail_uom_to_uom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- ======================== row : price , nos_gomla_price ======================== --}}
                <div class="row">
                    {{-- ++++++++++++++++++ price : السعر القطاعي بوحدة القياس الاساسية	++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_parent_counter" @if (old('inv_uom_parent_id')=='') style="display: none;" @endif >
                        <label>
                            السعر القطاعي بوحدة القياس الاساسية
                            (<span class="parent_uom_name_span text-danger"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="price" id="price" class="form-control" placeholder="ادخل السعر القطاعي بوحدة القياس الاساسية" value="{{ old('price') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ nos_gomla_price : سعر النص جملة قطاعي مع الوحدة الاساسية ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_parent_counter" @if (old('inv_uom_parent_id')=='') style="display: none;" @endif >
                        <label>
                            سعر النص جملة قطاعي مع الوحدة الاساسية
                            (<span class="parent_uom_name_span text-danger"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="nos_gomla_price" id="nos_gomla_price" class="form-control" placeholder="ادخل سعر النص جملة قطاعي مع الوحدة الاساسية" value="{{ old('nos_gomla_price') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('nos_gomla_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- ======================== row : gomla_price , cost_price ======================== --}}
                <div class="row">
                    {{-- ++++++++++++++++++ gomla_price : سعر الجملة بوحدة القياس الاساسية ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_parent_counter" @if (old('inv_uom_parent_id')=='') style="display: none;" @endif >
                        <label>
                            سعر الجملة بوحدة القياس الاساسية
                            (<span class="parent_uom_name_span text-danger"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="gomla_price" id="gomla_price" class="form-control" placeholder="سعر الجملة بوحدة القياس الاساسية" value="{{ old('gomla_price') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('gomla_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ cost_price : سعر تكلفة الشراء للصنف بوحدة القياس الاساسية ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_parent_counter" @if (old('inv_uom_parent_id')=='') style="display: none;" @endif >
                        <label>
                            سعر تكلفة الشراء للصنف بوحدة القياس الاساسية
                            (<span class="parent_uom_name_span text-danger"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="cost_price" id="cost_price" class="form-control" placeholder="سعر تكلفة الشراء للصنف بوحدة القياس الاساسية" value="{{ old('cost_price') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('cost_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- ======================== row : price_retail , nos_gomla_price ======================== --}}
                <div class="row">
                    {{-- ++++++++++++++++++ price_retail : السعر القطاعي بوحدة قياس التجزئه	++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_retail_counter" @if (old('retail_uom_to_uom')=='') style="display: none;" @endif >
                        <label>
                            السعر القطاعي بوحدة قياس التجزئه
                            (<span class="child_uom_name_span text-info"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="price_retail" id="price_retail" class="form-control" placeholder="السعر القطاعي بوحدة قياس التجزئه" value="{{ old('price_retail') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('price_retail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ nos_gomla_price_retail : سعر النص جملة قطاعي مع الوحدة التجزئه ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_retail_counter"  @if (old('retail_uom_to_uom')=='') style="display: none;" @endif >
                        <label>
                            سعر النص جملة قطاعي مع الوحدة التجزئه
                            (<span class="child_uom_name_span text-info"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="nos_gomla_price_retail" id="nos_gomla_price_retail" class="form-control" placeholder="سعر النص جملة قطاعي مع الوحدة التجزئه" value="{{ old('nos_gomla_price_retail') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('nos_gomla_price_retail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- ======================== row : gomla_price_retail , cost_price ======================== --}}
                <div class="row">
                    {{-- ++++++++++++++++++ gomla_price_retail : سعر الجملة بوحدة القياس التجزئه ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_retail_counter" @if (old('retail_uom_to_uom')=='') style="display: none;" @endif >
                        <label>
                            سعر الجملة بوحدة القياس التجزئه
                            (<span class="child_uom_name_span text-info"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="gomla_price_retail" id="gomla_price_retail" class="form-control" placeholder="سعر الجملة بوحدة القياس التجزئه" value="{{ old('gomla_price_retail') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('gomla_price_retail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ cost_price : سعر تكلفة الشراء للصنف بوحدة قياس التجزئه ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12 related_retail_counter" @if (old('retail_uom_to_uom')=='') style="display: none;" @endif>
                        <label>
                            سعر تكلفة الشراء للصنف بوحدة قياس التجزئه
                            (<span class="child_uom_name_span text-info"></span>)
                            <span class="text-danger">*</span>
                        </label>
                        {{--  oninput="this.value=this.value.replace(/[^0-9.]/g,'')" : هذا الحقل يقبل الارقام الصحيح والعشرية معني . هو قبول رقم عشري --}}
                        <input name="cost_price_retail" id="cost_price_retail" class="form-control" placeholder="سعر تكلفة الشراء للصنف بوحدة قياس التجزئه" value="{{ old('cost_price_retail') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                        @error('cost_price_retail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- ======================== row : has_fixed_price , status ======================== --}}
                <div class="row">
                    {{-- ++++++++++++++++++ has_fixed_price : هل للصنف سعر ثابت بالفواتير او قابل للتغيير بالفواتير ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>
                            هل للصنف سعر ثابت
                            <span class="text-danger">*</span>
                        </label>
                        <select name="has_fixed_price" id="has_fixed_price" class="form-control select2">
                            <option value="">اختر الحالة</option>
                            <option {{ old('has_fixed_price') == 1  ? "selected" : "" }} value="1">نعم سعر ثابت ولا يتغير بالفواتير</option>
                            <option {{ old('has_fixed_price') == 0 && old('has_fixed_price') != ""  ? "selected" : "" }} value="0">لا و قابل للتغيير بالفواتير</option>
                        </select>
                        @error('has_fixed_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ status ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-12">
                        <label>
                            الحالة
                            <span class="text-danger">*</span>
                        </label>
                        <select name="active" id="active" class="form-control select2">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active') == 0 && old('active') != ""  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br/>
                {{-- ======================== row : item image ======================== --}}
                <div class="row">
                    {{-- ++++++++++++++++++ item image ++++++++++++++++++ --}}
                    <div class="col-md-6" style="border:solid 5px #000 ; margin:10px;">
                        <div class="form-group">
                            <label> صورة الصنف ان وجدت</label>
                            {{-- item_image img --}}
                            <img id="uploadedimg" src="#" alt="uploaded img" style="width: 200px; height: 200px;">
                            {{-- item_image inputField --}}
                            <input onchange="readURL(this)" type="file" id="Item_img" name="photo" class="form-control">
                            @error('uploadedimg')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" id="do_add_item_cards"> اضافة</button>
                    <a href="{{ route('inv_item_cards.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
@endsection
