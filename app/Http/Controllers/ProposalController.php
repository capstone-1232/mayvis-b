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
use DOMDocument;

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

    public function getClientInfo(Request $request)
    {
        $firstName = $request->query('first_name');
        $clients = Client::where('first_name', 'like', '%' . $firstName . '%')->get();

        if (!$clients->isEmpty()) {
            return response()->json(['clients' => $clients]);
        } else {
            return response()->json(['clients' => []]);
        }
    }




    /* Storing Step 1 Starts Here */
    public function storeStep1(Request $request)
    {

        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

        // Validate and store step 1 data in session
        $request->validate([
            'first_name' => ['required', 'max:80', 'regex:/^[a-zA-Z\'\- ]+$/'],
            'last_name' => ['required', 'max:80', 'regex:/^[a-zA-Z\'\- ]+$/'],
            'company_name' => 'required|max:80',
            'email' => ['required', 'email', 'regex:/^.+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
        ], [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 80 characters.',
            'first_name.regex' => 'The first name must only contain letters, spaces, dashes, and apostrophes.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 80 characters.',
            'last_name.regex' => 'The last name must only contain letters, spaces, dashes, and apostrophes.',
            'company_name.required' => 'The company name field is required.',
            'company_name.max' => 'The company name may not be greater than 80 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.', 
        ]);
        
        
        
        
        // Store step 1 data in session
        session()->put('step1_data', $request->all());
        
        // Redirect to step 2
        return redirect()->route('proposals.step2');
    }

    /* Step 2 Starts Here */

    public function showStep2()
    {

        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

        // Check if step1_data is present in the session
        if (!session()->has('step1_data') || empty(session()->get('step1_data'))) {
            // If step1_data is empty, redirect back to the Step 1 route
            return redirect()->route('proposals.step1')->with('error', 'Please complete Step 1 first.');
        }
        
        // If step1_data is present, proceed to show Step 2 view
        return view('proposals.step2');
    }

    public function storeStep2(Request $request){
        
        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

        // Validate and store step 2 data in session
        $request->validate([
            'proposal_title' => 'required|max:100',
            'start_date' => 'required|date',
        ],[
            'proposal_title.required' => 'The Proposal Title field is required.',
            'start_date.required' => 'The date created field is required.',
            'start_date.date' => 'The date created field must be a valid date.',
        ]);
        

        $step1Data = session('step1_data');
        
        // Store step 2 data in session
        session()->put('step2_data', $request->all());

        // Redirect to step 3
        return redirect()->route('proposals.step3');

    }

    public function showStep3(){

        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

        // Check if step2_data is present in the session
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

        // Check if a user with the given email exists in the database
        $userExists = User::where('email', $senderEmail)->exists();

        if(!$userExists){
            return redirect()->back()->with('error', 'No user found with the email "' . $senderEmail . '". Please check the name and try again.');
        }
   
        // Store step 3 data in session
        session()->put('step3_data', $request->all());


        // Redirect to step 3
        return redirect()->route('proposals.step4');


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
        $products = collect(); // An empty collection (to be filled by the user as they pick the products)

        // Return the view and pass the categories and the empty products collection to it
        return view('proposals.step4', compact('categories', 'products'));
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
                ];
            }));
        }
        
    }


    public function searchProducts(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search_term');
            $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')->get();
            
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
        $step4Data = session('step4_data'); 
    
        // conditional statement for if selectedProducts within step4Data exists.
        if (isset($step4Data['selectedProducts']) && is_string($step4Data['selectedProducts'])) {
            $selectedProductIds = explode(',', $step4Data['selectedProducts']);
    
            // Fetch product names, prices, and descriptions from the database based on the selectedProductIds
            $products = Product::whereIn('id', $selectedProductIds)->get(['id', 'product_name', 'price', 'product_description']);
    
            // We will store our product information in this array so we can maybe pluck it later
            $selectedProductsInfo = [];
    
            foreach ($products as $product) {
                // Map the product ID to its name, price, and description
                $selectedProductsInfo[$product->id] = [
                    'name' => $product->product_name,
                    'price' => $product->price ?? 'No Price', 
                    'description' => $product->product_description ?? '', 
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
        $step4Data = session('step4_data');

        // Check if we have product updates in the request
        if ($request->has('products')) {
            $updatedProducts = [];
            foreach ($request->input('products') as $productId => $productDetails) {
                // Update the session data with new price, quantity, and description
                $updatedProducts[$productId] = [
                    'price' => $productDetails['price'],
                    'quantity' => $productDetails['quantity'],
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
            // If there are no draft id present then we just proceed as normal with storing our data inside sessions
            $step1Data = session('step1_data');
            $step2Data = session('step2_data');
            $step3Data = session('step3_data');
            $step4Data = session('step4_data');
        } else {
            // If no data is available, redirect to the drafts list with an error. (This is just an emergency fallback. Only in RARE cases)
            return redirect()->route('proposals.listDrafts')->with('error', 'No proposal data found.');
        }
        
        // Proceed to the step 6 view with the data.
        return view('proposals.step6', compact('step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }




    public function showStep7(Request $request){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
        }

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

        // Update Existing Client or Create a new one (updateOrCreate works nicely with composite keys. It is a bit finicky at times though)
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email']
            ],
            $step1Data
        );

        // Prepare the products as a string of IDs so we can easily identify them later on
        $productIds = array_keys($step4Data['selectedProducts']);
        $productIdsString = implode(',', $productIds);

        $selectedProductsDescriptions = collect($step4Data['selectedProducts'] ?? [])
        ->pluck('description')
        ->map(function ($description) {
            return strip_tags($description);
        })
        ->implode(', ');

        $updatedPrices = collect($step4Data['selectedProducts'] ?? [])
        ->pluck('price')
        ->implode(',');

        // Collect all session data related to the proposal
        $draftData = collect([
            'step1_data' => $step1Data,
            'step2_data' => $step2Data,
            'step3_data' => $step3Data,
            'step4_data' => $step4Data,
            'project_scope' => $selectedProductsDescriptions,
        ])->toJson();

        $uniqueToken = Str::random(60); // Generate a unique token

        // get the user's first name and last name based on the email so we can present it to the client view for when someone makes a proposal for them
        $user = User::where('email', $step3Data['sender'])->first(['first_name', 'last_name', 'id']);

        // string concatenation. No biggie here.
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
                'project_scope' => $selectedProductsDescriptions,
                'updated_price' => $updatedPrices,
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

            // Once deleted, forget the session data just in case.
            $request->session()->forget(['step1_data', 'step2_data', 'step3_data', 'step4_data']);
            return redirect()->route('proposals.listDrafts')->with('success', 'Draft deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('proposals.listDrafts')->with('error', 'An unexpected error occurred while deleting the draft.');
        }
    }

    
    
}