<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proposal Summary') }}
        </h2>
    </x-slot>

    <div class="content">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-md-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="fs-2 py-2 fw-bold my-4">
                            <i class="bi bi-file-earmark-plus-fill"></i>
                            Proposal Summary
                        </h2>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 p-4 bg-white rounded-5 mt-4 shadow-sm">
                    <div class="my-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="fw-bold">Proposal Title</h3>
                            <p class="text-secondary">{{ $step2Data['proposal_title'] ?? 'N/A' }}</p>
                        </div>
                    </div>
        
                    <div class="my-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="fw-bold">Company Name</h3>
                            <p class="text-secondary">{{ $step1Data['company_name'] ?? 'N/A' }}</p>
                        </div>
                    </div>
        
                    <div class="my-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="fw-bold">Client Name</h3>
                            <p class="text-secondary">{{ $step1Data['first_name'] ?? 'N/A' }} {{ $step1Data['last_name'] ?? '' }}</p>
                        </div>
                    </div>
        
                    <div class="my-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="fw-bold">Proposed On</h3>
                            <p class="text-secondary">{{ $step2Data['start_date'] ?? 'N/A' }}</p>
                        </div>
                    </div>
        
                    <div class="my-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="fw-bold">Proposed Total</h3>
                            <p class="text-secondary">${{ number_format($step4Data['proposalTotal'] ?? 0, 2, '.', ',') }}</p>
                        </div>
                    </div>
        
                    <div class="my-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="fw-bold">Created By</h3>
                            <p class="text-secondary">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-10 mx-auto py-2">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('proposals.step4') }}" class="fs-7 fw-bold btn btn-secondary rounded-pill w-100">Edit</a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('proposals.saveDraft') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="fs-7 fw-bold btn btn-success rounded-pill w-100">Save to Drafts</button>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <a href="{{ route('proposals.step7') }}" class="btn primary-btn text-white rounded-pill fw-bold w-100">Send to Client</a>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</x-layout>