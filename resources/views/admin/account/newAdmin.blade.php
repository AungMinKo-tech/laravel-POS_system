@extends('admin.layout.master_admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="d-flex justify-content-end mt-3 mx-2">
                        <a href="{{ route('account#adminList') }}" class="btn btn-outline-danger mb-3" style="width: 150px">
                            Admin List
                        </a>
                    </div>
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Create New Admin Account</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('account#newAccount')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Admin Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="Enter admin name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Admin Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="Enter admin email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    placeholder="Enter password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control @error('confirmPassword') is-invalid @enderror"
                                    id="password_confirmation" placeholder="Confirm password">
                                @error('confirmPassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
