<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container p-6 ">
                    <form id="productForm" method="POST" enctype="multipart/form-data" action=" {{ route('products.store') }} ">
                        @csrf
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12">
                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="photo" class="block text-sm/6 font-medium text-gray-900">Photo</label>
                                        <div class="mt-2 flex items-center gap-x-3">

                                            <input type="file" name="photo" id="photo" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-900/10 pb-12 mt-5">
                                <h2 class="text-base/7 font-semibold text-gray-900">Product-Information</h2>

                                <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-3">
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        @error('name')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="price" class="block text-sm/6 font-medium text-gray-900">Price</label>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        @error('price')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="stock" class="block text-sm/6 font-medium text-gray-900">Stock</label>
                                        <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        @error('stock')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="category_id" class="block text-sm/6 font-medium text-gray-900">Category</label>
                                        <select id="category_id" name="category_id" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                            <option value="" selected disabled hidden>---Select Category---</option>
                                            @foreach($categoryList as $category)
                                            <option value="{{$category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="rounded-md font-semibold btn btn-success">Save</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#productForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    stock: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter name",
                    },
                    price: {
                        required: "Please enter price",
                    },
                    stock: {
                        required: "Please provide a stock",
                    },
                    category_id: {
                        required: "Please provide a category",
                    }
                },
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    error.insertAfter(element);
                }
            });
        });
    </script>

</x-app-layout>