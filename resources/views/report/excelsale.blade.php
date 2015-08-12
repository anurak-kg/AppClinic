<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>ชื่อพนักงาน</td>
    <td>ยอดขาย</td>
</tr>
@foreach($data as $item)
    <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->Total}}</td>
    </tr>
@endforeach

</html>