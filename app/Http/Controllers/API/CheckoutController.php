<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\DetailTransaction;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {        
        $data = $request->except('transaction_details');
        $data['uuid'] = 'INV' . mt_rand(10000,99999) . mt_rand(100,999);
       
         $transaction = Transaction::create($data);

         foreach($request->transaction_details as $product)
         {             
             $details[] = new DetailTransaction([
                 'transaction_id' => $transaction->id,
                 'product_id' => $product
             ]); 
             Product::find($product)->decrement('qty');        
         }

         $transaction->details()->saveMany($details);

         return ResponseFormatter::success($transaction);
    }
}
