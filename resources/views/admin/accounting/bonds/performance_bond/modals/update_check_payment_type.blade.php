<div class="modal fade" id="update_check_payment_type_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('accounting.purchase_invoices.create_purchase_invoices_from_order') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">معلومات الشيك</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">رقم الشيك</label>
                                <input type="text" id="check_number_edit" class="form-control" placeholder="رقم الشيك">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ الاستحقاق</label>
                                <input type="date" id="due_date_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم البنك</label>
                                <input name="bank_name" id="bank_name_edit" type="text" class="form-control" placeholder="اسم البنك">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    {{-- <button type="submit" class="btn btn-primary">حفظ</button> --}}
                </div>

            </div>
        </form>

    </div>
</div>
