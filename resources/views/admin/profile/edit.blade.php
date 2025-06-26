@extends('admin.layout.master_admin')

@section('title', 'Profile Edit')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Profile(<span class="text-danger">{{ Auth::user()->role }}</span>)</h4>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('profile#updateAdmin') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-3 text-center">
                                <img src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('default/defaultpp.png') }}"
                                    class="w-25 mb-4" id="output">
                                <input type="file" class="form-control" id="profile_picture" name="image"
                                    onchange="LoadFile(event)" accept="image/*">
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ Auth::user()->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ Auth::user()->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="nickname">Nickname</label>
                                    <input type="text" class="form-control @error('nickname') is-invalid @enderror"
                                        id="nickname" name="nickname" value="{{ Auth::user()->nickname }}">
                                    @error('nickname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                        name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male"
                                            {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="other"
                                            {{ old('gender', Auth::user()->gender) == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ Auth::user()->phone }}">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ Auth::user()->address }}">
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="my-2">
                                <a href="{{ route('profile#changePasswordPage') }}">Change Password</a>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
