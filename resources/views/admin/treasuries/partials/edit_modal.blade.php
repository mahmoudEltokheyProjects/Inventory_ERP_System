 {{-- +++++++++++++++++++++++++ Edit Modal +++++++++++++++++++++++++ --}}
 <div class="modal fade" id="edit{{ $Grade->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                    id="exampleModalLabel">
                    {{ trans('Grades_trans.edit_Grade') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- edit form -->
                <form action="{{ route('Grades.update', 'test') }}" method="post">
                    {{ method_field('patch') }}
                    @csrf
                    <div class="row">
                        <div class="col">
                            {{-- Arabic "Name" Label --}}
                            <label for="Name" class="mr-sm-2">
                                {{ trans('Grades_trans.stage_name_ar') }}:
                            </label>
                            {{-- Arabic "Name" InputField --}}
                            <input id="Name" type="text" name="Name"
                                class="form-control"
                                value="{{ $Grade->getTranslation('Name', 'ar') }}"
                                required>
                            {{-- "id" of "grade" --}}
                            <input id="id" type="hidden" name="id" class="form-control"
                                value="{{ $Grade->id }}">
                        </div>
                        <div class="col">
                            {{-- English "Name" Label --}}
                            <label for="Name_en" class="mr-sm-2">
                                {{ trans('Grades_trans.stage_name_en') }}:
                            </label>
                            {{-- English "Name" InputField --}}
                            <input  type="text" class="form-control"
                                    value="{{ $Grade->getTranslation('Name', 'en') }}"
                                    name="Name_en" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            for="exampleFormControlTextarea1">{{ trans('Grades_trans.Notes') }}
                            :</label>
                        <textarea class="form-control" name="Notes"
                            id="exampleFormControlTextarea1"
                            rows="3">{{ $Grade->Notes }}</textarea>
                    </div>
                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        <button type="submit"
                            class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
