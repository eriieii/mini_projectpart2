<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\DetailProduct;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name = $request->input('name');
        $slug = $request->input('slug');
        $category = $request->input('category');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
       
        if($id)
        {
            $product = Product::with('detailProduct')->find($id);

            if($product)
            {
                return ResponseFormatter::success($product, 'Get Data Product Success');
            }
            else
            {
                return ResponseFormatter::error(null, 'Data Product Empty', 404);
            }
        }

        if($slug)
        {
            $product = Product::where('slug', $slug)->first();

            if($product)
            {
                return ResponseFormatter::success($product, 'Get Data Product Success');
            }
            else
            {
                return ResponseFormatter::error(null, 'Data Product Not Found', 404);
            }
        }
       
        if($name)
        {
            $product = DB::connection('mongodb')
                        ->collection('products')
                        ->where('name', 'like', '%' . $name . '%')
                        ->get();

            if(is_null($product))
                {
                    return ResponseFormatter::error(null, 'Data Product Not Found', 404);                    
                }
                else
                {
                    return ResponseFormatter::success($product, 'Get Data Product Success');
                }
        }     

       if($category)
        {
            $product = DB::connection('mongodb')
                        ->collection('products')
                        ->where('category', 'like', '%' . $category . '%')
                        ->get();

            if(is_null($product))
                        {
                            return ResponseFormatter::error(null, 'Data Product Not Found', 404);                    
                        }
                        else
                        {
                            return ResponseFormatter::success($product, 'Get Data Product Success');
                        }
        }

        if($price_from)
        {
            $product=  Product::where('price', '>=', $price_from);
            if(is_null($product))
            {
                return ResponseFormatter::error(null, 'Data Product Not Found', 404);               
            }
            else
            {
                return ResponseFormatter::success($product, 'Get Data Product Success');
            }
        }
           

        if($price_to)
        {
            $product =  Product::where('price', '>=', $price_to);
            if(is_null($product))
            {
                return ResponseFormatter::error(null, 'Data Product Not Found', 404);
            }
            else
            {
                return ResponseFormatter::success($product, 'Get Data Product Success');
            }
        }

        return ResponseFormatter::success(
            Product::with('detailProduct')->paginate($limit),
            'Get Data Product Success'
        );
    }

    public function store(ProductRequest $request){
        
        $data = $request->except('color');
        $data['slug'] = Str::slug($request->name);
      
        $product = Product::create($data); 
       
        $colors = $request->color; 
        $sizes = $request->size;

        foreach ($colors as $color) {
            foreach ($sizes as $size) {
                DetailProduct::create([
                    'product_id' => $product->id,
                    'color' => $color,
                    'size' => $size
                ]);
            }
           
        }        
      
        return ResponseFormatter::success($product, 'Product Has Been Created');      
    }
}
