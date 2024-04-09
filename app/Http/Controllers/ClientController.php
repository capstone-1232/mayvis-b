<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function indexClient()
    {
        $clients = Client::paginate(10); // Retrieve all clients from the database
        return view('clients.index-client', compact('clients')); // Pass the clients to the view
    }

    public function createClient()
    {
        $clients = Client::all(); // Get all clients
        return view('clients.create-client', compact('clients'));
    }

    public function storeClient(Request $request)
     {
         // Validate the request
         $validatedData = $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'company_name' => 'required|max:30',
            'email' => 'required|email|unique:clients,email',
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

     
         // Create a new client instance and save it to the database
         $client = Client::create($validatedData);
     
         // Redirect to the client index with a success message
         return redirect()->route('index-client')->with('success', 'Client created successfully.');
     }


     public function editClient($id)
     {
         $client = Client::findOrFail($id); // Eloquent will retrieve the client or fail if not found
         return view('clients.edit-client', compact('client')); // Pass the client to the view
     }
 
     public function updateClient(Request $request, $id)
     {

        $client = Client::findOrFail($id);

        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'company_name' => 'required|max:30',
            'email' => ['required', 'email', 'unique:clients,email,' . $client->id, 'regex:/^.+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'phone_number' => ['required', 'regex:/^\d{3}\d{3}\d{4}$/']
        ], [
            'first_name.required' => 'Please enter the first name.',
            'first_name.max' => 'The first name may not be greater than 30 characters.',
            'last_name.required' => 'Please enter the last name.',
            'last_name.max' => 'The last name may not be greater than 30 characters.',
            'company_name.required' => 'Please enter the company name.',
            'company_name.max' => 'The company name may not be greater than 30 characters.',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.required' => 'Phone number cannot be left empty.',
            'phone_number.regex' => 'The phone number format is invalid. Expected format: XXXXXXXXXX.',
        ]);
        

         $client = Client::findOrFail($id);
         $client->first_name = $request->first_name;
         $client->last_name = $request->last_name;
         $client->company_name = $request->company_name;
         $client->email = $request->email;
         $client->phone_number = $request->phone_number;
         
 
         $client->save();
 
         return redirect()->route('index-client')->with('success', 'Client updated successfully.');
     }

     public function destroyClient($id)
        {
            $client = Client::findOrFail($id);
            
            // Check if the client has any proposals
            if ($client->proposals()->count() > 0) {
                // Redirect back with an error message if there are related proposals
                return redirect()->route('index-client')->with('error', 'Cannot delete client because they are associated with one or more proposals.');
            }
            
            try {
                // If no proposals are related, proceed with delete
                $client->delete();
                // Redirect with a success message
                return redirect()->route('index-client')->with('success', 'Client deleted successfully.');
            } catch (\Exception $e) {
                // Redirect back with a general error message if an exception occurs
                return redirect()->route('index-client')->with('error', 'An unexpected error occurred while deleting the client.');
            }
        }


     public function searchClients(Request $request) {
        $searchTerm = $request->input('search_term');
    
        $searchResults = Client::where('first_name', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhere('company_name', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchTerm . '%'])
                                ->get();
    
        // Return JSON response
        return response()->json($searchResults);
    }
}
