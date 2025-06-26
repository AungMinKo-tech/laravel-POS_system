<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{    // Create page
    public function createPage()
    {
        // create a new product
        $categories = Category::select('id', 'name')->get();

        return view('admin.product.create', compact('categories'));
    }

    //product list
    public function list($action = 'default')
    {
        $products = Product::select('products.id', 'products.name', 'products.image', 'products.price', 'products.stock', 'products.category_id', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->when($action == 'lowAmt', function ($query) {
                $query->where('products.stock', '<=', 3);
            })
            ->when(request('searchKey'), function ($query) {
                $query->whereAny([
                    'products.name',
                    'products.price',
                    'products.stock',
                    'categories.name'
                ], 'like', '%' . request('searchKey') . '%');
            })
            ->orderby('products.created_at', 'desc')
            ->paginate(5);
        return view('admin.product.list', compact('products'));
    }

    // Create product
    public function create(Request $request)
    {
        // check validation
        $this->checkValidation($request, "create");
        $data = $this->getData($request);

        if ($request->hasFile('image')) {
            $filename = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file("image")->move(public_path('') . "/productImage/", $filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        Alert::success('Success Title', 'ထုတ်ကုန်အမည်ကို အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');

        return back();
    }

    //get product data
    private function getData($request)
    {
        return [
            'name' => $request->name,
            'category_id' => $request->categoryId,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];
    }

    //delete product
    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            // Delete image file if it exists
            if ($product->image && file_exists(public_path('productImage/' . $product->image))) {
                unlink(public_path('productImage/' . $product->image));
            }

            $product->delete();

            Alert::success('Success Title', 'ထုတ်ကုန်ကို အောင်မြင်စွာ ဖျက်သိမ်းပြီးပါပြီ။');
        }

        return back();
    }

    //edit product
    public function editProduct($id)
    {
        $categories = Category::get();
        $product = Product::where('id', $id)->first();

        return view('admin.product.edit', compact('product', 'categories'));
    }

    //update product
    public function update(Request $request)
    {
        // check validation
        $this->checkValidation($request, "update");

        $data = $this->getData($request);

        if ($request->hasFile('image')) {
            $oldImageName = $request->productImage;

            if (file_exists(public_path('productImage/' . $oldImageName))) {
                unlink(public_path('productImage/' . $oldImageName));
            }
            $filename = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file("image")->move(public_path('') . "/productImage/", $filename);
            $data['image'] = $filename;

        } else {
            $data['image'] = $request->productImage; // Keep the old image if no new image is uploaded
        }

        Product::where('id', $request->productId)->update($data);

        Alert::success('Success Title', 'ထုတ်ကုန်အမည်ကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return to_route('product#list');
    }

    //product detail
    public function detail($id){
        $product = Product::select('products.id', 'products.name', 'products.image', 'products.price', 'products.description', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.id', $id)
            ->first();

        return view('admin.product.detail', compact('product'));
    }

    //check validation
    private function checkValidation($request, $action)
    {
        $rules = [
            'name' => 'required|min:3|max:50|unique:products,name,' . $request->productId,
            'categoryId' => 'required',
            'price' => 'required|numeric|min:2',
            'stock' => 'required|numeric|min:1|max:9999',
            'description' => 'required|min:10|max:2000',
        ];

        $rules['image'] = $action == 'create' ? 'required|mimes:jpg,jpeg,png,gif,webp,svg,heic,avif' : 'mimes:jpg,jpeg,png,gif,webp,svg,heic,avif';

        $messages = [
            'image.required' => 'Product image is required.',
            'image.mimes' => 'Product image must be a file of type: jpg, jpeg, png, gif, webp, svg, heic.',
            'name.required' => 'Product name is required.',
            'name.min' => 'Product name must be at least 3 characters.',
            'name.max' => 'Product name must not exceed 50 characters.',
            'categoryId.required' => 'Please select a category.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'stock.required' => 'Stock is required.',
            'stock.numeric' => 'Stock must be a number.',
            'description.max' => 'Description must not exceed 2000 characters.'
        ];

        $request->validate($rules, $messages);
    }
}
