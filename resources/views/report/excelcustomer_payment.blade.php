<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>ประเภทการชำระเงิน</td>
    <td>รายได้ทั้งหมด</td>
</tr>
@foreach($data as $test)
    <tr>

        <td align="middle">{{$test->name}}</td>
        <td align="middle" style="width: 850px;"><?php echo number_format($test->Total), ' บาท' ?></td>
    </tr>
@endforeach
</html>