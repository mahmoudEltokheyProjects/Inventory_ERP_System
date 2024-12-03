@extends('layouts.admin')
{{-- ++++++++ title ++++++++ --}}
@section('title')تعديل الضبط العام@endsection
{{-- ++++++++ tab_title ++++++++ --}}
@section('tab_title')تعديل الضبط العام@endsection
{{-- ++++++++ css ++++++++ --}}
@section("css")
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- ++++++++++++ Google Map : Search Box Style ++++++++++++ --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/checkout_google_map.css') }}">
@endsection
{{-- ++++++++ contentHeader ++++++++ --}}
@section('contentHeader')الضبط@endsection
{{-- ++++++++ contentHeaderLink ++++++++ --}}
@section('contentHeaderLink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">الضبط</a>
@endsection
{{-- ++++++++ contentHeaderActiveLink ++++++++ --}}
@section('contentHeaderActiveLink')تعديل@endsection
{{-- ++++++++ content ++++++++ --}}
@section('content')
<div class="card">
    {{-- ============= card-header ============= --}}
    <div class="card-header">
        <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
    </div>
    {{-- ============= card-body ============= --}}
    <div class="card-body">
        @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.adminPanelSetting.update') }}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    {{-- +++++++++++++++++++++++++++ Start : Google Map ++++++++++++++++++++++++++ --}}
                    <div id="map" style="height: 300px;width: 100%;" class="mb-3"></div>
                    {{-- ++++++++++++++++++ system_name ++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>اسم الشركة</label>
                            <input  name="system_name" id="system_name" class="form-control"
                                    value="{{ $data['system_name'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
                            @error('system_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ phone ++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>هاتف الشركة</label>
                            <input name="phone" id="phone" class="form-control" value="{{ $data['phone'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ email ++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>البريد الالكتروني للشركة</label>
                            <input name="email" id="email" class="form-control" value="{{ $data['email'] }}" placeholder="ادخل البريد الالكتروني للشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- =========== Countries ========= --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country_id">الدولة</label>
                            <select name="country_id" id="country_id" class="form-control select2">
                                <option value="">--اختر--</option>
                                @foreach ($countries as $id=>$name)
                                <option value="{{ $id }}" {{ isset($data) && $data->country_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- =========== States ========= --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="state_id">المحافظة</label>
                            <select name="state_id" id="state_id" class="form-control select2">
                                <option value="">--اختر--</option>
                                @foreach ($states as $id => $name)
                                    <option value="{{ $id }}" {{ isset($data) && $data->state_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- =========== cities ========= --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city_id">المدينة</label>
                            <select name="city_id" id="city_id" class="form-control select2">
                                <option value="">--اختر--</option>
                                @foreach ($cities as $id => $name)
                                    <option value="{{ $id }}" {{ isset($data) && $data->city_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- ++++++++++++++++++ "customer_parent_account_number" selectbox ++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>الحساب الاب للعملاء بالشجرة المحاسبية</label>
                            <select name="customer_parent_account_number" id="customer_parent_account_number" class="form-control">
                                <option value="">اختر الحساب</option>
                                @foreach ($parent_accounts as $info)
                                    <option {{ old('customer_parent_account_number', $data['customer_parent_account_number']) == $info->account_number ? 'selected' : ''}} value="{{ $info->account_number }}">{{ $info->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('customer_parent_account_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ "supplier_parent_account_number" selectbox ++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>الحساب الاب للموردين بالشجرة المحاسبية</label>
                            <select name="supplier_parent_account_number" id="supplier_parent_account_number" class="form-control">
                                <option value="">اختر الحساب</option>
                                @foreach ($parent_accounts as $info)
                                    <option {{ old('supplier_parent_account_number', $data['supplier_parent_account_number']) == $info->account_number ? 'selected' : ''}} value="{{ $info->account_number }}">{{ $info->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('supplier_parent_account_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++ general_alert ++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>رسالة تنبية اعلي الشاشة </label>
                            <input name="general_alert" id="general_alert" class="form-control" value="{{ $data['general_alert'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
                        </div>
                    </div>
                </div>
                <div class="row">

                    {{-- ++++++++++++++++++ address ++++++++++++++++++ --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>عنوان الحي</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Street address(e.g., 123 Main St)" value="{{ $data['address'] }}" rows="5">{{ $data['address'] }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- ++++++++++++++++++ photo ++++++++++++++++++ --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>صورة الشركة</label>
                            <div class="image">
                                <img class="custom_img" id="photo" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}"  alt="صورة الشركة"> &nbsp;&nbsp; &nbsp;&nbsp;
                                {{-- ///////// Change "image" button ///////// --}}
                                <button type="button" class="btn btn-sm btn-info" id="update_image">تغير الصورة</button>
                                <button type="button" class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_image"> الغاء</button>
                            </div>
                        </div>
                        {{-- Show "upload image" button --}}
                        <div id="oldImage"></div>
                    </div>
                    {{-- ++++++++++++++++++ logo ++++++++++++++++++ --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>شعار الشركة</label>
                            <div class="logo">
                                <img class="custom_img" id="logo" src="{{ asset('assets/admin/uploads').'/'.$data['logo'] }}"  alt="شعار الشركة"> &nbsp;&nbsp; &nbsp;&nbsp;
                                {{-- ///////// Change "logo" button ///////// --}}
                                <button type="button" class="btn btn-sm btn-success" id="update_logo">تغير الشعار</button>
                                <button type="button" class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_logo"> الغاء</button>
                            </div>
                        </div>
                        {{-- Show "upload Logo" button --}}
                        <div id="oldLogo"></div>
                    </div>
                </div>
                {{-- ++++++++++++++++++ back , Edit Button ++++++++++++++++++ --}}
                <div class="row">
                    <div class="col-md-12 mt-5 text-center">
                        <div class="col-4 mx-auto">
                            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                            <a href="{{ route('admin.adminPanelSetting.index') }}" class="btn btn-danger">الغاء</a>
                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
    <script src="{{ asset('assets/admin/js/general.js') }}"> </script>
    <script>
        // ===================== Initialize Select2 Elements =====================
        $('.select2').select2({
            theme: 'bootstrap4'
        });
        // ===================== ajax : get states and cities =====================
        $(document).ready(function() {
            // Fetch states when a country is selected
            $('#country_id').change(function()
            {
                var countryId = $(this).val();
                console.log("++++++++++++++++ country_id = "+countryId+" +++++++++++++++++++");
                $('#state_id').prop('disabled', true).empty().append('<option value="">اختر</option>');
                $('#city_id').prop('disabled', true).empty().append('<option value="">اختر</option>');

                if (countryId) {
                    $.ajax({
                        url: '{{ route("admin.adminPanelSetting.fetchStates") }}',
                        type: 'POST',
                        data: { country_id: countryId, _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            console.log("++++++++++++++++ States +++++++++++++++++++");
                            $.each(response.states, function(index, state) {
                                $('#state_id').append('<option value="'+ state.id +'">'+ state.name +'</option>');
                            });
                            $('#state_id').prop('disabled', false);
                        }
                    });
                }
            });

            // Fetch cities when a state is selected
            $('#state_id').change(function() {
                var stateId = $(this).val();
                console.log("++++++++++++++++ state_id = "+stateId+" +++++++++++++++++++");
                $('#city_id').prop('disabled', true).empty().append('<option value="">اختر</option>');

                if (stateId) {
                    $.ajax({
                        url: '{{ route("admin.adminPanelSetting.fetchCities") }}',
                        type: 'POST',
                        data: { state_id: stateId, _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            $.each(response.cities, function(index, city) {
                                $('#city_id').append('<option value="'+ city.id +'">'+ city.name +'</option>');
                            });
                            $('#city_id').prop('disabled', false);
                        }
                    });
                }
            });
            // Fetch states when a country is selected
            $('#city_id').change(function()
            {
                var cityId = $(this).val();
                console.log("++++++++++++++++ city_id = "+cityId+" +++++++++++++++++++");
            });
        });
    </script>
    {{-- +++++++++++++++++++++++++++ Start : Google Map ++++++++++++++++++++++++++ --}}
    <script src="{{ asset('assets/admin/js/checkout_google_map.js') }}"> </script>
    {{-- paid key1 = AIzaSyADcdGUrbItLUlAhBfR3nSywm-ExsQaShg --}}
    {{-- paid key2 = AIzaSyC0EQ6QULJfWd6dzfvTGgqXxYympBpDasw --}}
    {{-- test key = AIzaSyCNy6SIfJZYuMnk8Y1d2DWrlambAHvEq6o --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0EQ6QULJfWd6dzfvTGgqXxYympBpDasw&libraries=places&v=weekly&callback=initMap&debug" async defer></script>
    {{--  ++++++++++++++++++++++++++ End : Google Map ++++++++++++++++++++++++++ --}}
@endsection
