@extends('admin.layout.master_admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">User Account List</h4>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar Start -->
                        <form method="GET" action="{{ route('account#userList') }}" value="{{ request('searchKey') }}"
                            class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                    class="form-control" placeholder="Search user...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="typcn typcn-zoom"></i> Search
                                </button>
                            </div>
                        </form>
                        <!-- Search Bar End -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover shadow-sm text-center">
                                <thead class="bg-primary text-white">
                                    <tr class="text-center">
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Created Date</th>
                                        <th>Platform</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item->profile != null ? asset('profile/' . $item->profile) : asset('default/userpp.png') }}"
                                                    class="" alt="{{$item->profile ?? 'Default Image'}}"
                                                    style="width:80px; height:80px; object-fit:cover; border-radius: 0;"
                                                    id="output">
                                            </td>
                                            <td>{{ $item->name != null ? $item->name : $item->nickname }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td class="col-2">{!! $item->address != null
                                                ? $item->address
                                                : '<span style="opacity: 0.8"><i class="fa-solid fa-circle-xmark text-danger"></i></span>' !!}</td>
                                            <td class="col-2">{!! $item->phone != null
                                                ? $item->phone
                                                : '<span style="opacity: 0.8"><i class="fa-solid fa-circle-xmark text-danger"></i></span>' !!}</td>
                                            <td><small>{{ $item->created_at->format('j-F-Y') }}</small></td>
                                            <td class="text-center">
                                                @if ($item->provider == 'google')
                                                    <i class="fa-brands fa-google text-primary"></i>
                                                @endif
                                                @if ($item->provider == 'github')
                                                    <i class="fa-brands fa-github text-primary"></i>
                                                @endif
                                                @if ($item->provider == 'simple')
                                                    <i class="fa-solid fa-right-to-bracket text-primary"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->role != 'superadmin')
                                                    <button type="button" onclick="deleteProcess({{ $item->id }})"
                                                        class="btn btn-sm btn-outline-danger"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <span class="d-flex justify-content-end">{{ $user->links() }}</span>
                        </div>
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
                        text: "User အကောင့်ကို အောင်မြင်စွာ ဖျက်သိမ်းပြီးပါပြီ။",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/account/user/delete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
