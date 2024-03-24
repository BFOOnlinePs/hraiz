<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>كشف حساب عميل</title>
    <style>
        .tbb { border-collapse: collapse; width:400px; }
        .tbb th, .tbb td { padding: 5px; border: solid 1px black; }
        .tbb th { background-color: aliceblue; }
        .tbb { width: 100% }
    </style>
</head>
<body>
    <h3>كشف حساب</h3>
    <p>اسم الزبون : <span>{{ $user->name }}</span></p>
    <p>التاريخ : <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></p>
    <table width="100%" class="tbb">
        <tr>
            <th>المستند</th>
            <th>التاريخ</th>
            <th>دائن</th>
            <th>مدين</th>
            <th>الرصيد</th>
            <th>البيان</th>
        </tr>
        @php
            $sumCreditor = 0;
            $sumDebtor = 0;
            $amount = 0;
        @endphp
        @if($data->isEmpty())
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            <tr>
                <td></td>
                <td></td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>رصيد اول المدة</td>
            </tr>
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($key->created_at)->format('Y-m-d') }}</td>
                    <td>
                        @if($key->type == 'purchase' || $key->type == 'payment_bond' || $key->type == 'return_sales')
                            {{ $key->amount }}
                            @php
                                $sumCreditor += $key->amount;
                                $amount -= $key->amount;
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if($key->type == 'sales' || $key->type == 'performance_bond' || $key->type == 'return_purchase')
                            {{ $key->amount }}
                            @php
                                $sumDebtor += $key->amount;
                                $amount += $key->amount;
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                    <td>{{ $amount }}</td>
                    <td>
                        @if($key->type == 'sales')
                            فاتورة مبيعات
                        @elseif($key->type == 'payment_bond')
                            سند قبض
                        @elseif($key->type == 'return_sales')
                            مردود مبيعات
                        @elseif($key->type == 'purchase')
                            فاتورة مشتريات
                        @elseif($key->type == 'performance_bond')
                            سند صرف
                        @elseif($key->type == 'return_purchase')
                            مردود مشتريات
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr class="bg-dark">
                <td></td>
                <td colspan="" class="text-center">المجموع</td>
                <td>{{ $sumCreditor }}</td>
                <td>{{ $sumDebtor }}</td>
                <td>{{ $sumDebtor - $sumCreditor }}</td>
                <td></td>
            </tr>
        @endif
    </table>
</body>
</html>
