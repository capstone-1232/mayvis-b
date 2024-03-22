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
                        <li class="text-white bg-blue py-3">Client</li>
                        <li class="bg-lblue py-3">Title</li>
                        <li class="bg-lblue py-3">Message</li>
                        <li class="bg-lblue py-3">Deliverables</li>
                        <li class="bg-lblue py-3">Finalize</li>
                      </ul>
                </div>
            </div>
            <!-- Client should be highlighted here -->
            
            <div class="container">
                <div class="p-4 bg-white rounded-xl col-lg-8 col-sm-12 mx-auto">
                    <div class="px-4">
                    <div class="">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="fs-3 py-2 fw-bold mb-2">
                                Client Information
                            </h2>
                        </div>
                    </div>
                                      
                   <!-- This form will be routed to the storeStep1 function inside 'ProposalController.php' -->
                    <form action="{{ route('proposals.storeStep1') }}" method="post">
                        @csrf
                        <div class="mb-3">
                        <label for="first_name" class="fw-bold">First Name</label>
                        <x-text-input type="text" name="first_name" field="first_name" placeholder="Client First Name" class="w-100" autocomplete="off" :value="old('first_name', session('step1_data.first_name', ''))"></x-text-input>                       
                        </div>
    
                        <div class="mb-3">
                        <label for="last_name" class="fw-bold">Last Name</label>
                        <x-text-input type="text" name="last_name" field="last_name" placeholder="Client Last Name" class="w-100" autocomplete="off" :value="old('last_name', session('step1_data.last_name', ''))"></x-text-input>
                        </div>

                        <div class="mb-3">
                        <label for="company_name" class="fw-bold">Company Name</label>
                        <x-text-input type="text" name="company_name" field="company_name" placeholder="Company Name" class="w-100" autocomplete="off" :value="old('company_name', session('step1_data.company_name', ''))"></x-text-input>
                        </div>

                        <div class="mb-3">
                        <label for="email" class="fw-bold">Email</label>
                        <x-text-input type="email" name="email" field="email" placeholder="Client Email" class="w-100" autocomplete="off" :value="old('email', session('step1_data.email', ''))"></x-text-input>
                        </div>

                        <div class="mb-3">
                        <label for="phone_number" class="fw-bold">Phone Number</label>
                        <x-text-input type="tel" name="phone_number" field="phone_number" placeholder="Client Phone" class="w-100" autocomplete="off" :value="old('phone_number', session('step1_data.phone_number', ''))"></x-text-input>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('dashboard') }}" class="fs-7 fw-bold me-2">Cancel</a>
                            <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 fw-bold btn-width">Next</x-primary-button>
                        </div>

                    </form>
                </div>
                                        
            </div>
            </div>
        </div>
    </div>
</x-layout>
    