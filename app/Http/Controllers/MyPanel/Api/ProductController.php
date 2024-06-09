<?php

namespace App\Http\Controllers\MyPanel\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $products = Product::query();
        //paginate and search based on datatable request
        $columns = $request->get('columns');
        $search = $request->get('search');

        if ($search) {
            $products->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    if ($column['searchable'] == 'true') {
                        $query->orWhere($column['name'], 'like', '%' . $search['value'] . '%');
                    }
                }
            });
        }

        $order = $request->get('order');
        if ($order) {
            $products->orderBy($columns[$order[0]['column']]['name'], $order[0]['dir']);
        }

        $start = $request->get('start');
        $length = $request->get('length');

        $recordsTotal = Product::count();
        $recordsFiltered = $products->count();

        $products = $products->offset($start)->limit($length)->get();

        
        

        return response()->json([
            'data'=>$products,
            'draw'=>$request->get('draw'),
            'recordsTotal'=>$recordsTotal,
            'recordsFiltered'=>$recordsFiltered
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_detail_images' => 'array|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $slug = time().'-'.Str::slug($request->product_name);
            $product = new Product();
            $product->product_slug = $slug;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_description = $request->product_description;
            $product->product_image = $request->file('product_image')->store('product_images',['disk'=>'public']);
            $product->user_id = auth()->user()->id;
            

            if ($request->hasFile('product_detail_images')) {
                $arrayImages = [];
                foreach ($request->file('product_detail_images') as $image) {
                    $arrayImages[] = $image->store('product_images',['disk'=>'public']);
                }
                $product->product_detail_images = json_encode($arrayImages);
            }

            

            $product->save();
            
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully'
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Product failed to create : '.$th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'data'=>$product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_detail_images' => 'array|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $oldProductImage = null;
            $slug = time().'-'.Str::slug($request->product_name);
            $product->product_slug = $slug;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_description = $request->product_description;
            if ($request->hasFile('product_image')) {
                $oldProductImage = $product->product_image;
                $product->product_image = $request->file('product_image')->store('product_images');
            }

            if ($request->hasFile('product_detail_images')) {
                $arrayImages = [];
                foreach ($request->file('product_detail_images') as $image) {
                    $arrayImages[] = $image->store('product_images');
                }
                $product->product_detail_images = json_encode($arrayImages);
            }

            $product->save();
            
            DB::commit();
            //delete old image
            if($oldProductImage && Storage::exists($oldProductImage)){
                Storage::delete($oldProductImage);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Product failed to update'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            //delete image
            if(Storage::exists($product->product_image)){
                Storage::delete($product->product_image);
            }

            $productDetailImages = json_decode($product->product_detail_images);

            if ($productDetailImages) {
                foreach ($productDetailImages as $image) {
                    if(Storage::exists($image)){
                        Storage::delete($image);
                    }
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Product failed to delete'
            ], 500);
        }
    }
}
