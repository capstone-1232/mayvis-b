<x-layout>
    <div class="image-body d-flex justify-content-center align-items-center" style="min-height: 100vh;">
       <div class="container">
          <div class="row justify-content-center">
             <div class="col-lg-7 col-sm-10 p-5">
                <div class="bg-white rounded-5 pb-4 form-container">
                   <div class="text-center mb-2 logo-container">
                      <img src="{{ asset('images/keen-creatives-logo.webp') }}" alt="Logo" class="rounded-circle mx-auto d-block custom-img mb-2">
                      <h2 class="fw-bold fs-3">Register</h2>
                   </div>
                   <div class="px-5">
                      <form action="{{ route('register') }}" method="POST" id="registration-form">
                         @csrf
                         <div class="form-group mb-3">
                            <x-input-label class="fs-6" for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" class="form-control p-2 rounded-pill" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                         </div>
                         <div class="form-group mb-3">
                            <x-input-label class="fs-6" for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="form-control p-2 rounded-pill" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                         </div>
                         <div class="form-group mb-3">
                            <x-input-label class="fs-6" for="email" :value="__('Email')" />
                            <x-text-input id="email" class="form-control p-2 rounded-pill" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                         </div>
                         <div class="form-group mb-3">
                            <x-input-label class="fs-6" for="password" :value="__('Password')" />
                            <x-text-input id="password" class="form-control p-2 rounded-pill"
                               type="password"
                               name="password"
                               required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                         </div>
                         <div class="form-group mb-3">
                            <x-input-label class="fs-6" for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="form-control p-2 rounded-pill"
                               type="password"
                               name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                         </div>
                         <div class=" pt-3">
                            <x-primary-button class="btn w-100 custom-btn fw-bold rounded-pill text-white justify-center">
                               {{ __('Register') }}
                            </x-primary-button>
                         </div>
                      </form>
                   </div>
                </div>
                <a href="{{ route('login') }}" class="d-flex justify-content-center">
                   <div class="btn btn-dark btn-outline-light rounded-pill mt-4 w-75 mx-auto">
                      Back to Login Page
                   </div>
                </a>
             </div>
          </div>
       </div>
    </div>
 </x-layout>