<table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
       aria-describedby="example1_info">
    <thead>
    <tr>
        <th>المنتج</th>
        <th>اسم خط الانتاج</th>
        <th>ملاحظات</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="4" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>{{ $key->product->product_name_ar }}</td>
                <td>{{ $key->production_name }}</td>
                <td>
                    {{ $key->production_notes }}
                </td>
                <td>
                    <a class="btn btn-success btn-sm" href="{{ route('production.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                    <a class="btn btn-dark btn-sm" href="{{ route('production.production_inputs.index',['id'=>$key->id]) }}"><span class="fa fa-search"></span></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
