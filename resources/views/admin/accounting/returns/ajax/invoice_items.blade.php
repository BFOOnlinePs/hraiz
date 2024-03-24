<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th></th>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
        </tr>
    </thead>
    <tbody>
    @if(!$data->isEmpty())
        @foreach($data as $key)
            <tr>
                <td><input type="checkbox" name="selected_products[]" value="{{ $key->product->id }}"></td>
                <td>{{ $key->product->product_name_ar }}</td>
                <td>
                    <input name="quantities[]" max="{{ $key->quantity }}" class="form-control" value="{{ $key->quantity }}" type="number">
                </td>
                <td>
                    <input name="rates[]" class="form-control" value="{{ $key->rate }}" type="text">
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="1" class="text-center">لا توجد بيانات</td>
        </tr>
    @endif
    </tbody>
</table>
