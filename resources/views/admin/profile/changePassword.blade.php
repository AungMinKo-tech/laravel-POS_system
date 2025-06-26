@extends('admin.layout.master_admin')

@section('title', 'POS Admin Dashboard? Change Password')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route('profile#changePassword')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control @error('oldPassword') is-invalid @enderror"
                                    id="current_password" name="oldPassword">
                                @error('oldPassword')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control @error('newPassword') is-invalid @enderror"
                                    id="new_password" name="newPassword">
                                @error('newPassword')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror"
                                    id="confirm_password" name="confirmPassword">
                                @error('confirmPassword')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
