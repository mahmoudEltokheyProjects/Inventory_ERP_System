<div class="modal fade" id="delete_supplier{{$info->id}}" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
        <form action="{{route('admin.suppliers.delete')}}" method="post">
           {{method_field('DELETE')}}
           {{csrf_field()}}
            <div class="modal-content">
                {{-- +++++++++ modal-header +++++++++ --}}
                <div class="modal-header">
                        <h3 style="font-family: 'Cairo', sans-serif;"
                            class="modal-title" id="exampleModalLabel">حذف المورد</h3>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                {{-- +++++++++ modal-body +++++++++ --}}
                <div class="modal-body">
                    <h5> هل متاكد من عملية حذف المورد ؟ <span class="text-danger">{{$info->name}}</span></h5>
                    {{-- +++++++++ "customer_id" hidden inputField +++++++++ --}}
                    <input type="hidden" name="supplier_id" value="{{$info->id}}">
                </div>
                {{-- +++++++++ modal-footer +++++++++ --}}
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">غلق</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
