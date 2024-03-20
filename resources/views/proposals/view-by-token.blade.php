<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proposal Information</title>
    {{-- Add any stylesheets here --}}
    
</head>
<body>
    <header>
        <h1>Mayvis</h1>
    </header>
    <main>
        <div class="container">
            <p>
                Let's get together, smash your goals & drive results.
            </p>
            {{-- Add your logo here --}}
            <img src="{{ asset('path_to_your_logo.png') }}" alt="Logo">

            {{-- Display user details --}}
            @foreach ($users as $user)
                <p>{!! $user->automated_message !!}</p>
                <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                <div>
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle profile-photo">
                </div>
                <p>{{ $user->job_title }}</p>
            @endforeach

            {{-- Loop through selected products --}}
            
            <ul>
                {{-- {{ dd($products) }} --}}
                @foreach ($products as $product)
                    <li>
                        Name: {{ $product->product_name }},
                        Price: ${{ number_format($product->price, 2) }},
                        Description: {{ $product->product_description ?? 'N/A' }} 
                    </li>
                @endforeach
            </ul>
            <p>Proposal Total: ${{ number_format($proposal->proposal_price, 2) }}</p>
            

            {{-- Feedback form --}}
            <form action="{{ route('link.feedback') }}" method="POST">
                @csrf
                <input type="hidden" name="proposalId" value="{{ $proposal->id }}">

                <div>
                    <label for="updateStatus">These look good to me.</label>
                    <input type="radio" name="updateStatus" value="1">

                    <label for="updateStatus">I am unsure, let's talk.</label>
                    <input type="radio" name="updateStatus" value="2">
                </div>

                <div>
                    <label for="clientMessage">Message:</label>
                    <textarea name="clientMessage"></textarea>
                </div>

                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
    <footer>
        {{-- Footer content here --}}
    </footer>
    
</body>
</html>
