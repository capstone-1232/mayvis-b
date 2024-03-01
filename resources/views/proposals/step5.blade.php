<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Proposals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 mt-2 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">

                  <!-- Finalize should be highlighted here -->
                  <div class="container my-4">
                    <ul class="step-progress-bar">
                      <li>Client</li>
                      <li>Title</li>
                      <li>Message</li>
                      <li>Deliverables</li>
                      <li>Finalize</li>
                    </ul>
                </div>

                <div class="my-4">
                    <div>
                        <h1 class="text-3xl">Customize and Review</h1>
                    </div>
                </div>
                
                {{-- Check if step4Data exists and is not empty --}}
                @if(!empty($step4Data['selectedProducts']))
                    <h3 class="mb-5">Deliverables: </h3>
                    <ul class="mb-5 list-disc list-inside">
                        {{-- Loop through the selected product names --}}
                        @foreach($step4Data['selectedProducts'] as $productName)
                            <li>{{ $productName }}</li>
                        @endforeach
                    </ul>
                @endif

                {{-- Display other information similarly --}}
                <p>Total Price: ${{ $step4Data['totalPrice'] }}.00</p>
                <p>Recurring Total: ${{ $step4Data['recurringTotal'] }}.00</p>
                <p>Proposal Total: ${{ $step4Data['proposalTotal'] }}.00</p>

                <a href="{{ route('proposals.step4') }}">Previous</a>
                <x-primary-button type="submit" class="btn btn-primary mt-6">Next</x-primary-button>
            </div>
        </div>
    </div>
</x-app-layout>
