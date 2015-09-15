<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>คอร์ส</td>
    <td>จำนวน</td>
</tr>
@foreach($data as $test)
    {{--{{dd($test->Total)}}--}}
    <tr>
        <td align="middle">{{$test->coursename}}</td>
        <td align="middle"><?php echo number_format($test->Total)?></td>
    </tr>
@endforeach

</html>