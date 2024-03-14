<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proposal Summary') }}
        </h2>
    </x-slot>

    <div class="content">
        <div class="centered-container">
            <div class="centered-card">
                <div class="card-display">
                    <div class="card-content">
                        <div class="content-flex">
                            <h3 class="card-title">Proposal Title:</h3>
                            <p class="text-gray-600">{{ $step2Data['proposal_title'] ?? 'N/A' }}</p>
                        </div>
                    </div>
        
                    <div class="card-content">
                        <div class="content-flex">
                            <h3 class="card-title">Company Name:</h3>
                            <p class="text-gray-600">{{ $step1Data['company_name'] ?? 'N/A' }}</p>
                        </div>
                    </div>
        
                    <div class="card-content">
                        <div class="content-flex">
                            <h3 class="card-title">Client Name:</h3>
                            <p class="text-gray-600">{{ $step1Data['first_name'] ?? 'N/A' }} {{ $step1Data['last_name'] ?? '' }}</p>
                        </div>
                    </div>
        
                    <div class="card-content">
                        <div class="content-flex">
                            <h3 class="card-title">Proposed On:</h3>
                            <p class="text-gray-600">{{ $step2Data['start_date'] ?? 'N/A' }}</p>
                        </div>
                    </div>
        
                    <div class="card-content">
                        <div class="content-flex">
                            <h3 class="card-title">Proposed Total:</h3>
                            <p class="text-gray-600">${{ number_format($step4Data['proposalTotal'] ?? 0, 2, '.', ',') }}</p>
                        </div>
                    </div>
        
                    <div class="card-content">
                        <div class="content-flex">
                            <h3 class="card-title">Created By:</h3>
                            <p class="text-gray-600">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
    
                <div class="flex-center">
                    <a href="{{ route('proposals.step5') }}" class="btn">Edit</a>
<<<<<<< HEAD
                    <form action="{{ route('proposals.saveDraft') }}" method="POST">
                        @csrf
                        <!-- Form inputs go here -->
                        <button type="submit">Save to Drafts</button>
                    </form>
=======
                    {{-- <button class="btn">Save</button> --}}
>>>>>>> e460a808fb7e8761010459153acad2bee72678d6
                    <a href="{{ route('proposals.step7') }}" class="btn">Send to Client</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>