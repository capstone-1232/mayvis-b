<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proposal Information</title>
    <!-- Bootstrap CSS -->
    <style>
        @import url('https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css');
        /* Additional CSS styles */
        /* Define any additional CSS styles inline */
    </style>
</head>
<body>
    <main>
        <div class="container">
            <!-- Display user details -->
            <div class="mt-2">
                <h2 class="fw-bold heading-4">Hello {{ $client->first_name }},</h2>
                @foreach ($users as $user)
                <div class="user-card">
                    <!-- User's Automated Message -->
                    <div class="automated-message">
                        <p>{!! $user->automated_message !!}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Display user proposal message-->
            @foreach ($users as $user)
                <div class="user-card mb-4 w-full">
                    <!-- User's Proposal Message -->
                    <div class="proposal-message">
                        <p>{!! $user->proposal_message !!}</p>
                    </div>
                </div>
            @endforeach

            @foreach ($users as $user)
                <div class="user-card mb-2">
                    <div class="user-info d-flex" style="justify-content: flex-end;">
                        <!-- User's Name and Job Title -->
                        <div>
                            <p class="user-name fw-bold mb-0">{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="user-job-title text-secondary" style="font-size: .875em;">{{ $user->job_title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

            <h2 class="heading-4 fw-bold">Proposed Items</h2>
            <!-- Loop through selected products -->
            <div class="proposal-section" style="font-family: Arial, sans-serif;">
                <ul class="list-group mb-4">
                    @foreach ($products as $index => $product)
                    <li class="list-group-item d-block py-3 border-0 border-bottom border-gray-200">
                        <div class="d-flex justify-content-between">
                            <span class="item-name fw-bold">{{ $product->product_name }}</span>
                            <span class="item-price fw-bold">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <!-- Display the corresponding project scope -->
                        @if (isset($projectScopes[$index]))
                            <p class="project-scope mt-1">{{ $projectScopes[$index] }}</p>
                        @endif
                    </li>
                    @endforeach
                </ul>
                <p class="text-end fw-normal mb-5">Proposal Total: ${{ number_format($step4Data['proposalTotal'], 2) }}</p>
            </div>
            
        </div>
    </main>
    <footer class="container">
        <p class="text-center">Connect with us:</p>
        <!-- Add social media links here -->
    </footer>
</body>
</html>
