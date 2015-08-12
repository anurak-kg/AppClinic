<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>สินค้า</td>
    <td>จำนวน</td>
</tr>
@foreach($data as $item)
    <tr>
        <td>{{$item->productname}}</td>
        <td>{{$item->Total}}</td>
    </tr>
@endforeach

</html>