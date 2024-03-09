<x-layout>
    <div class="content">
        <div class="container py-5">
            <div class="card mx-auto" style="max-width: 40rem;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <span class="flex-shrink-0 icon-placeholder me-3">🔒</span>
                        <h2 class="h4 card-title mb-0">Manage Access</h2>
                    </div>
                    <p class="text-muted">
                        By creating a custom URL for this proposal, you effectively lock it from being changed by the estimating team.
                        The proposal's status will be set to "Sent," and feedback can be solicited from the clients via the link.
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="{{ $link }}" aria-label="Recipient's username" aria-describedby="button-addon2" readonly>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary me-2">Deactivate Link</button>
                        <button class="btn btn-outline-primary me-2">Share Link</button>
                        <a href="{{ route('proposals.step7') }}" class="btn btn-primary">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>


{{-- <a href="{{ $link }}">Access your information</a> --}}