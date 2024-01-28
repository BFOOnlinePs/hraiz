<div class="modal fade" id="create_salary_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('hr.attendance.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة راتب للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الموظف</label>
                                <select class="form-control select2bs4" name="user_id_salaryCreate">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">صافي الراتب</label>
                                <input type="text" name="net_salary_salaryCreate" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3>الأرباح</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">الأساسي</label>
                                <input type="number" name="basic_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">بدل الغلاء</label>
                                <input type="number" name="dearness_allowance_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">بدل إيجار السكن</label>
                                <input type="number" name="house_rent_allowance_salaryCreate" class="form-control">
                            </div>
                        </div>       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">بدل مواصلات</label>
                                <input type="number" name="conveyance_allowance_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">بدل</label>
                                <input type="number" name="allowance_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">بدل رعاية طبية</label>
                                <input type="number" name="medical_allowance_salaryCreate" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3>الخصومات</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">ضريبة الدخل المستقطعة</label>
                                <input type="number" name="TDS_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">التأمين الاجتماعي للموظفين</label>
                                <input type="number" name="ESI_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">صندوق التوفير</label>
                                <input type="number" name="PF_salaryCreate" class="form-control">
                            </div>
                        </div>       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">الإجازة وتأثيرها على الراتب</label>
                                <input type="number" name="leave_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">ضريبة المهنة</label>
                                <input type="number" name="prof_tax_salaryCreate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">رفاهية العمال</label>
                                <input type="number" name="labour_welfare_salaryCreate" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">إضافة الراتب</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
