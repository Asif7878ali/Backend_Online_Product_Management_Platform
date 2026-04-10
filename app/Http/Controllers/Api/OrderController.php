<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            // Lock product row (important for concurrency)
            $product = Product::lockForUpdate()->find($request->product_id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            // Not enough stock
            if ($product->stock < $request->quantity) {
                return response()->json(['message' => 'Not enough stock'], 400);
            }

            //  Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total_price' => $product->price * $request->quantity,
            ]);

            // Reduce stock safely
            $product->decrement('stock', $request->quantity);

            // Refresh product to get updated stock
            $product->refresh();

            // Low stock check
            if ($product->stock <= $product->threshold) {
                // agar job banaya hai tab use karo
                // dispatch(new LowStockJob($product));
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'data' => $order
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}