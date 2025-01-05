<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        if (Auth::user()->role === 'admin') {
            $products = Product::with('category')->paginate(1);
            $viewFile = 'products.index';
        } else {
            $products = Product::with('category')->get();
            $viewFile = 'products.userIndex';
        }
        // dd($products);
        return view($viewFile, compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryList = Category::all();
        return view('products.create', compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imagePath = $image->store('products', 'public');
            $data['photo'] = $imagePath;
        } else {
            $data['photo'] = null;
        }
        // dd($data);

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $pId = $id;
        $product = Product::with('category')->find($pId);
        $categoryList = Category::all();
        return view('products.edit', compact('product', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, string $id)
    {
        $data = $request->validated();

        $product = Product::find($id);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                $filePath = public_path('storage/' . $product->photo);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $image = $request->file('photo');
            $imagePath = $image->store('products', 'public');
            $data['photo'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::find($id);
        if ($product->photo) {

            $imgPath = $product->photo;

            $filePath = public_path('storage/' . $imgPath);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
