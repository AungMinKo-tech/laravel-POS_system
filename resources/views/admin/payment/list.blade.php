@extends('admin.layout.master_admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment List</h1>
        </div>

        <div class="col">
            <a href="{{ route('payment#list') }}" class="btn btn-outline-primary mb-3" style="width: 150px">
                All Payments
            </a>
        </div>

        <form class="mb-4 row g-2" method="GET" action="{{ route('payment#list') }}">
            <div class="col-12 col-md">
                <input type="text" name="searchKey" value="" class="form-control" placeholder="Search payments...">
            </div>
            <div class="col-12 col-md-auto">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="typcn typcn-zoom"></i>
                </button>
            </div>
        </form>

        <div class="">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body shadow">
                            <form action="{{ route('payment#create') }}" method="post" class="p-3 rounded">
                                @csrf
                                <input type="text" name="accountNumber" value=""
                                    class="form-control mt-3 @error('accountNumber') is-invalid @enderror"
                                    placeholder="Account Number..." value="{{ old('accountNumber') }}">
                                @error('accountNumber')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <input type="text" name="accountName" value=""
                                    class="form-control mt-3 @error('accountName') is-invalid @enderror"
                                    placeholder="Account Name..." value="{{ old('accountName') }}">
                                @error('accountName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <input type="text" name="accountType" value=""
                                    class="form-control mt-3 @error('accountType') is-invalid @enderror"
                                    placeholder="Account Type..." value="{{ old('accountType') }}">
                                @error('accountType')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3 w-100">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-7 col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-hover shadow-sm">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Account Number</th>
                                    <th>Account Name</th>
                                    <th>Account Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $item)
                                    <tr>
                                        <td>{{ $item->account_number }}</td>
                                        <td>{{ $item->account_name }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>
                                            <a href="{{ route('payment#edit', $item->id) }}"
                                                class="btn btn-success btn-sm btn-icon-text mr-3">
                                                Edit
                                                <i class="typcn typcn-edit btn-icon-append"></i>
                                            </a>
                                            <button type="button" onclick="deleteProcess({{ $item->id }})"
                                                class="btn btn-danger btn-sm btn-icon-text">
                                                Delete
                                                <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script-section')
    <script>
        function deleteProcess($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "ငွေပေးချေမှုကို အောင်မြင်စွာ ဖျက်သိမ်းပြီးပါပြီ။",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/payment/delete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
