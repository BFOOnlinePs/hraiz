<div class="modal fade" id="create-attendance-device">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('shipping_methods.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة نوع الشحن</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الاسم</label>
                                <input name="name" class="form-control" type="text"
                                       placeholder="اكتب الاسم" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="3" placeholder="ملاحظات"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>

            </div>
        </form>

    </div>
</div>
