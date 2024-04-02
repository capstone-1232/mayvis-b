<x-layout>
    <div class="content">
        <div class="container">
            <div class="">
                <div class="">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-10 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="fs-2 py-2 fw-bold mt-4">
                                    <i class="bi bi-send-fill"></i>
                                    Manage Access
                                </h2>
                            </div>
                            <p class="fs-5 ms-4 mt-2 text-secondary">By creating a custom URL for this proposal, you effectively lock it from being changed by the estimating team.
                                The proposal's status will be set to "Pending" and feedback can be solicited from the clients via the link.</p>
                        </div>

                        <div class=" bg-white rounded-xl p-4 my-5">
                            <input type="text" class="form-control" value="{{ $link }}" aria-label="Recipient's username" aria-describedby="button-addon2" readonly>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('dashboard') }}" class="btn primary-btn text-white rounded-pill px-4 fw-bold">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>


{{-- <a href="{{ $link }}">Access your information</a> --}}