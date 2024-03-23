<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Draft;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProposalController extends Controller
{

    public function showStep1(Request $request)
    {
        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }       

        return view('proposals.step1');
    }

    /* Step 1 Starts Here */
    public function storeStep1(Request $request)
    {

        // if (!Auth::check()) {
        //     // Redirect the user to login page or show an error message
        //     return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        // }

        // Validate and store step 1 data in session
        $request->validate([
            'first_name' => 'required|max:80',
            'last_name' => 'required|max:80',
            'company_name' => 'required|max:80',
            'email' => 'required|email', 
            'phone_number' => ['required', 'regex:/^\d{3}\d{3}\d{4}$/']
        ], [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 80 characters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 80 characters.',
            'company_name.required' => 'The company name field is required.',
            'company_name.max' => 'The company name may not be greater than 80 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
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

        // if (!Auth::check()) {
        //     // Redirect the user to login page or show an error message
        //     return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        // }

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
        
        // if (!Auth::check()) {
        //     // Redirect the user to login page or show an error message
        //     return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        // }

        // Validate and store step 2 data in session
        $request->validate([
            'proposal_title' => 'required|max:100',
            'start_date' => 'required|date|after_or_equal:today',
        ],[
            'proposal_title.required' => 'The Proposal Title field is required.',
            'start_date.required' => 'The date created field is required.',
            'start_date.date' => 'The date created field must be a valid date.',
            'start_date.after_or_equal' => 'The date created must be today or a future date.',
        ]);
        

        $step1Data = session('step1_data');
        
        // Store step 2 data in session
        session()->put('step2_data', $request->all());

        // Redirect to step 3
        return redirect()->route('proposals.step3');

    }

    public function showStep3(){

        // if (!Auth::check()) {
        //     // Redirect the user to login page or show an error message
        //     return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        // }

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

        $request->validate([
            'sender' => 'required|email|exists:users,email', 
        ], [
            'sender.required' => 'The sender field is required.',
            'sender.email' => 'The sender must be a valid email address.',
            'sender.exists' => 'No user found with the email. Please check and try again.',
        ]);
        

        $senderEmail = $request->input('sender');

        // Check if a user with the given last name exists in the database
        $userExists = User::where('email', $senderEmail)->exists();

        if(!$userExists){
            return redirect()->back()->with('error', 'No user found with the email "' . $senderEmail . '". Please check the name and try again.');
        }
   
        // Store step 3 data in session
        session()->put('step3_data', $request->all());


        // Redirect to step 3
        return redirect()->route('proposals.step4');

        // dd(session()->all());

    }

    public function showStep4()
    {
        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');

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

        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

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

        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

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
            $updatedProducts = [];
            foreach ($request->input('products') as $productId => $productDetails) {
                // Update the session data with new price, quantity, and description
                $updatedProducts[$productId] = [
                    'price' => $productDetails['price'],
                    'quantity' => $productDetails['quantity'], // Save the quantity here
                    'description' => $productDetails['description'],
                ];
            }

            // Calculate the total price based on the updated prices and quantities
            $totalPrice = collect($updatedProducts)->reduce(function ($carry, $product) {
                return $carry + ($product['price'] * $product['quantity']);
            }, 0);

            // Update step4_data with the new product information and total price
            $step4Data['selectedProducts'] = $updatedProducts;
            $step4Data['proposalTotal'] = $totalPrice;

            // Update the session with the modified data
            session(['step4_data' => $step4Data]);
        }

        // Redirect to the next step or another page
        return redirect()->route('proposals.step6');
    }

    


    public function showStep6(Request $request)
    {
        // Initialize variables to store the data.
        $step1Data = [];
        $step2Data = [];
        $step3Data = [];
        $step4Data = [];

        // Check if coming from a draft summary view.
        if ($request->filled('draftId')) {
            $draftId = $request->input('draftId');
            $draft = Draft::findOrFail($draftId);
            $draftData = json_decode($draft->data, true);

            $step1Data = $draftData['step1_data'] ?? [];
            $step2Data = $draftData['step2_data'] ?? [];
            $step3Data = $draftData['step3_data'] ?? [];
            $step4Data = $draftData['step4_data'] ?? [];
        } elseif (session()->has('step4_data')) {
            // If not coming from a draft, try to get the data from the session.
            $step1Data = session('step1_data');
            $step2Data = session('step2_data');
            $step3Data = session('step3_data');
            $step4Data = session('step4_data');
        } else {
            // If no data is available, redirect to the drafts list with an error.
            return redirect()->route('proposals.listDrafts')->with('error', 'No proposal data found.');
        }
        

        // Proceed to the step 6 view with the data.
        return view('proposals.step6', compact('step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }




    public function showStep7(Request $request){
        // Ensure the user is authenticated
        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

        // Redirect or return view with success message
        return view('proposals.step7');
    }

    public function saveDraft(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to save a draft.');
        }

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        // Update Existing Client or Create a new one
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email']
            ],
            $step1Data
        );

        // Prepare the products as a string of IDs
        $productIds = array_keys($step4Data['selectedProducts']);
        $productIdsString = implode(',', $productIds);

        // Collect all session data related to the proposal
        $draftData = collect([
            'step1_data' => $step1Data,
            'step2_data' => $step2Data,
            'step3_data' => $step3Data,
            'step4_data' => $step4Data,
        ])->toJson();

        $uniqueToken = Str::random(60); // Generate a unique token

        // Execute the query to get the user and retrieve the first and last name
        $user = User::where('email', $step3Data['sender'])->first(['first_name', 'last_name', 'id']);

        // Concatenate the first name and last name with a space between them
        $createdBy = $user ? $user->first_name . ' ' . $user->last_name : null;
        
        // Get the user ID
        $getUserId = $user ? $user->id : null;

        // Update existing draft or create a new one
        $draft = Draft::updateOrCreate(
            [
                'user_id' => $getUserId,
                'client_id' => $client->id,
                'start_date' => $step2Data['start_date'],
                'proposal_title' => $step2Data['proposal_title'],
            ],
            [
                'created_by' => $createdBy,
                'status' => 'Draft',
                'proposal_price' => $step4Data['proposalTotal'] ?? null,
                'automated_message' => $step3Data['automated_message'],
                'product_id' => $productIdsString,
                'unique_token' => $uniqueToken,
                'data' => $draftData,
            ]
        );
        
        $request->session()->forget(['step1_data', 'step2_data', 'step3_data', 'step4_data']);

        // Redirect the user back to the dashboard
        return redirect()->route('dashboard')->with('success', 'Draft saved successfully.');
    }


    public function listDrafts()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view drafts.');
        }
        

        // Retrieve all drafts for the currently authenticated user
        $drafts = Draft::where('user_id', Auth::id())->get();

        // Pass the drafts to the view
        return view('proposals.listDrafts', compact('drafts'));
    }

    public function viewDraftSummary(Request $request, $draftId)
    {
        $draft = Draft::findOrFail($draftId);
        $draftData = json_decode($draft->data, true);

        // Store each part of the draft data into the session
        $request->session()->put('step1_data', $draftData['step1_data'] ?? []);
        $request->session()->put('step2_data', $draftData['step2_data'] ?? []);
        $request->session()->put('step3_data', $draftData['step3_data'] ?? []);
        $request->session()->put('step4_data', $draftData['step4_data'] ?? []);
        $request->session()->put('draftId', $draftId);

        Log::debug($draftData);

        // Now redirect to the step6 view which will utilize this session data
        return redirect()->route('proposals.step6', compact('draftId'));
    }

    public function destroyDraft(Request $request, $id)
    {
        $draft = Draft::findOrFail($id);

        // Grab the matching proposal via a unique token so when the user deletes a "denied" proposal, it will also delete that proposal from the "Proposals" table
        $proposal = Proposal::where('unique_token', $draft->unique_token)->first();

        if($proposal){
            $proposal->delete();
        }
        
        try {
            $draft->delete();
            // Redirect with a success message
            $request->session()->forget(['step1_data', 'step2_data', 'step3_data', 'step4_data']);
            return redirect()->route('proposals.listDrafts')->with('success', 'Draft deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with a general error message if an exception occurs
            return redirect()->route('proposals.listDrafts')->with('error', 'An unexpected error occurred while deleting the draft.');
        }
    }

    
}