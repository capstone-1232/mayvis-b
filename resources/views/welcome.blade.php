<x-layout>
    <div class="container welcome-section">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="mb-4">
                    <img src="{{ asset('images/keen-creatives-logo.webp') }}" alt="Logo" class="mb-4 w-25 centered-image">
       
                </div>
                <h1 class="display-4 fw-bold welcome-text">Build Proposals Faster.</h1>
                <p class="lead mb-4">Login to get started.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
        </div>
    </div>
</x-layout>
