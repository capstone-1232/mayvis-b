<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexCategory()
    {
        $categories = Category::all(); // Retrieve all categories from the database
        return view('categories.index-category', compact('categories')); // Pass the categories to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createCategory()
    {
        $categories = Category::all(); // Get all categories
        return view('categories.create-category', compact('categories'));
    }

    public function storeCategory(Request $request)
     {
         // Validate the request
         $validatedData = $request->validate([
            'category_name' => 'required|max:255',
            'notes' => 'nullable',
            'created_by' => 'required|max:30'
        ], [
            'created_by' => 'this field cannot be empty.',
            'category_name.required' => 'The category name field is required.', 
            'category_name.max' => 'The category name must not be greater than 255 characters.', 
        ]);

        $validatedData['created_by'] = Auth::user()->first_name . ' ' . Auth::user()->last_name; 

     
         // Create a new Category instance and save it to the database
         $category = Category::create($validatedData);
     
         // Redirect to the services index with a success message
         return redirect()->route('servicesIndex')->with('success', 'Category created successfully.');
     }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id); 
        return view('categories.edit-category', compact('category')); // Pass the category to the view
    }

    public function updateCategory(Request $request, $id)
    {

        $request->validate([
            'category_name' => 'required|max:30',
            'notes' => 'nullable|max:600'
        ], [       
            'category_name.required' => 'category name must not be left empty',
            'category_name.max' => 'The category name must not be greater than 30 characters.',        
            'notes.max' => 'The notes must not be greater than 600 characters.',
        ]);

        $category = Category::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->notes = $request->notes;
    
        $category->save();

        return redirect()->route('servicesIndex')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('servicesIndex')->with('success', 'Category deleted successfully.');
    }
}
