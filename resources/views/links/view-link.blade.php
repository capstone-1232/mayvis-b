<!--

    Here are a list of variables that you can use and their respective session variables.

    Here are the session variables:
    $step1Data
    - first_name
    - last_name
    - company_name
    - email
    - phone_number

    $step2Data
    - proposal_title
    - start_date

    $step3Data
    - sender
    - automated_message

    $step4Data
    - product_name
    - price
    - product_description
    - selectedProducts <- This is an array so you have to loop through it. (foreach $step4Data['selectedProducts'])
    - totalPrice
    - proposalTotal

    $userData
    - first_name
    - last_name
    - profile_image
    - automated_message

    IMPORTANT INFORMATION:

    DO NOT REMOVE THE "!!" INSIDE THE CURLY BRACES. IT ALLOWS OUR PDF TO READ CONTENTS FROM TEXTAREAS MADE BY TINYMCE TO BE TREATED AS AN HTML.

-->


<!DOCTYPE html>
<html>
<head>
    <title>Session Information</title>
    {{-- <link href="{{ asset('main.css') }}" rel="stylesheet" type="text/css"> --}}
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
            <img src="#" alt="Keen Creative Logo(?)">

            <div>
                <h2>Hello There!!!</h2>
                <!-- Filter Users Query based on the sender's name and grab their job_title and profile_image ; automated_message-->
                @foreach ($users as $user)
                    <p>{!! $user->automated_message !!}</p>
                    <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p>{{ $user->profile_image }}</p>
                    <p>{{ $user->job_title }}</p>
                @endforeach

            </div>
        </div>

        <ul>
            @foreach($step4Data['selectedProducts'] as $product)
                <li>Name: {{ $product['name'] }}, Price: ${{ $product['price'] }}, Quantity: {{ $product['quantity'] }}, Description: {!! $product['description'] !!}</li> <!-- Array Loop -->
            @endforeach
            <p>Proposal Total: ${{ $step4Data['proposalTotal'] }}.00</p>
        </ul>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <form action="{{ route('link.feedback') }}" method="POST">
            @csrf
            <!-- Checkbox for updating status -->

            <input type="hidden" name="proposalId" value="{{ $proposalId }}">

            <label for="updateStatus">These look good to me.</label>
            <input type="radio" name="updateStatus" value="1">

            <label for="updateStatus">I am unsure, let's talk.</label>
            <input type="radio" name="updateStatus" value="2">
        
            <!-- Textbox for sending a message -->
            <label for="clientMessage">Message:</label>
            <textarea name="clientMessage"></textarea>
        
            <button type="submit">Submit</button>
        </form>
        
    </main>
    <footer>

    </footer>
        {{-- @foreach ($sessionData as $key => $value)
            <li>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</li>
        @endforeach --}}


</body>
</html>
