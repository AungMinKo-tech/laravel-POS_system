@extends('admin.layout.master_admin')

@section('title', 'Order Details')

@section('content')
    <div class="content-wrapper">
        <a href="{{ route('admin#orderList') }}" class="btn btn-secondary mb-3">
            <i class="fa fa-arrow-left"></i> Back to Orders</a>

        <div class="row">
            <div class="col-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Customer Information</h4>

                        <div class="row mb-3">
                            <div class="col-5">Name:</div>
                            <div class="col-7">{{ $paymentHistory->user_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Phone:</div>
                            <div class="col-7">{{ $order[0]->phone }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Address:</div>
                            <div class="col-7">{{ $paymentHistory->address }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Order Code:</div>
                            <div class="col-7" id="orderCode">{{ $order[0]->order_code }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Order Date:</div>
                            <div class="col-7">{{ $order[0]->created_at->format('j-F-Y') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Total Price:</div>
                            <div class="col-7">{{ $paymentHistory->total_amt }} MMK <br>
                                <small class="text-danger ms-1">( Contain Delivery Charges )</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Payment Information</h4>

                        <div class="row mb-3">
                            <div class="col-5">Contact Phone:</div>
                            <div class="col-7">{{ $paymentHistory->phone }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Payment Method:</div>
                            <div class="col-7">{{ $paymentHistory->payment_type }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5">Purchase Date:</div>
                            <div class="col-7">{{ $paymentHistory->created_at->format('j-F-Y') }}</div>
                        </div>

                        <div class="row mb-3">
                            <img style="width: 150px;" src="{{asset('payslip_image/'.$paymentHistory->payslip_image)}}" class="img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Order Details</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Count</th>
                                        <th>Available Stock</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $item)
                                        <tr class="text-center">
                                            <input type="hidden" name="" class="productId" value="{{$item->product_id}}">
                                            <input type="hidden" name="" class="count" value="{{$item->order_count}}">
                                            <td>
                                                <img src="{{ asset('productImage/' . $item->image) }}" class="w-50"
                                                    style="height: 60px; width: 60px;">
                                            </td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->order_count }} @if ($item->order_count > $item->stock)
                                                    <small class="text-danger">(Out of stock)</small>
                                                @endif
                                            </td>
                                            <td>{{ $item->stock }}</td>
                                            <td>{{ $item->price }} MMK</td>
                                            <td>{{ $item->price * $item->order_count }} MMK</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                @if($status)
                    <button type="button" id="btn-order-accept" class="btn btn-success rounded shadow-sm">Accept Order</button>
                @endif
                <button type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm">Reject Order</button>
            </div>
        </div>
    </div>
@endsection

@section('script-section')
    <script>
        $(document).ready(function(){

            $("#btn-order-accept").click(function(){
                orderCode = $("#orderCode").text();
                orderList = [];

                $(".data-table tbody tr").each(function(index,row){
                    productId = $(row).find('.productId').val();
                    count = $(row).find('.count').val();

                    orderList.push({
                        'productId' : productId,
                        'count' : count,
                        'orderCode' : orderCode,
                    });
                });
                $.ajax({
                    type : 'get',
                    url : '/admin/order/confirm',
                    data : Object.assign({}, orderList),
                    dataType : 'json',
                    success : function(res){
                        res.status == 'success' ? location.href="/admin/order/list" : "";
                    }
                })

            })

            $("#btn-order-reject").click(function(){
                orderCode = $("#orderCode").text();

                $.ajax({
                    type : 'get',
                    url : '/admin/order/reject',
                    data : {'orderCode' : orderCode},
                    dataType : 'json',
                    success : function(res){
                        res.status == 'success' ? location.href="/admin/order/list" : "";
                    }
                })
            })
        })
    </script>
@endsection
