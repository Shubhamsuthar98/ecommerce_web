<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('products.create') }}" class="btn btn-primary ">
                        Create Products
                    </a>
                </div>
                @if(session('success'))
                <div class="alert alert-success text-center mb-10">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger text-center mb-10">
                    {{ session('error') }}
                </div>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="10%">Photo</th>
                                <th scope="col" width="20%">Name</th>
                                <th scope="col" width="10%">Price</th>
                                <th scope="col" width="10%">Stock</th>
                                <th scope="col" width="20%">Category</th>
                                <th scope="col" width="40%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <img class="img-thumbnail" src="{{ isset($product->photo) ? asset('storage/'. $product->photo) : asset('storage/Product_sample_icon.png')  }}" alt="{{ $product->name }}" height="30" width="30"> </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm me-2">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>