@extends('admin.layout.master_admin')

@section('content')
    <div class="container pb-5">
        <h3 class="mb-4">Edit Product</h3>
        <form method="POST" action="{{ route('product#update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="productId" value="{{ $product->id }}">
            <input type="hidden" name="productImage" value="{{ $product->image }}">

            <div class="mb-3 text-center">
                <img src="{{ asset('productImage/' . $product->image) }}" id="output"
                    style="width: 200px; height: 200px;">
                <input type="file" class="form-control mt-3 @error('image') is-invalid @enderror" id="image"
                    accept="image/*" name="image" onchange="LoadFile(event)">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control @error('categoryId') is-invalid @enderror" id="category_id"
                        name="categoryId">
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" @if (old('categoryId', $product->category_id == $item->id)) selected @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoryId')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                        name="price" value="{{ old('price', $product->price) }}">
                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                        name="stock" value="{{ old('stock', $product->stock) }}" min="0">
                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="10">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="text-center d-flex justify-content-between">
                <a href="{{ route('product#list') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
@endsection
