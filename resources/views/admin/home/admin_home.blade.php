@extends('admin.layout.master_admin')

@section('title', 'POS Admin Dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12 grid-margin stretch-card flex-column">
                    <div class="row">
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-2 text-primary h5">Total Sell Amount</p>
                                            <h6 class="mt-3">{{$totalSaleAmt}} MMK</h6>
                                        </div>
                                    </div>
                                    <canvas id="yearly-sales-chart" class="mt-auto" height="65"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <a href="{{route('admin#orderList')}}" style="text-decoration: none;">
                                            <p class="mb-2 text-success h5">Order Request</p>
                                            <h6 class="mt-3 text-dark">{{ $orderCount }}</h6>
                                        </a>

                                    </div>
                                    <canvas id="monthly-sales-chart" class="mt-auto" height="65"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-2 text-secondary h5">Register User Count</p>
                                            <h6 class="mt-3">{{ $registerUser }}</h6>
                                        </div>
                                    </div>
                                    <canvas id="weekly-sales-chart" class="mt-auto" height="65"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-2 text-danger h5">Pending Request</p>
                                            <h6 class="mt-3">{{ $orderPending }}</h6>
                                        </div>
                                    </div>
                                    <canvas id="daily-sales-chart" class="mt-auto" height="65"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
