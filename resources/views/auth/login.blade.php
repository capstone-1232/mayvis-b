<x-layout>
    {{-- success message
    @if(session()->has('success'))
    <div class="container container--narrow">
      <div class="alert alert-success text-center">
        {{session('success')}}
      </div>
    </div>
    @endif

    @if(session()->has('failure'))
    <div class="container container--narrow">
      <div class="alert alert-danger text-center">
        {{session('failure')}}
      </div>
    </div>
    @endif --}}
    <section class="container-fluid bg-white">
      <x-auth-session-status class="mb-4" :status="session('status')" />
       <div class="row justify-content-center ">
          <div class="col-md-12 login-form">
             <div class="row vh-100">
                {{-- image gallery --}}
                <div class="img-gallery col-lg-6 col-md-6 p-0">
                   <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-indicators">
                         <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                         <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                         <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                      </div>
                      <div class="carousel-inner">
                         <div class="carousel-item active">
                            <img src="{{ asset('images/gallery/work-prototype-ui.webp') }}" class="d-block w-100" alt="Desktop Computer with Protoypes of website on display">
                         </div>
                         <div class="carousel-item">
                            <img src="{{ asset('images/gallery/work-desk.webp') }}" class="d-block w-100" alt="a side view of a laptop on a work desk">
                         </div>
                         <div class="carousel-item">
                            <img src="{{ asset('images/gallery/work-collab.webp') }}" class="d-block w-100" alt="a top view shot of a collaborative meeting discussion">
                         </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                      </button>
                   </div>
                </div>
                {{-- login form --}}
                <div class="col-lg-5 col-md-6 px-md-5 my-auto mx-auto login-div">
                   <div class="text-center mb-2">
                      <img src="{{ asset('images/keen-creatives-logo.webp') }}" alt="Logo of Keen Creatives" class="rounded-circle mx-auto d-block custom-img mb-2">
                      <h2 class="fw-bold fs-4">Login</h3>
                   </div>
                   <div class="px-5">
                      <form action="{{ route('login') }}" method="POST" id="login-form">
                         {{-- CSRF --}}
                         @csrf
                         {{-- Email --}}
                         <div class="form-group mb-3">
                            <x-input-label class="fs-6" for="email" :value="__('Email')" />
                            <x-text-input id="email" class="form-control p-2 rounded-pill" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                         </div>
                         {{-- Password --}}
                         <div class="form-group mb-2">
                           <x-input-label class="fs-6" for="password" :value="__('Password')" />
                           <x-text-input id="password" class="form-control p-2 rounded-pill"
                           type="password"
                           name="password"
                           required autocomplete="current-password" />
                           <x-input-error :messages="$errors->get('password')" class="mt-2" />
                         </div>
                         {{-- Remember Me and Forgot your password --}}
                         <div class="form-group mb-2">
                            <div class="flex items-center justify-end mb-2">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                          </div>

                         {{-- Sign In Button --}}
                         <div class="col-md-auto pt-3">
                           <x-primary-button class="btn login-btn custom-btn fw-bold rounded-pill text-white justify-center">
                              {{ __('Log in') }}
                          </x-primary-button>
                         </div>
                      </form>
                      <div class="text-center text-uppercase my-2 pt-4">
                         <hr class="line">
                         <span class="bg-white position-relative span-line">
                         Or
                         </span>
                      </div>
                      {{-- Google Sign In // to implement--}}
                      <a href="{{ route('login.google') }}" class="d-flex align-items-center">
                         <div class="d-flex justify-content-center btn btn-outline-dark login-btn rounded-pill">
                           <div class="google-icon my-auto me-2">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
                           </div>
                            <p class="mb-0 fw-bold">Login with Google</p>
                         </div>
                      </a>
                      <p class="text-center fw-semibold mt-2">
                         Need an account? <a data-toggle="tab" href="{{ route('register') }}" class="sign-up-btn">Sign Up</a>
                      </p>
                   </div>
                </div>
                @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
             </div>
          </div>
       </div>
    </section>
 </x-layout>