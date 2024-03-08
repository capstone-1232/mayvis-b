<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProposalController extends Controller
{

    public function showStep1()
    {
        return view('proposals.step1');
    }

    /* Step 1 Starts Here */
    public function storeStep1(Request $request)
    {
        // Validate and store step 1 data in session
        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'company_name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'phone_number' => ['required', 'regex:/^\d{3}\d{3}\d{4}$/']
        ], [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 30 characters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 30 characters.',
            'company_name.required' => 'The company name field is required.',
            'company_name.max' => 'The company name may not be greater than 30 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.regex' => 'The phone number format is invalid.'
        ]);

        
        
        // Store step 1 data in session
        session()->put('step1_data', $request->all());
        
        // Redirect to step 2
        return redirect()->route('proposals.step2');
    }

    /* Step 2 Starts Here */

    public function showStep2()
    {
        // Debugging: Check the session data
        // dd(session()->all()); // This will dump and die, showing all session data

        // Check if step1_data is present in the session
        if (!session()->has('step1_data') || empty(session()->get('step1_data'))) {
            // If step1_data is empty, redirect back to the Step 1 route
            return redirect()->route('proposals.step1')->with('error', 'Please complete Step 1 first.');
        }
        
        // If step1_data is present, proceed to show Step 2 view
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

        // dd(session()->all());
        // Check if step1_data is present in the session
        if (!session()->has('step2_data') || empty(session()->get('step2_data'))) {
            // If step2_data is empty, redirect back to the Step 2 route
            return redirect()->route('proposals.step2')->with('error', 'Please complete Step 2 first.');
        }

        return view('proposals.step3');
    }

    public function storeStep3(Request $request){

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        
        // Store step 3 data in session
        session()->put('step3_data', $request->all());


        // Redirect to step 3
        return redirect()->route('proposals.step4');

        // dd(session()->all());

    }

    public function showStep4()
    {

        if (!session()->has('step3_data') || empty(session()->get('step3_data'))) {
            // If step3_data is empty, redirect back to the Step 3 route
            return redirect()->route('proposals.step3')->with('error', 'Please complete Step 3 first.');
        }

        $categories = Category::all(); // Fetch all categories

        // Assuming no category is selected yet, so no products
        $products = collect(); // An empty collection

        // Return the view and pass the categories and the empty products collection to it
        return view('proposals.step4', compact('categories', 'products'));
    }

    
    public function filterProducts(Request $request)
    {
        if ($request->ajax()) {
            $categoryId = $request->input('category_id');
            $products = Product::where('category_id', $categoryId)->get();
            
            // Assuming you have the product_name and description fields on your products
            return response()->json($products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'price' => $product->price,
                    'description' => $product->product_description,
                ];
            }));
        }
        
    }


    public function searchProducts(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search_term');
            $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')->get();
            
            // Assuming you have the product_name and description fields on your products
            return response()->json($products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'price' => $product->price,
                    'description' => $product->product_description,
                ];
            }));
        }
        
    }

    public function storeStep4(Request $request){

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');

        $request->validate([
            'selectedProducts' => 'required',
        ],[
            'selectedProducts.required' => 'You must select products in order to proceed.',
        ]);

        // Retrieve data
        $selectedProducts = explode(',', $request->input('selectedProducts'));
        $totalPrice = $request->input('totalPrice');
        $proposalTotal = $request->input('proposalTotal');

        // Store into session
        $request->session()->put('selectedProducts', $selectedProducts);
        $request->session()->put('totalPrice', $totalPrice);
        $request->session()->put('proposalTotal', $proposalTotal);

        // Store everything in one
        session()->put('step4_data', $request->all());

        // Redirect to step 5
        return redirect()->route('proposals.step5');

    }

    /* PLEASE DO NOT TOUCH THIS METHOD */
    public function showStep5()
    {
        if (!session()->has('step4_data') || empty(session()->get('step4_data'))) {
            // If step4_data is empty, redirect back to the Step 4 route
            return redirect()->route('proposals.step4')->with('error', 'Please complete Step 4 first.');
        }
    
        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data'); // Retrieve the data stored in step 4
    
        // Ensure selectedProducts is an array
        if (isset($step4Data['selectedProducts']) && is_string($step4Data['selectedProducts'])) {
            $selectedProductIds = explode(',', $step4Data['selectedProducts']);
    
            // Fetch product names, prices, and descriptions from the database based on the selectedProductIds
            $products = Product::whereIn('id', $selectedProductIds)->get(['id', 'product_name', 'price', 'product_description']);
    
            // Initialize an array to hold the product name, price, and description  
            $selectedProductsInfo = [];
    
            foreach ($products as $product) {
                // Map the product ID to its name, price, and description
                $selectedProductsInfo[$product->id] = [
                    'name' => $product->product_name,
                    'price' => $product->price ?? 'No Price', // Assume price is always available but add a fallback just in case
                    'description' => $product->product_description ?? '', // Default to empty string if description is not set
                ];
            }
    
            // Replace the product IDs in step4Data with the fetched product names, prices, and descriptions
            $step4Data['selectedProducts'] = $selectedProductsInfo;
    
            // Store the modified data back into the session
            session(['step4_data' => $step4Data]);
        }
    
        // Pass the modified data to the view
        return view('proposals.step5', compact('step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }
    
    public function storeStep5(Request $request)
    {
        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data'); // Retrieve the step 4 data from the session
    
        // Check if we have product updates in the request
        if ($request->has('products')) {
            foreach ($request->input('products') as $productId => $productDetails) {
                // Update the session data with new price, quantity, and description
                if (isset($step4Data['selectedProducts'][$productId])) {
                    $step4Data['selectedProducts'][$productId]['price'] = $productDetails['price'];
                    $step4Data['selectedProducts'][$productId]['quantity'] = $productDetails['quantity'];
                    $step4Data['selectedProducts'][$productId]['description'] = $productDetails['description'];
                }
            }
    
            // Recalculate totals based on updated prices and quantities
            $totalPrice = 0;
            foreach ($step4Data['selectedProducts'] as $product) {
                $totalPrice += $product['price'] * $product['quantity'];
            }
            $step4Data['totalPrice'] = $totalPrice;
    
            // Proposal total is the same as total price since there's no recurring total
            $step4Data['proposalTotal'] = $totalPrice;
    
            // Update the session with the modified data
            session(['step4_data' => $step4Data]);
        }
    
        // Redirect to the next step or another page
        return redirect()->route('proposals.step6');
    }
    


    public function showStep6(){

        if (!session()->has('step4_data') || empty(session()->get('step4_data'))) {
            // If step4_data is empty, redirect back to the Step 4 route
            return redirect()->route('proposals.step4')->with('error', 'Please complete Step 4 first.');
        }

        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data'); // Retrieve the step 4 data from the session
    
        // Pass the session data to the view
        return view('proposals.step6', compact('step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }

    public function showStep7(){
        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data'); // Retrieve the step 4 data from the session
        // Pass the session data to the view
        return view('proposals.step7', compact('step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }
    
}
