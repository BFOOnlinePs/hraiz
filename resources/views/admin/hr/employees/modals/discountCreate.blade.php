<div class="modal fade" id="create_discount_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('hr.employees.discounts.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة حسم للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="text" name="value_discountCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">العملة</label>
                                <select class="form-control select2bs4" name="currency_id_discountCreate" id="currency_id_discountCreate">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->currency_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea name="notes_discountCreate" id="" cols="5" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الملف المرفق</label>
                                <input type="file" name="attached_file_discountCreate" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">إضافة حسم</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
