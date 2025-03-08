<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

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

                    @if( !empty($cart) )
                    <div class="flex justify-between">
                        <h3 class="text-lg font-semibold">
                            {{ __('Your Items:') }}
                        </h3>
                        <a href="{{ route('products.index') }}">
                            <button class="border-0 bg-blue-500 text-xs uppercase px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                {{ __('Continue Shopping') }}
                            </button>
                        </a>
                    </div>

                    <div class="flex justify-between">
                        <table class="table mt-5" style="width: 70%;">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $key => $item)
                                <tr>
                                    <td>
                                        <img class="img-thumbnail" src="{{ isset($item['photo']) ? asset('storage/'. $item['photo']) : asset('storage/Product_sample_icon.png')  }}" alt="{{ $item['name'] }}" height="50" width="50">

                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['price'] }}</td>
                                    <td>
                                        <button class="text-white bg-gray-800 font-medium rounded-full text-sm px-3 py-2.5 me-2 mb-2  decrease-quantity" data-id="{{ $key }}">-</button>
                                        <span class="mx-2 quantity">{{ $item['quantity'] }}</span>
                                        <button class="text-white bg-gray-800 font-medium rounded-full text-sm px-3 py-2.5 me-2 mb-2  increase-quantity" data-id="{{ $key }}"> +
                                        </button>
                                    </td>
                                    <td class="item-total">{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                </tr>
                                @php
                                $totalAmount = collect($cart)->sum(function ($item) {
                                return $item['price'] * $item['quantity'];
                                });
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-sm d-flex justify-content-end mt-5 px-4">
                            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-center">

                                <p class="mb-3">Grand Total:</p>
                                <span class="fw-bolder text-center text-lg" id="cart-total">{{ number_format($totalAmount, 2) }}</span>


                                <form method="post" action="{{ route('order.place') }}">
                                    @csrf
                                    <button class="d-flex px-3 py-2 text-sm fw-bolder text-center rounded-lg btn btn-outline-dark">
                                        Place Order
                                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                    @else
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('Your cart is empty.') }}
                    </h2>
                    @endif

                </div>
            </div>
        </div>
        <x-slot:scripts>
            <script>
                $(document).ready(function() {
                    // Increase quantity
                    $('.increase-quantity').click(function() {
                        const id = $(this).data('id');
                        const quantityElement = $(this).siblings('.quantity');

                        let quantity = parseInt(quantityElement.text());
                        updateQuantity(id, quantity + 1, quantityElement);
                    });

                    // Decrease quantity
                    $('.decrease-quantity').click(function() {
                        const id = $(this).data('id');
                        const row = $(this).closest('tr');
                        const quantityElement = $(this).siblings('.quantity');

                        let quantity = parseInt(quantityElement.text());

                        if (quantity > 1) {
                            updateQuantity(id, quantity - 1, quantityElement);
                        } else {
                            $.ajax({
                                url: "{{ route('cart.remove') }}",
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id
                                },
                                success: function(response) {
                                    if (response.success) {
                                        row.remove();
                                        calculateTotal();
                                    }
                                }
                            });
                        }
                    });

                    function updateQuantity(id, quantity, quantityElement) {
                        $.ajax({
                            url: "{{ route('cart.updateQuantity') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                quantity: quantity
                            },
                            success: function(response) {
                                if (response.success) {
                                    quantityElement.text(quantity);
                                    const price = parseFloat(quantityElement.closest('tr').find('td:nth-child(3)').text());
                                    const totalElement = quantityElement.closest('tr').find('.item-total');
                                    totalElement.text((price * quantity).toFixed(2));
                                    calculateTotal();
                                }
                            }
                        });
                    }

                    // Calculate total
                    function calculateTotal() {
                        let total = 0;
                        $('.item-total').each(function() {
                            total += parseFloat($(this).text());
                        });
                        $('#cart-total').text(total.toFixed(2));
                    }
                });
            </script>
        </x-slot:scripts>
</x-app-layout>