<div class="modal fade" id="create_treasury" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">

        {{-- +++++++++++++++ Succes Messages +++++++++++++++ --}}
        <div class="alert alert-success" id="success_msg" style="display: none;">
            تم الحفظ بنجاح
        </div>
        <form action="{{route('admin.treasury.store')}}" method="post" id="treasuryForm">
            {{method_field('POST')}}
            {{csrf_field()}}
            <div class="modal-content">
                {{-- +++++++++ modal-header +++++++++ --}}
                <div class="modal-header">
                    <h3 style="font-family: 'Cairo', sans-serif;"
                        class="modal-title" id="exampleModalLabel">
                        اضافة خزنة &nbsp;
                    <i class="fa fa-cash-register"></i>
                </h3>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- +++++++++ modal-body +++++++++ --}}
                <div class="modal-body">
                    <form action="{{ route('admin.treasury.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- ++++++++++++++++++ treasury_name ++++++++++++++++++ --}}
                            <div class="col-md-12 col-sm-12">
                                <label>اسم الخزنة</label>
                                <input name="name" id="name" class="form-control" placeholder="ادخل اسم الشركة" >
                                {{-- /// Error /// --}}
                                <small id="name_error" class="form-text text-danger"></small>
                            </div><br/>
                            {{-- ++++++++++++++++++ treasury_type ++++++++++++++++++ --}}
                            <div class="col-md-12 col-sm-12">
                                <label>نوع الخزنة</label>
                                <select name="is_master" id="is_master" class="form-control">
                                    <option value="">اختر النوع</option>
                                    <option value="1">رئيسية</option>
                                    <option value="0">فرعية</option>
                                </select>
                                {{-- /// Error /// --}}
                                <small id="is_master_error" class="form-text text-danger"></small>
                            </div> <br/>
                            {{-- ++++++++++++++++++ active ++++++++++++++++++ --}}
                            <div class="col-md-12 col-sm-12">
                                <label>حالة الخزنة</label>
                                <select name="active" id="active" class="form-control">
                                    <option value="">اختر الحالة</option>
                                    <option value="1"> مفعل</option>
                                    <option value="0">معطل</option>
                                </select>
                                {{-- /// Error /// --}}
                                <small id="active_error" class="form-text text-danger"></small>
                            </div> <br/>
                            {{-- ++++++++++++++++++ last_isal_exchange : اخر ايصال تم صرفه +++++++++++++++++ --}}
                            <div class="col-md-12 col-sm-12">
                                <label> اخر رقم ايصال صرف نقدية لهذة الخزنة</label>
                                <input name="last_isal_exchange" id="last_isal_exchange" class="form-control">
                                {{-- /// Error /// --}}
                                <small id="last_isal_exchange_error" class="form-text text-danger"></small> <br/>
                            </div>
                            {{-- ++++++++++++++++++ last_isal_collect : اخر ايصال تم تحصيله ++++++++++++++++++ --}}
                            <div class="col-md-12 col-sm-12">
                                <label> اخر رقم ايصال تحصيل نقدية لهذة الخزنة</label>
                                <input name="last_isal_collect" id="last_isal_collect" class="form-control" >
                                {{-- /// Error /// --}}
                                <small id="last_isal_collect_error" class="form-text text-danger"></small> <br/>
                            </div>
                        </div> <br/>
                    </form>
                </div>
                {{-- +++++++++ modal-footer +++++++++ --}}
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                        <button type="submit" class="btn btn-danger" id="save_treasury">حفظ</button>
                    </div>
                </div>
            </div>
        </form>
   </div>
</div>
    <script>
        $(document).on('click', '#save_treasury', function (e) {
            e.preventDefault();

            // Reset Validation Errors
            $('#name_error').text('');
            $('#is_master_error').text('');
            $('#active_error').text('');
            $('#last_isal_exchange_error').text('');
            $('#last_isal_collect_error').text('');

            var formData = new FormData($('#treasuryForm')[0]);

            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('admin.treasury.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data)
                {
                    if (data.status == true)
                    {
                        // +++++++++++ Hide "Create" Modal +++++++++++
                        $('#create_treasury').modal('hide');
                        // +++++++++++ Appear "Success" Message With toastr +++++++++++
                        toastr.success(data.msg, 'Success',
                        {
                            positionClass: 'toast-top-right', // Position of the toast container
                            closeButton: true, // Show close button
                            progressBar: true, // Show a progress bar
                            timeOut: 3000, // How long the toast will be displayed (in milliseconds)
                            extendedTimeOut: 1000, // Time to close after a user hovers over the toast (in milliseconds)
                        });
                        // Reset the form and success message on modal close
                        $('#treasuryForm').trigger('reset');
                    }
                },
                // Validation Error Messages
                error: function (reject)
                {
                    var response = reject.responseJSON;
                    console.log(response);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
    </script>

