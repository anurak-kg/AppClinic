<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>แพทย์</td>
    <td>ยอดขาย</td>
</tr>
@foreach($data as $test)
    <tr>

        <td>{{$test->name}}</td>
        <td><?php echo number_format($test->Total), ' บาท' ?></td>
    </tr>
@endforeach

</html>