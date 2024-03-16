<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proposals') }}
        </h2>
    </x-slot>

   <div class="content">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg mt-2">

                <!-- Title should be highlighted here -->
                <div class="container my-4">
                    <ul class="step-progress-bar">
                      <li>Client</li>
                      <li>Title</li>
                      <li>Message</li>
                      <li>Deliverables</li>
                      <li>Finalize</li>
                    </ul>
                </div>
            
                <div class="container my-4">
                    <div class="row">
                      <div class="col">
                        <h1 class="display-3">What is this project about?</h1>
                      </div>
                    </div>
                </div>
                
                <!-- This form will be routed to the storeStep2 function inside 'ProposalController.php' -->
                <form action="{{ route('proposals.storeStep2') }}" method="post">
                    @csrf
                    <label for="proposal_title">Proposal Title</label>
                    <x-text-input type="text" name="proposal_title" field="proposal_title" placeholder="Proposal Title" class="w-full" autocomplete="off" :value="old('proposal_title', session('step2_data.proposal_title', ''))"></x-text-input>

                    <label for="start_date" class="mt-5">Date Created</label>
                    <x-date-input 
                        name="start_date"
                        placeholder="YYYY-MM-DD"
                        :value="old('start_date', session('step2_data.start_date', ''))">
                    </x-date-input>
                    
                    <a href="{{ route('proposals.step1') }}">Cancel</a>
                    <x-primary-button class="mt-6">Next</x-primary-button>
                </form>
            </div>
        </div>
    </div>
   </div>
</x-layout>
    