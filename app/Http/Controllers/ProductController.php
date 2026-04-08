<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Pagination (8 per page)
            $products = Product::paginate(8);

            return response()->json([
                'status' => true,

                //product data
                'data' => $products->items(),

                //Total pages
                'totalPages' => $products->lastPage(),

                //Total items in DB
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
