<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    // GET PRODUCTS
    public function index(Request $request)
    {
        try {
            $query = Product::with('category');

            // SEARCH
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // FILTER
            if ($request->filled('filter') && $request->filter !== 'All') {
                $filter = $request->filter;

                $query->whereHas('category', function ($q) use ($filter) {
                    $q->where('name', $filter);
                });
            }

            // PAGINATION
            $perPage = $request->get('per_page', 8);
            $products = $query->paginate($perPage);

            // Transform collection (add image_url)
            $products->getCollection()->transform(function ($product) {
                $product->image_url = $product->image
                    ? asset('storage/' . $product->image)
                    : null;
                return $product;
            });

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

    // HELPER: GET CATEGORY ID
    private function getCategoryId($categoryName)
    {
        return Category::where('name', $categoryName)->value('id');
    }

    // CREATE PRODUCT
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'category' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Category check
            $categoryId = $this->getCategoryId($validated['category']);

            if (!$categoryId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid category'
                ], 400);
            }

            // Upload image
            $imagePath = $request->file('image')->store('products', 'public');

            // Create product
            $product = Product::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $categoryId,
                'image' => $imagePath,
            ]);

            // Image URL
            $product->image_url = asset('storage/' . $product->image);

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // UPDATE PRODUCT
    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'category' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Category check
            $categoryId = $this->getCategoryId($validated['category']);

            if (!$categoryId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid category'
                ], 400);
            }

            // Image update
            if ($request->hasFile('image')) {

                // Delete old image
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                // Upload new image
                $imagePath = $request->file('image')->store('products', 'public');
                $product->image = $imagePath;
            }

            // Update fields
            $product->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $categoryId,
            ]);

            // Image URL
            $product->image_url = $product->image
                ? asset('storage/' . $product->image)
                : null;

            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE PRODUCT
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Delete image
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