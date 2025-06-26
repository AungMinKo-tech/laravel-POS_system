@extends('admin.layout.master_admin')

@section('content')
    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Category List</h1>
                    </div>

                    <div class="">
                        <div class="row">
                            <div class="col-12 col-md-5 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body shadow">
                                        <form action="{{route('category#create')}}" method="post" class="p-3 rounded">
                                            @csrf
                                            <input type="text" name="categoryName" value="" class="form-control @error('categoryName') is-invalid @enderror" placeholder="Category Name..." value="{{ old('categoryName')}}">
                                            @error('categoryName')
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
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Created Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $item )
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->created_at->format('j-F-Y')}}</td>
                                                    <td>
                                                        <a href="{{route('category#edit',$item->id)}}" class="btn btn-success btn-sm btn-icon-text mr-3">
                                                            Edit
                                                            <i class="typcn typcn-edit btn-icon-append"></i>
                                                        </a>
                                                        <form action="" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="button" onclick="deleteProcess({{$item->id}})" class="btn btn-danger btn-sm btn-icon-text">
                                                            Delete
                                                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                                        </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <span class="d-flex justify-content-end mt-3">{{ $categories->links() }}</span>
                            </div>
                        </div>
                    </div>

                </div>
@endsection

@section('script-section')
   <script>
         function deleteProcess($id){
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
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(()=>{
                        location.href = '/admin/category/delete/' + $id;
                    }, 1000);
                }
            });
        }
   </script>
@endsection

