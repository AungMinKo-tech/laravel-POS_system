@extends('admin.layout.master_admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="mb-4">
            <h1 class="h3 text-gray-800">Category</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Category</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category#update', $category->id) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Name</label>
                                <input type="text" id="categoryName" name="categoryName"
                                    value="{{ old('categoryName', $category->name) }}"
                                    class="form-control @error('categoryName') is-invalid @enderror"
                                    placeholder="Category Name...">
                                @error('categoryName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('category#List') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
