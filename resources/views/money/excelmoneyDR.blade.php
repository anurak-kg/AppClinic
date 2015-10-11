<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<tr>
    <th>รหัสหมอ</th>
    <th>หมอ</th>
    <th>ค่ามือ</th>
</tr>
@foreach($data as $test)
    <tr>

        <td align="middle">{{ $item->id }}</td>
        <td align="middle">{{ $item->n }}</td>
        <td align="middle"
                ><?php echo number_format($item->tota)?></td>
    </tr>
@endforeach

</html>