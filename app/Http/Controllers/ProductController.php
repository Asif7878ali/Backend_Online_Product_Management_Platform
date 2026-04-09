<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::with('category');

            // SEARCH (title / description)
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // FILTER (category name)
            if ($request->filled('filter') && $request->filter !== 'All') {
                $filter = $request->filter;

                $query->whereHas('category', function ($q) use ($filter) {
                    $q->where('name', $filter);
                });
            }

            // PAGINATION (dynamic per page optional)
            $perPage = $request->get('per_page', 8);

            $products = $query->paginate($perPage);

            return response()->json([
                'status' => true,
                'data' => $products->items(),
                'totalPages' => $products->lastPage(),
                'totalItems' => $products->total(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            // Check if product exists
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            //  Optional: delete image from storage
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Delete product
            $product->delete();

            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
