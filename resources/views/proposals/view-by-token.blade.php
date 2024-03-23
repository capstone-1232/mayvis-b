<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proposal Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('main.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
    <header>
        <div class="container">
            <div class="logo-placeholder">
                <svg aria-labelledby="svg-mayvis-logo" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 311.5 113.4" xml:space="preserve" class="inline h-36 w-25 fill-current">
                  <title id="svg-mayvis-logo">
                    MAYVIS Estimate System
                  </title>
                  <g>
                    <path d="M75.5,37.8v37.8h-6.7V51.5l-6.6,5.1l-5.5,4.3l-5.5-4.3l-6.6-5.1v24.1h-6.7V37.8l6.7,5.2l12.1,9.3L68.8,43L75.5,37.8z"></path>
                    <path d="M122.6,75.6h-7.6l-3.5-6.7l-8.3-16.2l-8.3,16.2l-3.5,6.7h-7.6l3.5-6.7l15.8-31l15.8,31L122.6,75.6z"></path>
                    <path d="M122.6,75.6h0.1l-0.1,0.1V75.6z M160.4,37.7l-14.6,18.9l-0.8,1v17.8h-6.7V57.8l-0.9-1.1l-14.6-18.9h8.5l10.4,13.4
                    l10.4-13.4H160.4z M160.3,75.6L160.3,75.6l0.1,0.1L160.3,75.6z"></path>
                    <path d="M204.8,37.8l-3.5,6.7l-15.8,31l-15.8-31l-3.5-6.7h7.6l3.5,6.7l8.3,16.2l8.3-16.2l3.5-6.7H204.8z"></path>
                    <path d="M216.4,75.6V37.8h6.7v37.8H216.4z"></path>
                    <path d="M266.9,48.3V48c0-1.9-1.6-3.5-3.5-3.5h-15.3c-1.9,0-3.5,1.6-3.5,3.5v0.2c0,1.9,1.6,3.5,3.5,3.5h13.6c3.5,0,6.6,1.5,8.8,3.9
                    c0.2,0.2,0.3,0.3,0.4,0.5c1.7,2,2.7,4.7,2.7,7.6c0,6.6-5.3,11.9-11.9,11.9h-11.8c-6.6,0-11.9-5.3-11.9-11.9h6.7
                    c0,2.9,2.3,5.2,5.2,5.2h11.8c2.9,0,5.2-2.3,5.2-5.2c0-2.9-2.4-5.2-5.2-5.2h-13.6c-2.8,0-5.2-1.1-7.1-2.9c-0.5-0.5-0.9-1-1.3-1.6
                    c-1.1-1.6-1.8-3.6-1.8-5.8V48c0-5.6,4.5-10.2,10.1-10.2h15.3c5.6,0,10.2,4.6,10.2,10.2v0.2L266.9,48.3z"></path>
                  </g>
                </svg>
              </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="keen-background mb-3 mt-5">
                <div class="mb-4">
                    <img src="{{ asset('images/keen-creatives-logo.webp') }}" alt="Logo" class="mb-4 w-25">
                    <p class="keen-text fs-4">
                        Let's get together, do cool stuff, and change the world.
                    </p>
                </div>
            </div>

            
            <!-- Display user details -->
                <div class="my-5">
                    <h2 class="fw-bold heading-4">Hello {{ $client->first_name }}</h2>

                    <!-- User's Automated Message -->
                    <div class="automated-message">
                        @if($proposal->automated_message)
                            <p>{!! $proposal->automated_message !!}</p>
                        @else
                            <!-- Assuming $user is available and contains the fallback automated message -->
                            @foreach($users as $user)
                                <p>{!! $user->automated_message !!}</p>
                            @endforeach
                        @endif
                    </div>
                    

                    @foreach ($users as $user)
                    <div class="user-card mb-4">

                        <div class="user-info d-flex align-items-center">
                            <!-- User's Profile Image -->
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle mb-2" style="width: 50px; height: 50px; margin-right: 10px;">

                            <!-- User's Name and Job Title -->
                            <div>
                                <p class="user-name fw-bold mb-0">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="user-job-title text-secondary" style="font-size: .875em;">{{ $user->job_title }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Display user proposal message-->
                <img src="{{ asset('images/keen-creatives-logo.webp') }}" alt="Logo" class="mb-4 w-25">
                @foreach ($users as $user)
                    <div class="user-card mb-4 w-full">
                        <!-- User's Proposal Message -->
                        <div class="proposal-message">
                            <p>{!! $user->proposal_message !!}</p>
                        </div>
                    </div>
                @endforeach

                <h2 class="heading-4 fw-bold">Proposed Items</h2>

                <!-- Loop through selected products -->
                <div class="proposal-section" style="font-family: Arial, sans-serif;">
                    <ul class="list-group mb-4">
                        @foreach ($products as $product)
                        <li class="list-group-item d-block py-3 border-0 border-bottom border-gray-200">
                            <div class="d-flex justify-content-between">
                                <span class="item-name fw-bold">{{ $product->product_name }}</span>
                                <span class="item-price fw-bold">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <p class="item-description mt-1 text-muted" style="color: #666;">{{ $product->product_description ?? 'N/A' }}</p>
                        </li>
                        @endforeach
                    </ul>
                    <p class="text-end fw-normal mb-5">Proposal Total: ${{ number_format($proposal->proposal_price, 2) }}</p>
                </div>

            

            <!-- Feedback form -->
            <form action="{{ route('link.feedback') }}" method="POST" class="mb-5">
                @csrf
                <input type="hidden" name="proposalId" value="{{ $proposal->id }}">
            
                <h2 class="mb-3">Ready to Get Started</h2>
            
                <div class="mb-3">
                    <label for="clientMessage" class="form-label">Tell us if you have any comments about this proposal.</label>
                    <textarea name="clientMessage" id="clientMessage" class="form-control" placeholder="Are there any comments or questions about this proposal?" rows="4"></textarea>
                </div>
            
                <!-- Radio button options -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="updateStatus" id="option1" value="1">
                        <label class="form-check-label" for="option1">
                            These look good to me.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="updateStatus" id="option2" value="2">
                        <label class="form-check-label" for="option2">
                            I am unsure, let's talk.
                        </label>
                    </div>
                </div>
            
                <button type="submit" class="btn btn-primary">SUBMIT</button>
            </form>
        </div>
    </main>
    <footer class="container">
        <p class="text-center">Connect with us:</p>
        <!-- Add social media links here -->
    </footer>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
