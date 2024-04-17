<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function servicesIndex(Request $request)
    {   
        $query = Product::query();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(3);
        $categories = Category::all(); 

        return view('services.servicesIndex', compact('products', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createProduct()
    {
        $categories = Category::all(); // Get all categories
        return view('services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function storeProduct(Request $request)
     {
         // Validate the request
         $validatedData = $request->validate([
            'product_name' => 'required|max:255',
            'product_description' => 'required|min:1|max:5000',
            'category_id' => 'required|exists:categories,id',
            'product_notes' => 'nullable',
            'price' => 'required|numeric|min:0|max:99999',
            'created_by' => 'required|max:30',
        ], [
            'product_name.required' => 'The product name field is required.',
            'product_name.max' => 'The product name must not be greater than 255 characters.',
            'product_description.required' => 'The product description field is required.',
            'product_description.max' => 'The product description must not be greater than 5000 characters.',
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'price.max' => 'The price cannot be higher than 99999.',
            'created_by.required' => 'This field cannot be left empty.',
            'created_by.max' => 'Name is too long.'
        ]);

        $validatedData['created_by'] = Auth::user()->first_name . ' ' . Auth::user()->last_name; // Set the created_by directly from the authenticated user

     
         // Create a new Product instance and save it to the database
         Product::create($validatedData);
     
         return redirect()->route('servicesIndex')->with('success', 'Product created successfully.');
     }

    public function filterProducts(Request $request)
    {
        if ($request->ajax()) {
            $categoryId = $request->input('category_id');
            $products = Product::where('category_id', $categoryId)->get();
            
            return response()->json($products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'price' => $product->price,
                    'description' => $product->product_description,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'created_by' => $product->created_by,
                ];
            }));
        }
        
    }
     

    /**
     * Show the form for editing the specified resource.
     */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id); 
        return view('services.edit', compact('product')); 
    }

    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|min:1|max:30',
            'product_description' => 'required|min:1|max:600',
            'price' => 'required|numeric|min:0|max:99999',
            'product_notes' => 'nullable|max:600'
        ], [       
            'product_name.min' => 'The product name cannot be empty.',
            'product_name.max' => 'The product name must not be greater than 30 characters.',        
            'product_description.min' => 'The product description cannot be empty.',
            'product_description.max' => 'The product description must not be greater than 600 characters.',
            'price.min' => 'The product must have a price.',
            'price.numeric' => 'The price must be a number.',
            'price.max' => 'The price cannot be higher than 99999.',
            'product_notes.max' => 'The product notes must not be greater than 600 characters.',
        ]);

        $product = Product::findOrFail($id);

        $validatedData['created_by'] = Auth::user()->first_name . ' ' . Auth::user()->last_name; 

        $product->fill($validatedData);
        $product->save();

        return redirect()->route('servicesIndex')->with('success', 'Product updated successfully.');
    }


    public function searchProducts(Request $request) {
        $searchTerm = $request->input('search_term');
    
        $searchResults = Product::where('product_name', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhere('product_description', 'LIKE', '%' . $searchTerm . '%')
                                ->get();
    
        // Return JSON response
        return response()->json($searchResults);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('servicesIndex')->with('success', 'Product deleted successfully.');
    }
}
