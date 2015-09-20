    <div class="row">
        <div class="col-md-12 ">
                <div class="modal-header">
                    <h3 class="modal-title">รายการขาย {{$sale->sales_id}} </h3>
                </div>
                <div class="col-md-12 ">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td style="width: 10px"><b>#</b></td>
                                <td><b>รายการสินค้า</b></td>
                                <td><b>ราคา/หน่วย</b></td>
                                <td><b>จำนวน</b></td>
                                <td><b>ราคารวม</b></td>
                                <td style="width: 20px"><b></b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1;?>

                            @foreach($sale[0]->sales_detail as $item)
                                {{--  {{dd($item->payment_detail[0]->amount)}}--}}
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>{{$item->product->product_name}}</td>
                                    <td>{{$item->product->product_price}}</td>
                                    <td>{{$item->sales_de_qty}}</td>
                                    <td>{{$item->sales_de_qty * $item->product->product_price}}</td>
                                </tr>
                            </tbody>
                            <?php $index++;?>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
        </div>
    </div>
