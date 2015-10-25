@extends('layout.master')
@section('title',trans("customer.customer data"))
@section('headText',trans("customer.management"))

@section('content')
    @if( Session::get('message') != null )
        <div class="col-md-12">
            <div class="callout callout-success">
                <h4>Success!</h4>

                <p>{{Session::get('message')}}.</p>
            </div>
        </div>
    @endif

    <div class="box box-danger">

        <div class="box-header with-border">
            <h2 class="box-title">{{trans("customer.customer data")}}</h2>

            <div class="box-tools pull-right">
                <a href="{{url('customer/create')}}"
                   class="btn btn-danger">{{trans("customer.registry")}}</a>
            </div>
        </div>

        <div class="box-body ">

            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" id="customer_table">
                    <thead>
                    <tr>
                        <td style="width: 80px">{{trans("customer.customer id")}}</td>
                        <td>{{trans("customer.name")}}</td>
                        <td>{{trans("customer.phone")}}</td>
                        <td>{{trans("customer.age")}}</td>
                        <td style="width: 120px"></td>
                        <td style="width: 120px"></td>
                        <td style="width: 120px"></td>
                        <td style="width: 120px"></td>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->cus_id}}</td>
                            <td>
                                @linkToCustomer($customer->cus_id,$customer->cus_name)                            </td>
                            <td>{{$customer->cus_tel}}</td>
                            <td>{{(date('Y')+543) - $customer->cus_birthday_year }} ปี</td>
                            <td align="middle">
                                <a href="{{url('payment/history')}}?cus_id={{$customer->cus_id}}"
                                   class="btn btn-default">
                                    <i class="fa fa-credit-card"></i> {{trans("customer.pay")}} </a></td>
                            <td align="middle">
                                <a href="{{url('customer/view')}}?cus_id={{$customer->cus_id}}" class="btn btn-default">
                                    <i class="fa fa-book"></i>
                                    {{trans("customer.customer data")}}</a>
                            </td>
                            <td align="middle"><a href="{{url('customer/upload')}}?cus_id={{$customer->cus_id}}"
                                                  class="btn btn-default"><i
                                            class="fa fa-upload"></i> {{trans("customer.add photo")}}</a>
                            </td>
                            <td>
                                <a href="{{url('customer/edit')}}?modify={{$customer->cus_id}}"
                                   class="btn btn-success">{{trans("customer.edit")}}</a>
                                <a href="{{url('customer/delete')}}?cus_id={{$customer->cus_id}}"
                                   class="btn btn-danger"
                                   onclick="return confirm('{{trans("customer.confirm delete")}}');">{{trans("customer.delete")}}</a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#customer_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
