@extends('home')
@section('title')
    سند قبض
@endsection
@section('header_title')
    سند قبض
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    سند قبض
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-dark" data-toggle="modal"
                    data-target="#create_payment_bond_modal">اضافة سند قبض
            </button>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">رقم الفاتورة</label>
                        <input onkeyup="bonds_table_ajax()" class="form-control" id="invoice_number" type="text"
                               placeholder="رقم الفاتورة">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">نوع الدفعة</label>
                        <select onchange="bonds_table_ajax()" class="form-control" name="" id="payment_type">
                            <option value="">جميع انواع الدفع</option>
                            <option value="cash">كاش</option>
                            <option value="check">شيك</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">اضيفت بواسطة</label>
                        <select class="form-control" onchange="bonds_table_ajax()" name="" id="insert_by">
                            <option value="">جميع المستخدمين</option>
                            @foreach($users as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">العميل</label>
                        <select onchange="bonds_table_ajax()" class="form-control select2bs4" name="" id="client_id">
                            <option value="">جميع العملاء ...</option>
                            @foreach($clients as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" id="bonds_table">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.bonds.payment_bond.modals.create_payment_bond_modal')
    @include('admin.accounting.bonds.payment_bond.modals.update_check_payment_type')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            bonds_table_ajax();
        });

        $('input[name="customRadio"]').on('change', function () {
            if ($(this).val() === 'check') {
                $('#check_information').show();
                $('#checkNumber').prop('required',true);
                $('#due_date').prop('required',true);
                $('#bank_name').prop('required',true);
            } else {
                $('#check_information').hide();
            }
        })

        function bonds_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.payment_bond.bonds_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_number': $('#invoice_number').val(),
                    'payment_type': $('#payment_type').val(),
                    'insert_by': $('#insert_by').val(),
                    'client_id': $('#client_id').val()
                },
                success: function (data) {
                    $('#bonds_table').html(data.view)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });

        }
    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

