<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>คอร์ส</td>
    <td>ยอดขาย</td>
</tr>
@foreach($data as $test)
    <tr>

        <td >{{$test->coursename}}</td>
        <td ><?php echo number_format($test->Total), ' บาท' ?></td>
    </tr>
@endforeach

</html>