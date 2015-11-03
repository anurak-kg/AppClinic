<table>
    <tr>
        <td>พนักงาน</td>
        <td>
            {{$order->user->name}}
        </td>
    </tr>

    <tr>
        <td>สาขา</td>
        <td>

          {{$order->branch->branch_name}}

        </td>
    </tr>

    <tr>
        <td>สินค้า
            <br>
            <br>

            @foreach($order->product as $item)

               {{$item->product_name}}/
                จำนวน {{$item->pivot->order_de_qty}}
                <br>
            @endforeach

        </td>

    </tr>
</table>