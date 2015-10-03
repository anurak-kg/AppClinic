<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>พนักงาน</td>
    <td>Commission</td>
</tr>
@foreach($data as $test)
    <tr>

        <td align="middle">{{$test->name}}</td>
        <td align="middle"
                ><?php echo number_format($test->Total)?></td>
    </tr>
@endforeach

</html>