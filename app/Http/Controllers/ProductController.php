<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
}
