<html>
<head>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        h3 {
            font-family:angsana new;
            font-size:150%;
        }
        b  {
            font-family:angsana new;
            font-size:150%;
        }
    </style>
</head>

<body onload="window.print();">
<section class="invoice">
    <div class="row">
        <div align="middle">

            <div align="right">

                <b > ???????????????? : </b>  {{ $order->order_id }}<br>
                <b >??????????????????? : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}
                {{-- <b>???????? :</b> {{ $bill->treatment->tre_id }} <br>--}}
            </div>




            <h3 align="center" style="font-size:200%">
                ????????????
            </h3>

            <div align="left">

                <div class="row">

                    <div class="pull-left image">
                        <img src="/uploads/logo/logo.jpg" alt="Smiley face" height="120" width="120">
                    </div>

                    <div class="pull-left info">
                        <br>

                        &nbsp;&nbsp; <b> ???? :</b> {{ $order->branch->branch_name }}<br>
                        &nbsp;&nbsp; <b> ??????? :</b> {{ $order->branch->branch_address }}
                    </div>

                </div>
                <br><br><br><br><br><br>



            </div>

        </div>
    </div>

    <div class="col-sm-4 invoice-col">

        <br><br>

        <b> ??????????? :</b> {{ $order->user->id }} &nbsp;
        <b> ??????? :</b> {{ $order->user->name }}


        <br> <hr>

        <b> ??????? :</b> {{ $order->vendor->ven_name }} <br>
        <b> ??????? :</b>  {{ $order->vendor->ven_address }}<br>
        <b> ?????????????????????????? :</b>  {{ $order->vendor->ven_license }}
        <hr>
        <br>

    </div>




    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td><b>?????</b></td>
                    <td><b>??????????</b></td>
                    <th><b>??????</b></th>
                    <td align="middle"><b>?????</b></td>
                    <td align="middle"><b>????????</b></td>
                    <td align="middle"><b>???????</b></td>
                    <td align="middle"><b>?????????</b></td>

                </tr>
                </thead>
                <tbody >
                <?php $total=0 ?>
                <?php $index=0 ?>
                @foreach($order->product as $item)
                    <tr>

                        <td style="width: 50px" align="center"><?php echo $index+=1 ?></td>
                        <td style="width: 90px" align="center">{{$item->product_id}}</td>
                        <td style="width: 220px" align="center">{{$item->product_name}}</td>
                        <td  align="center" style="width: 70px">{{$qty = $item->pivot->order_de_qty}}</td>
                        <td  align="center" style="width: 70px">{{$item->product_unit}}</td>
                        <td align="center" style="width: 70px">{{number_format($price = $item->pivot->order_de_price)}}</td>
                        <td align="center" style="width: 90px" >{{number_format($sumtotal = $price*$qty)}}</td>

                    </tr>

                    <?php  $total+=($sumtotal) ?>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="middle" style="width: 100px"><b>????????????</b></td>
                    <td align="middle">{{ number_format($total) }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <hr>
        <div align="right">
            <b >??????????? </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>?????????? </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> <br>
            <b>??????   &nbsp;&nbsp;&nbsp;&nbsp; /  &nbsp; &nbsp;&nbsp;&nbsp;  /  &nbsp;&nbsp;&nbsp;&nbsp;  </b> &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp;&nbsp;
            <b>??????   &nbsp;&nbsp;&nbsp;&nbsp; /   &nbsp;&nbsp;&nbsp;&nbsp;  /  &nbsp;&nbsp;&nbsp;&nbsp;  </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
</body>
</html>
