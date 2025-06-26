@extends('admin.layout.master_admin')

@section('content')
    <div class="container">
        <h3 class="mb-4">Product Detail</h3>
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('productImage/' . $product->image) }}" class="w-25">
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name:</label>
                            <div class="col-sm-9 col-form-label fw-bold">{{ $product->name }}</div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Category:</label>
                            <div class="col-sm-9 col-form-label fw-bold">{{ $product->category_name }}</div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Price:</label>
                            <div class="col-sm-9 col-form-label fw-bold">{{ number_format($product->price, 2) }} MMK</div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description:</label>
                            <div class="col-sm-9 fw-bold text-end">
                                {{ $product->description }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center">
                                <a href="{{ route('product#list') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
