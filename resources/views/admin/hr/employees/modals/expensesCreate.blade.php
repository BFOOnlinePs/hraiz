<div class="modal fade" id="create_expenses_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('users.employees.expenses.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة مصروف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ المصروف</label>
                                <input type="date" value="{{ date('Y-m-d') }}" name="expense_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">القسم</label>
                                <select class="form-control" name="category_id" id="">
                                    @foreach($expenses_categories as $key)
                                        <option value="{{ $key->id }}">{{ $key->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="number" name="amount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">النص</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">المرفق</label>
                                <input type="file" name="files" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="checkbox">التكرار</label>
                                    <input type="checkbox" id="checkbox" onchange="if_checked(this.value)">
                                </div>
                            </div>
                            <div style="display: none" id="recurring_form" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">التكرار خلال</label>
                                            <input type="text" name="repeat_every" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">خلال</label>
                                            <select class="form-control" name="repeat_type" id="">
                                                <option value="days">يوم</option>
                                                <option value="weeks">اسبوع</option>
                                                <option value="months">شهر</option>
                                                <option value="years">سنة</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">الدورة</label>
                                            <input type="text" id="no_of_cycles" name="no_of_cycles" class="form-control" placeholder="الدورة">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">إضافة مصروف</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
