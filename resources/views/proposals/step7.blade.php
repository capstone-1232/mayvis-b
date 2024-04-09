<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sending Options') }}
        </h2>
    </x-slot>

    <!-- Refreshing the page during URL generation after the client has given feedback will throw an error. -->
    <!-- Additionally, refreshing the page during URL generation will no longer create a new record on the database. -->

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="content">
        <div class="container">
            <div class="">
                <div class="">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="fs-2 py-2 fw-bold mt-4">
                                    <i class="bi bi-send-fill"></i>
                                    Sending Options
                                </h2>
                            </div>
                            <p class="fs-5 ms-4 mt-2">Please choose between sending a printed PDF copy or generating a URL to share with your client. Alternatively, you may choose both options.</p>
                        </div>
                        
                        <div class="row my-5 d-flex">
                            <div class="col-md-6 d-flex">
                                <div class="p-4 shadow rounded-5 bg-white d-flex flex-column flex-grow-1">
                                    <div class="col-10 mx-auto flex-grow-1">
                                        <h3 class="mb-2 fw-semibold fs-4 text-center">Send a PDF Copy</h3>
                                        <p class="mb-3">Note: Printable proposals are less desirable than soliciting feedback via client approval links. Proposals will not be registered in the database until you generate a link.</p>
                                    </div>
                                    <a href="{{ route('session.info.pdf') }}" class="btn primary-btn text-white rounded-pill px-4 fw-bold mt-auto w-50 mx-auto">View PDF</a>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex mt-3 mt-md-0">
                                <div class="p-4 shadow rounded-5 bg-white d-flex flex-column flex-grow-1">
                                    <div class="col-10 mx-auto flex-grow-1">
                                        <h3 class="mb-2 fw-semibold fs-4 text-center">Send using a link</h3>
                                        <p class="mb-3">Note: Proposal Information will no longer be editable as soon as you create a link. Additionally, in the rare situation where the client provides feedback right away, refreshing the URL generation page will send you back to the dashboard. This is a security measure to prevent database alteration.</p>
                                    </div>
                                    <a href="{{ route('link.generate') }}" class="btn primary-btn text-white rounded-pill px-4 fw-bold mt-auto w-50 mx-auto">Generate Link</a>
                                </div>
                            </div>
                        </div>
                        
    
                        <a href="{{ route('proposals.step6') }}" class="fs-7 fw-semi-bold me-2 back-btn"><i class="bi bi-caret-left-fill me-2"></i>Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
