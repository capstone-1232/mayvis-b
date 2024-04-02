<x-layout>
    <div class="content">
     <div class="my-4">
         <div class="container my-4">
             <div class="d-flex justify-content-between align-items-center">
                 <h2 class="fs-2 py-2 fw-bold mb-2">
                     <i class="bi bi-file-earmark-plus-fill"></i>
                     Proposal
                 </h2>
             </div>
             <div>
                 <ul class="step-progress-bar">
                     <li class="bg-lblue py-3">Client</li>
                     <li class="text-white bg-blue py-3">Title</li>
                     <li class="bg-lblue py-3">Message</li>
                     <li class="bg-lblue py-3">Deliverables</li>
                     <li class="bg-lblue py-3">Finalize</li>
                   </ul>
             </div>
         </div>
 
                 <!-- Title should be highlighted here -->
             
                 <div class="container">
                     <div class="p-4 bg-white rounded-5 col-lg-8 col-sm-12 mx-auto">
                         <div class="px-4">
                         <div class="">
                             <div class="d-flex justify-content-between align-items-center">
                                 <h2 class="fs-3 py-2 fw-bold mb-2">
                                     Project Information
                                 </h2>
                             </div>
                         </div>
                 
                 <!-- This form will be routed to the storeStep2 function inside 'ProposalController.php' -->
                 <form action="{{ route('proposals.storeStep2') }}" method="post">
                     @csrf
                     <div class="mb-3">
                     <x-input-label for="proposal_title" class="fw-bold">Proposal Title</x-input-label>
                     <x-text-input type="text" name="proposal_title" field="proposal_title" placeholder="Proposal Title" class="w-100" autocomplete="off" :value="old('proposal_title', session('step2_data.proposal_title', ''))"></x-text-input>
                     </div>
 
                     <div class="mb-3">
                     <x-input-label for="start_date" class="fw-bold">Date Created</x-input-label>
                     <x-date-input 
                         name="start_date"
                         placeholder="YYYY-MM-DD"
                         :value="old('start_date', session('step2_data.start_date', ''))">
                     </x-date-input>
                     </div>
 
                     <div class="d-flex justify-content-end align-items-center mt-3">
                         <a href="{{ route('proposals.step1') }}" class="fs-7 fw-bold me-2 btn btn-secondary rounded-pill btn-width">Prev</a>
                         <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold">Next</x-primary-button>
                     </div>
                 </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
    </div>
 </x-layout>
     