<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>عرض سعر</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <style>
        @page{
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
            background-image-resize:6;
            margin-top:220px;
            margin-bottom:50px;
        }

        @page :first{
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
            background-image-resize:6;
            margin-bottom:50px;
            margin-top:220px;
        }
        .title{

        }
        table, td, th {
            border: 1px solid black;
            font-size: 14px;
        }
        .table{
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
        th{
            height: 70%;
            background-color: #6c757d;
            color: white;
        }

        .float-container {
            padding: 20px;
        }

        .float-child {
            width: 43.4%;
            float: left;
            padding: 20px;
        }

        .sum{
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body dir="rtl">
<h2 align="center">عرض سعر</h2>
<div class="float-container">
    <div class="float-child" style="float: right">
        <h5>الى :</h5>
        <h5>{{ $price_offer_sales->customer->name }}</h5>
    </div>
    <div class="float-child" style="float: left;text-align: center">
        <h5>عرض الاسعار : <span>{{ $price_offer_sales->id }}</span></h5>
        <h5>تاريخ : <span>{{ \Carbon\Carbon::parse($price_offer_sales->insert_at)->toDateString() }}</span></h5>
    </div>
</div>
<table class="table" cellpadding="10">
    <tr>
        <th>
            @if($language == 'ar')
                اسم الصنف
            @elseif($language == 'en')
                Product name
            @elseif($language == 'he')
                שם מוצר
            @endif
        </th>
        <th>
            @if($language == 'ar')
                الكمية
            @elseif($language == 'en')
                Quantity
            @elseif($language == 'he')
                כַּמוּת
            @endif
        </th>
        <th>
            @if($language == 'ar')
                السعر
            @elseif($language == 'en')
                Price
            @elseif($language == 'he')
                המחיר
            @endif
        </th>
        <th>
            @if($language == 'ar')
                المجموع
            @elseif($language == 'en')
                Total
            @elseif($language == 'he')
                סך הכל
            @endif
        </th>
        <th>
            @if($language == 'ar')
                الملاحظات
            @elseif($language == 'en')
                Notes
            @elseif($language == 'he')
                הערות
            @endif
        </th>
    </tr>
    @foreach($data as $key)
        <tr>
            <td>
                @if($language == 'ar')
                    {{ $key->product->product_name_ar }}
                @elseif($language == 'en')
                    {{ $key->product->product_name_en }}
                @elseif($language == 'he')
                    {{ $key->product->product_name_he }}
                @endif
            </td>
            <td>
                {{ $key->qty }}
            </td>
            <td>{{ $key->price }}</td>
            <td>
                {{ $key->qty * $key->price }} {{ $price_offer_sales->currency->currency_symbol ?? '' }}
            </td>
            <td>{{ $key->notes }}</td>
        </tr>
    @endforeach
    <tr>
        <td class="sum" colspan="3">المجموع</td>
        <td>{{ $sum }} <span style="text-align: left">{{ $price_offer_sales->currency->currency_symbol ?? '' }}</span></td>
        <td></td>
    </tr>
</table>
<div style="margin-top: 20px">
    <h5>الملاحظات :</h5>
    <p>{{ $price_offer_sales->notes }}</p>
</div>
</body>
</html>