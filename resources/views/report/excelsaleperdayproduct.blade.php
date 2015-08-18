<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td>วันที่</td>
    <td>ยอดขาย</td>
</tr>
@foreach($datapro1 as $test)
    <tr>
        @if( $test->total_sales != 0)
            <td align="middle">{{$test->DATE}}</td>
            <td align="middle"><?php echo number_format($test->total_sales), ' บาท' ?></td>
        @endif
    </tr>
@endforeach

</html>