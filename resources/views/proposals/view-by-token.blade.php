<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proposal Information</title>
      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="{{ asset('main.css') }}" rel="stylesheet" type="text/css">
    {{-- Print styles --}}
    <style>
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
        @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
    
        /* Custom CSS here */
    
        @media print {
            /* Force each .page to start on a new page when printing */
            .page {
                display: block;
                page-break-before: always;
                page-break-after: always;
                overflow: hidden;
                width: 100%;
                height: auto; /* Adjust based on the content, but ensuring it fits on a single page */
            }
            
            /* Adjust the first page to not have a page break before it */
            .page:first-child {
                page-break-before: auto;
            }
    
            header, footer {
                page-break-after: avoid;
            }
    
            body, html {
                width: 100%;
                height: auto;
            }
    
            /* This sets the margins around each page. Adjust as necessary */
            @page {
                size: auto; /* auto is the initial value */
                margin: 20mm; /* this affects the margin in the printer settings */
            }
        }
    </style>
    
    

</head>
<body>
    <header class="bg-header" class="bg-header">
        <div class="container">
            <div class="text-center py-5">
                <img src="{{ asset('images/mayvis-logo-white.png') }}" alt="Logo" class="w-25 mx-auto">
            </div>
            <div class="text-center py-5">
                <img src="{{ asset('images/mayvis-logo-white.png') }}" alt="Logo" class="w-25 mx-auto">
            </div>
        </div>
    </header>
    <main>
        <div class="page">
        <div class="keen-background">
        <div class="container py-2">
            <div class="py-5">
                <div class="my-4">
                    <div class="py-4">
                        <img src="{{ asset('images/keen-text.png') }}" alt="Logo" class="keen-logo">
                    </div>
                    <div class="fs-1 fw-bolder pb-4 text-white ms-3">
                        <p class="mb-0">
                            Let's get together,
                        </p>
                        <p class="mb-0">
                            do cool stuff,
                        </p>
                        <p>
                            &amp; change the world.
                        </p>
                    </div>
                </div>
            </div>        
        </div>
        </div>
    </div>
        <div class="page">
        <div class="keen-background">
        <div class="container py-2">
            <div class="py-5">
                <div class="my-4">
                    <div class="py-4">
                        <img src="{{ asset('images/keen-text.png') }}" alt="Logo" class="keen-logo">
                    </div>
                    <div class="fs-1 fw-bolder pb-4 text-white ms-3">
                        <p class="mb-0">
                            Let's get together,
                        </p>
                        <p class="mb-0">
                            do cool stuff,
                        </p>
                        <p>
                            &amp; change the world.
                        </p>
                    </div>
                </div>
            </div>        
        </div>
        </div>
    </div>

            
            <!-- Display user details -->
            <div class="page">
            <div class="container py-4">
            <div class="page">
            <div class="container py-4">
                <div class="my-5">
                    <h2 class="fw-bold heading-4 display-2 py-2 display-2 py-2">Hello {{ $client->first_name }},</h2>

                    <!-- User's Automated Message -->
                    <div class="automated-message fs-5 w-75 py-2 fw-medium fs-5 w-75 py-2 fw-medium">
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
                    <div class="user-card my-4">
                    <div class="user-card my-4">

                        <div class="user-info d-flex align-items-center">
                            <!-- User's Profile Image -->
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle mb-2 client-view-img">
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle mb-2 client-view-img">

                            <!-- User's Name and Job Title -->
                            <div class="ms-4">
                                <p class="user-name fw-bolder mb-0 fs-4">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="user-job-title text-secondary fs-6">{{ $user->job_title }}</p>
                            <div class="ms-4">
                                <p class="user-name fw-bolder mb-0 fs-4">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="user-job-title text-secondary fs-6">{{ $user->job_title }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>

                <!-- Display user proposal message-->
                <div class="page">
                <div class="bg-dark py-4">
                <div class="container py-5">
                <div class="pt-4">
                    <img src="{{ asset('images/keen-text-white.png') }}" alt="Logo" class="keen-logo mt-5">
                </div>
                <div class="page">
                <div class="bg-dark py-4">
                <div class="container py-5">
                <div class="pt-4">
                    <img src="{{ asset('images/keen-text-white.png') }}" alt="Logo" class="keen-logo mt-5">
                </div>
                @foreach ($users as $user)
                    <div class="user-card mb-4 w-100 text-white ms-3 pb-4">
                    <div class="user-card mb-4 w-100 text-white ms-3 pb-4">
                        <!-- User's Proposal Message -->
                        <div class="proposal-message fs-5 fw-light w-75 pb-4">
                            <p>{!! $user->proposal_message !!}</p>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>

            <div class="page">
            <div class="container py-5">
                <h2 class="display-3 fw-bold py-3">Proposed Items</h2>
            <div class="page">
            <div class="container py-5">
                <h2 class="display-3 fw-bold py-3">Proposed Items</h2>

                <!-- Loop through selected products -->
                <div class="">
                <div class="">
                    <ul class="list-group mb-4">
                        @foreach ($products as $index => $product)
                        <li class="list-group-item d-block p-3 border-0 mb-3 rounded-4 bg-dark shadow-sm">
                        <li class="list-group-item d-block p-3 border-0 mb-3 rounded-4 bg-dark shadow-sm">
                            <div class="d-flex justify-content-between">
                                <span class="item-name fs-4 text-white fw-lighter">{{ $product->product_name }}</span>
                                <span class="item-price fw-bold fs-4">${{ number_format($product->price, 2) }}</span>
                                <span class="item-name fs-4 text-white fw-lighter">{{ $product->product_name }}</span>
                                <span class="item-price fw-bold fs-4">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <!-- Display the corresponding project scope -->
                            @if (isset($projectScopes[$index]))
                                <p class="project-scope mt-3 text-white">{{ $projectScopes[$index] }}</p>
                                <p class="project-scope mt-3 text-white">{{ $projectScopes[$index] }}</p>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    <p class="text-end fw-bold fs-4 mb-5">Proposal Total: ${{ number_format($proposal->proposal_price, 2) }}</p>
                </div>
            </div>
        </div>
                    <p class="text-end fw-bold fs-4 mb-5">Proposal Total: ${{ number_format($proposal->proposal_price, 2) }}</p>
                </div>
            </div>
        </div>
                

            

            <!-- Feedback form -->
            <div class="page">
            <div class="keen-background">
            <div class="container py-4">
                <form action="{{ route('link.feedback') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="proposalId" value="{{ $proposal->id }}">
            <div class="page">
            <div class="keen-background">
            <div class="container py-4">
                <form action="{{ route('link.feedback') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="proposalId" value="{{ $proposal->id }}">
            
                    <h2 class="display-3 fw-bold py-3 text-black">Ready to Get Started</h2>
            
                    <div class="mb-3 fs-5">
                        <label for="clientMessage" class="form-label text-white fw-medium">We warmly invite everyone to actively participate in reviewing this proposal by providing your valuable comments and recommendations. Please don't hesitate to share what you believe requires improvement or could be refined to make this proposal more effective.</label>
                        <textarea name="clientMessage" id="clientMessage" class="form-control rounded-4 border my-4" placeholder="Tell us if you have any comments about his proposal." rows="6"></textarea>
                    </div>
            
                        <!-- Radio button options -->
                        <div class="mb-4">
                        <fieldset class="w-25">
                            <legend class="mb-3 text-white fs-5">Please select one option:</legend>
                            <div class="mb-2">
                                <div class="p-2 d-flex align-items-center bg-dark rounded-pill">
                                        <fieldset class="w-25">
                            <legend class="mb-3 text-white fs-5">Please select one option:</legend>
                            <div class="mb-2">
                                <div class="p-2 d-flex align-items-center bg-dark rounded-pill">
                                    <div class="form-check fs-6 fs-6">
                                                        <input class="form-check-input" type="radio" name="updateStatus" id="option1" value="1">
                                                        <label class="form-check-label ms-3 text-info fw-medium ms-3 text-info fw-medium" for="option1">
                                                            These look good to me.
                                                        </label>
                                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="p-2 d-flex align-items-center bg-dark rounded-pill">
                                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="p-2 d-flex align-items-center bg-dark rounded-pill">
                                    <div class="form-check text-white fs-6 text-white fs-6">
                                                        <input class="form-check-input" type="radio" name="updateStatus" id="option2" value="2">
                                                        <label class="form-check-label ms-3 text-warning fw-medium ms-3 text-warning fw-medium" for="option2">
                                                            I am unsure, let's talk.
                                                        </label>
                                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    
                    <!-- Terms and conditions checkbox -->
                    <div class="mb-3 fs-6 text-white">
                        <input type="checkbox" id="termsChk" name="termsChk" class="form-check-input">
                        <label for="termsChk" class="ms-2">I agree to the <a href="{{ route('privacy-policy') }}" target="_blank" class="link-btn">Terms and Conditions</a></label>
                                    </div>
                            </div>
                        </fieldset>
                    </div>
                    
                    <!-- Terms and conditions checkbox -->
                    <div class="mb-3 fs-6 text-white">
                        <input type="checkbox" id="termsChk" name="termsChk" class="form-check-input">
                        <label for="termsChk" class="ms-2">I agree to the <a href="{{ route('privacy-policy') }}" target="_blank" class="link-btn">Terms and Conditions</a></label>
                    </div>                                        
            
                    <button type="submit" class="btn btn-info-custom rounded-pill w-25 fw-semibold text-uppercase" id="submitBtn" disabled>Submit</button>
                </form>
            </div>
        </div>
    </div>
        </div>
    </main>
    <footer class="text-center bg-dark">
        <div class="container py-4">
            <div class="d-flex justify-content-center">
                <a href="https://www.instagram.com/keencreative/" target="_blank" class="me-4">
                    <i class="bi bi-instagram fs-1"></i>
                </a>
                <a href="https://www.youtube.com/user/PureVisionInc/videos" target="_blank" class="me-4">
                    <i class="bi bi-youtube fs-1"></i>
                </a>
                <a href="https://www.linkedin.com/company/keen-creative/?originalSubdomain=ca" target="_blank" class="e">
                    <i class="bi bi-linkedin fs-1"></i>
                </a>
            </div>
            <p id="copyYear" class="text-white fs-4 fw-bold mt-2">&copy; </p>
        </div>
    </footer>
    

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- JS --}}
    <script>
        function updateSubmitButtonState() {
            const isTermsChecked = document.getElementById('termsChk').checked;
            const isAnyRadioSelected = document.querySelector('input[name="updateStatus"]:checked') !== null;
            document.getElementById('submitBtn').disabled = !(isTermsChecked && isAnyRadioSelected);
        }
    
        document.getElementById('termsChk').addEventListener('change', updateSubmitButtonState);
    
        const radioButtons = document.querySelectorAll('input[name="updateStatus"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', updateSubmitButtonState);
        });
    
        window.onload = updateSubmitButtonState;

        document.getElementById('copyYear').textContent += new Date().getFullYear();
    </script>
    
    {{-- JS --}}
    <script>
        function updateSubmitButtonState() {
            const isTermsChecked = document.getElementById('termsChk').checked;
            const isAnyRadioSelected = document.querySelector('input[name="updateStatus"]:checked') !== null;
            document.getElementById('submitBtn').disabled = !(isTermsChecked && isAnyRadioSelected);
        }
    
        document.getElementById('termsChk').addEventListener('change', updateSubmitButtonState);
    
        const radioButtons = document.querySelectorAll('input[name="updateStatus"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', updateSubmitButtonState);
        });
    
        window.onload = updateSubmitButtonState;

        document.getElementById('copyYear').textContent += new Date().getFullYear();
    </script>
    
</body>
</html>