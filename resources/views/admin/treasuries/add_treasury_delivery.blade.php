@extends('layouts.admin')
@section('tab_title')
    الخزن الفرعية
@endsection
@section('contentHeader')
    الخزن الفرعية للاستيلام
    <i class="fa fa-cash-register"></i>
@endsection
@section('contentHeaderLink')
    <a href="{{ route('admin.treasury.index') }}">الخزن الفرعية للاستيلام</a>
@endsection
@section('contentHeaderActiveLink')
    اضافة
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة خزن للاستيلام منها للخزنة : ({{ $main_treasury['name'] }})</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.treasury.store_treasury_delivery', $main_treasury->id) }}" method="post">
                        @csrf
                        {{-- ++++++++++++++++++ Sub_Treasuries Selectbox : الخزن الفرعية ++++++++++++++++++ --}}
                        <div class="col-4 form-group">
                            <label> اختر الخزنة الفرعية</label>
                            <select name="treasuries_can_delivery_id" id="treasuries_can_delivery_id" class="form-control select2">
                                <option value="">اختر الخزنة</option>
                                @if( isset($treasuries) && !empty($treasuries) )
                                    @foreach ($treasuries as $info)
                                        <option @if (old('treasuries_can_delivery_id') == $info->id) selected="selected" @endif
                                            value="{{ $info->id }}"> {{ $info->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('treasuries_can_delivery_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- ++++++++++++++++++ submit button ++++++++++++++++++ --}}
                        <div class="col-12 form-group text-center"> <br>
                            <button type="submit" class="btn btn-primary">اضافة </button>
                            <a href="#" class="btn btn-danger">الغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
