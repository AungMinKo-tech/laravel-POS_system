@extends('admin.layout.master_admin')

@section('title', 'POS Admin Order List')

@section('content')
    <div class="container-fluid row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Order List</h4>

                    <div class="row">
                        <div class="col-6">
                            <div class="table-responsive">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <span class=""><strong><i
                                                class="fa-solid fa-triangle-exclamation text-warning me-3"></i></strong>You
                                        can click order code to see order details</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Order Code</th>
                                    <th>Customer Name</th>
                                    <th>Order Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderList as $item)
                                    <tr>
                                        <td> {{ $item->created_at->format('j-F-Y') }} </td>
                                        <td> <a href="{{ route('admin#orderDetails', $item->order_code) }}"
                                                class="orderCode">{{ $item->order_code }}</a> </td>
                                        <td> {{ $item->name == null ? $item->nickname : $item->name }} </td>
                                        <td>
                                            <select name="" id="" class="form-select statusChange">
                                                <option value="0" @if ($item->status == 0) selected @endif>
                                                    Pending</option>
                                                @if ($item->order_count <= $item->stock)
                                                    <option value="1"
                                                        @if ($item->status == 1) selected @endif>Success</option>
                                                @endif
                                                <option value="2" @if ($item->status == 2) selected @endif>
                                                    Reject</option>
                                            </select>
                                        </td>
                                        <td>
                                            @if ($item->status == 0)
                                                <i class="fa-solid fa-spinner text-warning"></i>
                                            @elseif($item->status == 1)
                                                <i class="fa-solid fa-check text-success"></i>
                                            @else
                                                <i class="fa-solid fa-xmark text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-section')
    <script>
        $(document).ready(function() {
            $(".statusChange").change(function() {
                status = $(this).val();
                orderCode = $(this).parents("tr").find(".orderCode").text();

                data = {
                    'order_code': orderCode,
                    'status': status
                };


                $.ajax({
                    type: 'get',
                    url: '/admin/order/statusChange',
                    data: data,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : "";
                    }
                })
            })
        })
    </script>
@endsection
