@extends('admin.layout.master_admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="mb-4">
            <h1 class="h3 text-gray-800">Payment</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Payment</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('payment#update', $payment->id) }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="accountName" class="form-label">Account Name</label>
                                <input type="text" id="accountName" name="accountName"
                                    value="{{ old('accountName', $payment->account_name) }}"
                                    class="form-control @error('accountName') is-invalid @enderror"
                                    placeholder="Account Name...">
                                @error('accountName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="accountNumber" class="form-label">Account Number</label>
                                <input type="text" id="accountNumber" name="accountNumber"
                                    value="{{ old('accountNumber', $payment->account_number) }}"
                                    class="form-control @error('accountNumber') is-invalid @enderror"
                                    placeholder="Account Number...">
                                @error('accountNumber')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="accountType" class="form-label">Account Type</label>
                                <input type="text" id="accountType" name="accountType"
                                    value="{{ old('accountType', $payment->type) }}"
                                    class="form-control @error('accountType') is-invalid @enderror"
                                    placeholder="Account Name...">
                                @error('accountType')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('payment#list') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
