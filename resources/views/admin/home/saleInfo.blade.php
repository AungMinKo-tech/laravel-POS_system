@extends('admin.layout.master_admin')

@section('title', 'Sale Information')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sold Products</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Code</th>
                                    <th>Product Name</th>
                                    <th>Sold Quantity</th>
                                    <th>Sold Date</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($soldProducts as $item)
                                    <tr>
                                        <td>{{$item->order_code}}</td>
                                        <td>{{ $item->product_name}}</td>
                                        <td>{{$item->count}}</td>
                                        <td>{{$item->created_at->format('d-m-Y')}}</td>
                                        <td>{{$item->user_name == null ? $item->nickname : $item->user_name}}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
