@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')الخزن@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')اضافة خزنة@endsection
{{-- ++++++++ header ++++++++ --}}
@section('contentHeader')
    اضافة خزنة
    <i class="fa fa-cash-register"></i>
@endsection
{{-- ++++++++ header link ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">الخزن</a>
@endsection
{{-- ++++++++ active link ++++++++ --}}
@section('contentHeaderActiveLink')اضافة@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
            <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
        </div> --}}
         <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.treasury.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- ++++++++++++++++++ treasury_name ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>اسم الخزنة</label>
                        <input name="name" id="name" class="form-control" placeholder="ادخل اسم الشركة" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ treasury_type ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>نوع الخزنة</label>
                        <select name="is_master" id="is_master" class="form-control select2">
                            <option value="">اختر النوع</option>
                            <option {{ old('is_master') == 1  ? "selected" : "" }} value="1">رئيسية</option>
                            <option {{ old('is_master') == 0  ? "selected" : "" }} value="0">فرعية</option>
                        </select>
                        @error('is_master')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                    <div class="col-md-4 col-sm-6">
                        <label>حالة الخزنة</label>
                        <select name="active" id="active" class="form-control select2">
                            <option value="">اختر الحالة</option>
                            <option {{ old('active') == 1  ? "selected" : "" }} value="1"> مفعل</option>
                            <option {{ old('active') == 0  ? "selected" : "" }} value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br />
                <div class="row">
                    {{-- ++++++++++++++++++ last_isal_exchange : اخر ايصال تم صرفه +++++++++++++++++ --}}
                    {{-- oninput="this.value = this.value.replace(/[^0-9]/g,'');" : عدم السماح بكتابة اي شئ في حقل الادخال إلا الارقام فقط --}}
                    <div class="col-md-6 col-sm-6">
                        <label> اخر رقم ايصال صرف نقدية لهذة الخزنة</label>
                        <input name="last_isal_exchange" class="form-control" value="{{ old('last_isal_exchange') }}"
                               placeholder="ادخل اسم الشركة" oninput="this.value = this.value.replace(/[^0-9]/g,'');"  >
                        @error('last_isal_exchange')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ last_isal_collect : اخر ايصال تم تحصيله ++++++++++++++++++ --}}
                    <div class="col-md-6 col-sm-6">
                        <label> اخر رقم ايصال تحصيل نقدية لهذة الخزنة</label>
                        <input name="last_isal_collect" id="last_isal_collect" class="form-control" value="{{ old('last_isal_collect') }}" placeholder="ادخل اسم الشركة" oninput="this.value=this.value.replace(/[^0-9]/g,'');" >
                        @error('last_isal_collect')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> <br/>
                {{-- ++++++++++++++++++ Save , Cancel Button ++++++++++++++++++ --}}
                <div class="ؤخم-12 form-group">
                    <button type="submit" class="btn btn-primary"> اضافة</button>
                    <a href="{{ route('admin.treasury.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
