<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>วันที่</td>
    <td>ยอดขาย</td>
</tr>
@foreach($data as $test)
    <tr>

            <td align="middle">{{$test->DATE}}</td>
            <td align="middle"><?php echo number_format($test->Total), ' บาท' ?></td>

    </tr>
@endforeach

</html>