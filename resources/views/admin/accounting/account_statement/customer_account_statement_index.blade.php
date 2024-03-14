@extends('home')
@section('title')
    كشف حساب زبون
@endsection
@section('header_title')
    كشف حساب زبون
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    كشف حساب زبون
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <input type="hidden" id="user_type" value="customer">
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input onkeyup="list_customers_table()" type="text" class="form-control" id="search_input" placeholder="البحث عن زبون">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="list_customers_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            list_customers_table();
        });

        function list_customers_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url:'{{ route('accounting.account-statement.list_customers_table_ajax') }}',
                method:'POST',
                header:headers,
                data:{
                    'search_input':$('#search_input').val(),
                    'user_type':$('#user_type').val(),
                    '_token': csrfToken
                },
                success:function (data) {
                    $('#list_customers_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
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

