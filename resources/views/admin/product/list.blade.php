@extends('admin.layout.master_admin')

@section('content')
    <div class="container">
        <h3 class="mb-4">Products List</h3>
        <div class="mb-4 row g-2">
            <div class="col-12 col-md-auto">
                <button class="btn btn-outline-secondary bg-secondary text-white w-100" disabled>
                    Product Count ({{ count($products) }})
                </button>
            </div>
            <div class="col-12 col-md-auto">
                <a href="{{ route('product#list') }}" class="btn btn-outline-primary w-100">
                    All Products
                </a>
            </div>
            <div class="col-12 col-md-auto">
                <a href="{{ route('product#list','lowAmt') }}" class="btn btn-outline-danger w-100">
                    Low Amount Product List
                </a>
            </div>
        </div>
        <form class="mb-4 row g-2" method="GET" action="{{ route('product#list') }}">
            <div class="col-12 col-md">
                <input type="text" name="searchKey" value="{{request('searchKey')}}" class="form-control" placeholder="Search products...">
            </div>
            <div class="col-12 col-md-auto">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="typcn typcn-zoom"></i>
                </button>
            </div>
        </form>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead style="background-color: #6f42c1; color: #fff;">
                    <tr class="text-center">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($products) != 0)
                        @foreach ($products as $item)
                            <tr style="transition: background 0.2s;"
                                onmouseover="this.style.background='#f3e8ff';"
                                onmouseout="this.style.background='';">
                                <td>
                                    <img src="{{ asset('productImage/' . $item->image) }}" alt=""
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }} MMK</td>
                                <td class="col-2">
                                    <div class="position-relative d-inline-block" style="width: 80px; height: 40px;">
                                        <span class="d-block text-center fs-5 fw-semibold" style="line-height:40px;">
                                            {{ $item->stock }}
                                        </span>
                                        @if ($item->stock <= 3)
                                            <span class="position-absolute badge rounded-pill bg-danger shadow text-white"
                                                style="top: -12px; right: -18px; font-size: 0.75rem; padding: 0.35em 0.7em; z-index:1;">
                                                Low Amt Stock
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->category_name }}</td>
                                <td>
                                    <a href="{{route('product#detail', $item->id)}}" class="btn btn-info btn-sm me-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{route('product#edit', $item->id)}}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" onclick="deleteProcess({{$item->id}})" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
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
                        location.href = '/admin/product/delete/' + $id;
                    }, 1000);
                }
            });
        }
   </script>
@endsection
