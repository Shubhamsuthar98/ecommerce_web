<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap gap-4">


                    @if (!empty($products))

                    @foreach($products as $product)
                    <div class="card mr-4 mb-4" style="width: 20rem; height: 25rem;">
                        <img class="card-img-top img-thumbnail  w-12 h-2" src="{{ isset($product->photo) ? asset('storage/'. $product->photo) : asset('storage/Product_sample_icon.png')  }}" alt="{{ $product->name }}" height="40%" width="40%" style="max-height: 50%">
                        <div class="card-body">
                            <form action="{{ route('cart.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_name" value="{{ $product->name }}">
                                <input type="hidden" name="product_price" value="{{ $product->price }}">
                                <input type="hidden" name="product_photo" value="{{ $product->photo }}">
                                <h5 class="card-title">{{ ucfirst($product->name) }}</h5>
                                <p class="card-text">
                                    Price: {{ $product->price }} <br>
                                    Quantity: <input type="number" name="quantity" min="1" value="1" style="width: 50px;">
                                </p>
                                <div class="d-flex justify-center mt-3">
                                    <button type="submit" class="btn btn-primary btn-block">Add to cart</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p>{{ __('No products found.') }}</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>