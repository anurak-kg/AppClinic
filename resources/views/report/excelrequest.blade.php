<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <td ><b>สาขา</b></td>
    <td ><b>ผู้เบิก</b></td>
    <td align="middle"><b>เลขที่การเบิก</b></td>
    <td align="middle"><b>สินค้า</b></td>
    <td align="middle"><b>จำนวน</b></td>
    <td align="middle"><b>วันที่เบิก</b></td>
</tr>
@foreach($data as $test)
    <tr>

        <td align="middle">{{$test->branch_name}}</td>
        <td align="middle">{{$test->name}}</td>
        <td align="middle">{{$test->order_id}}</td>
        <td align="middle">{{$test->product_name}}</td>
        <td align="middle">{{$test->order_de_qty}}</td>
        <td align="middle">{{$test->date}}</td>

    </tr>
@endforeach

</html>