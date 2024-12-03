@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل الخزنة@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تعديل الخزنة@endsection
{{-- ++++++++ css ++++++++ --}}
@section("css")

@endsection
{{-- ++++++++ contentHeader ++++++++ --}}
@section('contentHeader')
    تعديل الخزنة
    <i class="fa fa-cash-register"></i>
@endsection
{{-- ++++++++ contentHeaderLink ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">الخزنة</a>
@endsection
{{-- ++++++++ contentHeaderActiveLink ++++++++ --}}
@section('contentHeaderActiveLink')تعديل@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="card">
    {{-- ============= card-body ============= --}}
    <div class="card-body">
        @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.treasury.update') }}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    {{-- ++++++++++++++ treasury_id hidden ++++++++++++++ --}}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{-- ++++++++++++++++++ treasury_name ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>اسم الخزنة</label>
                            <input name="name" id="name" class="form-control" value="{{ old('name', $data['name']) }}" placeholder="ادخل اسم الشركة">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ treasury_type ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>نوع الخزنة</label>
                            <select name="is_master" id="is_master" class="form-control">
                                <option value="">اختر النوع</option>
                                <option @if( old('is_master',$data['is_master']) == 1 ) selected="selected" @endif value="1">رئيسية</option>
                                <option @if( old('is_master',$data['is_master']) == 0 ) selected="selected" @endif value="0">فرعية</option>
                            </select>
                            @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>حالة الخزنة</label>
                            <select name="active" id="active" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option {{ old('active',$data['active']) == 1 ? 'selected' : ''}} value="1"> مفعل</option>
                                <option {{ old('active',$data['active']) == 0 ? 'selected' : ''}}  value="0">معطل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- ++++++++++++++++++ last_isal_exchange : اخر ايصال تم صرفه +++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label> اخر رقم ايصال صرف نقدية لهذة الخزنة</label>
                            <input name="last_isal_exchange" id="last_isal_exchange" class="form-control" value="{{ old('last_isal_exchange',$data['last_isal_exchange']) }}" placeholder="اخر ايصال تم صرفه" >
                            @error('last_isal_exchange')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ last_isal_collect : اخر ايصال تم تحصيله ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label> اخر رقم ايصال تحصيل نقدية لهذة الخزنة</label>
                        {{-- value="{{ old('last_isal_collect',$data['last_isal_collect']) }}" : هيظهر البيانات اللي جايه من قاعدة البيانات في البداية ولو حصل مشكلة اثناء حفظ البيانات فهيظهر لك البيانات القديمة اللي المستخدم دخلها --}}
                        <input name="last_isal_collect" id="last_isal_collect" class="form-control" value="{{ old('last_isal_collect',$data['last_isal_collect']) }}" placeholder="اخر ايصال تم تحصيله" />
                        @error('last_isal_collect')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br />
                {{-- ++++++++++++++++++ Edit Button ++++++++++++++++++ --}}
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                    </div>
                </div>
            </form>
        @else
            {{-- ++++++++++++++++++ Error Message ++++++++++++++++++ --}}
            <div class="alert alert-danger">
                عفوا لاتوجد بيانات لعرضها !!
            </div>
        @endif
    </div>
</div>
@endsection
@section("script")

@endsection
