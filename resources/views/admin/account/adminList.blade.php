@extends('admin.layout.master_admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Admin Account List</h4>
                        <div>
                            <a href="{{ route('account#userList') }}" class="btn btn-outline-info mr-2">
                                <i class="typcn typcn-group"></i> User List
                            </a>
                            <a href="{{ route('account#newAccountPage') }}" class="btn btn-success">
                                <i class="typcn typcn-plus"></i> New Admin
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar Start -->
                        <form method="GET" action="{{route('account#adminList')}}" value="{{request('searchKey')}}" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                    class="form-control" placeholder="Search admin...">
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
                                        <th>Role</th>
                                        <th>Created Date</th>
                                        <th>Platform</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admin as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ $item->profile != null ? asset('profile/' . $item->profile) : asset('default/defaultpp.png') }}"
                                            class="" style="width:80px; height:80px; object-fit:cover; border-radius: 0;" id="output">
                                        </td>
                                        <td>{{$item->name != null ? $item->name : $item->nickname}}</td>
                                        <td>{{$item->email}}</td>
                                        <td class="col-2">{!!$item->address != null ? $item->address : '<span style="opacity: 0.8"><i class="fa-solid fa-circle-xmark text-danger"></i></span>'!!}</td>
                                        <td class="col-2">{!!$item->phone != null ? $item->phone : '<span style="opacity: 0.8"><i class="fa-solid fa-circle-xmark text-danger"></i></span>'!!}</td>
                                        <td><span class="bg-danger text-white p-1 rounded">{{$item->role}}</span></td>
                                        <td><small>{{$item->created_at->format('j-F-Y')}}</small></td>
                                        <td class="text-center">
                                            @if($item->provider == 'google') <i class="fa-brands fa-google text-primary"></i> @endif
                                            @if($item->provider == 'github') <i class="fa-brands fa-github text-primary"></i> @endif
                                            @if($item->provider == 'simple') <i class="fa-solid fa-right-to-bracket text-primary"></i> @endif
                                        </td>
                                        <td>
                                            @if ($item->role != 'superadmin')
                                                <button type="button" onclick="deleteProcess({{$item->id}})" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <span class="d-flex justify-content-end">{{$admin->links()}}</span>
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
                        text: "Admin အကောင့်ကို အောင်မြင်စွာ ဖျက်သိမ်းပြီးပါပြီ။",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/account/admin/delete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
