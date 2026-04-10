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

    public function index(Request $request)
    {
        try {
            $vendorId = auth()->id();

            $query = Order::with(['product', 'user']); // user = customer

            // Only vendor products
            $query->whereHas('product', function ($q) use ($vendorId) {
                $q->where('user_id', $vendorId);
            });

            // SEARCH 
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('product', function ($p) use ($search) {
                        $p->where('title', 'LIKE', "%{$search}%");
                    });
                });
            }

            // PAGINATION
            $perPage = $request->get('per_page', 8);
            $orders = $query->latest()->paginate($perPage);

            // IMAGE URL
            $orders->getCollection()->transform(function ($order) {
                if ($order->product && $order->product->image) {
                    $order->product->image_url = asset('storage/' . $order->product->image);
                } else {
                    $order->product->image_url = null;
                }
                return $order;
            });

            return response()->json([
                'status' => true,
                'data' => $orders->items(),
                'totalPages' => $orders->lastPage(),
                'totalItems' => $orders->total(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
