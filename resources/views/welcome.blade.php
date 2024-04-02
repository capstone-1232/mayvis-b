<x-layout>
    <div class="gradient-bg min-vh-100  d-flex flex-column">
        <div class="text-center pt-4">
            <img src="{{ asset('images/mayvis-logo-white.png') }}" alt="Logo" class="mb-4 w-25 mx-auto">
        </div>

        <div class="flex-grow-1 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h1 class="display-4 fw-bold color-changing-text">Build Proposals Faster.</h1>
                        <p class="fs-5 text-white mb-4">Login to get started.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-info btn-lg rounded-pill mt-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>
