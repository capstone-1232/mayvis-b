<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showStep1()
    {
        return view('proposals.step1');
    }

    /**
     * Store a newly created resource in storage.
     */

    /* Step 1 Starts Here */
    public function storeStep1(Request $request)
    {
        // Validate and store step 1 data in session
        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'company_name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'phone_number' => ['required', 'regex:/^\\d{3}\\d{3}\d{4}$/']
        ], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'company_name.required' => 'The company name field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.regex' => 'The phone number format is invalid.',

        ]);
        // Store step 1 data in session
        session()->put('step1_data', $request->all());
        
        // Redirect to step 2
        return redirect()->route('proposals.step2');
    }

    /* Step 2 Starts Here */

    public function showStep2()
    {
        
        return view('proposals.step2');
        
    }

    public function storeStep2(Request $request){
        // Validate and store step 2 data in session
        $request->validate([
            'proposal_title' => 'required|max:30',
            'start_date' => 'required',
        ],[
            'proposal_title.required' => 'The Proposal Title field is required.',
            'start_date.required' => 'The date created field is required'
        ]);

        $step1Data = session('step1_data');
        
        // Store step 2 data in session
        session()->put('step2_data', $request->all());

        // Redirect to step 3
        return redirect()->route('proposals.step3');

    }

    public function showStep3(){
        return view('proposals.step3');
    }

    public function storeStep3(Request $request){
        // Validate and store step 2 data in session
        $request->validate([
            'sender' => 'required|max:30',
            'automated_message' => 'required|max:600',
        ],[
            'sender.required' => 'The Sender field is required.',
            'automated_message.required' => 'The automated message field is required'
        ]);

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        
        // Store step 2 data in session
        session()->put('step3_data', $request->all());

        // Redirect to step 3
        return redirect()->route('proposals.step4');

        // dd(session()->all());

    }

    public function showStep4()
    {
        $categories = Category::all(); // Fetch all categories

        // Assuming no category is selected yet, so no products
        $products = collect(); // An empty collection

        // Return the view and pass the categories and the empty products collection to it
        return view('proposals.step4', compact('categories', 'products'));
    }

    
    public function filterProducts(Request $request)
    {
        $categoryId = $request->input('category_id');
        $categories = Category::all(); // Fetch all Categories
        $products = Product::where('category_id', $categoryId)->get(); // Make sure to set the relationship between Products and Categories in the Model

        // Return the view and pass the categories and products to it
        return view('proposals.step4', compact('categories', 'products', 'categoryId'));
    }

    public function searchProducts(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $categories = Category::all(); // Fetch categories to pass to the view
        $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')->get();

        

        // Assuming you want to return the same view but with filtered products based on the search term
        return view('proposals.step4', compact('products', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
