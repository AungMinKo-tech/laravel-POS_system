@extends('admin.layout.master_admin')

@section('content')
    <div class="container">
        <h3 class="mb-5">Create New Product</h3>
        <form action="{{ route('product#create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 text-center">
                <img class="img-profile mb-1 w-25 rounded" id="output">
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*"
                    onchange="LoadFile(event)">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="category" class="form-label">Category Name</label>
                    <select class="form-control @error('categoryId') is-invalid @enderror" id="categoryId" name="categoryId">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (old('categoryId') == $category->id) selected @endif>
                                {{ $category->name }}</option>
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
                    <input type="number" value="{{ old('price') }}"
                        class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                        step="0.01">
                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" value="{{ old('stock') }}"
                        class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock"
                        min="0">
                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" id="description"
                    name="description" rows="10"></textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Create Product</button>
            </div>
        </form>
    </div>
@endsection
