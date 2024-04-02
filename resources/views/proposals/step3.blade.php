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
                        <li class="bg-lblue py-3">Title</li>
                        <li class="text-white bg-blue py-3">Message</li>
                        <li class="bg-lblue py-3">Deliverables</li>
                        <li class="bg-lblue py-3">Finalize</li>
                      </ul>
                </div>
            </div>
    
            <div class="container">
                <div class="p-4 bg-white rounded-5 col-lg-8 col-sm-12 mx-auto">
                    <div class="px-4">
                    <div class="">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="fs-3 py-2 fw-bold mb-2">
                                Message
                            </h2>
                        </div>
                    </div>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                   <!-- This form will be routed to the storeStep3 function inside 'ProposalController.php' -->
                    <form action="{{ route('proposals.storeStep3') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <x-input-label for="sender"  class="fw-bold">Sender</x-input-label>
                            <x-text-input type="text" name="sender" field="sender" placeholder="Staff Sender" class="w-100 mt-1" autocomplete="off" :value="old('sender', Auth::user()->email)"></x-text-input>    
                        </div>
    
                        <div class="mb-3">
                            <x-input-label class="fw-bold" for="automated_message" :value="__('Automated Message')" />
                            <x-textarea id="automated_message" name="automated_message" type="text" class="mt-1 block w-100" :value="old('automated_message', Auth::user()->automated_message)" required autofocus autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('automated_message')" />    
                        </div>
                    
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('proposals.step2') }}" class="fs-7 fw-bold me-2 btn btn-secondary rounded-pill btn-width">Prev</a>
                            <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold">Next</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
        </div>
    </div>
</x-layout>
    