<x-layout>
    <div class="image-body d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-sm-10">
                    <div class="bg-white rounded-5 p-4">
                        <div class="mb-4 text-sm">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <x-input-label class="fs-6" for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control p-2 rounded-pill" type="email" name="email" :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="d-flex justify-content-center">
                                <x-primary-button class="btn custom-btn fw-bold rounded-pill text-white">
                                    {{ __('Email Password Reset Link') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                    <a href="/" class="d-flex justify-content-center mt-4">
                        <div class="btn btn-dark btn-outline-light rounded-pill w-75 mx-auto">
                            Back to Login Page
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
