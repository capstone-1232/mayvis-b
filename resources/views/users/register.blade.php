<x-layout>
  <div class="image-body">
     <div class="container">
        <div class="col-lg-6 col-md-10 p-md-5 my-2 mx-auto">
           <div class="bg-opacity rounded-5 pb-4">
              <div class="text-center mb-2 logo-container">
                 <img src="{{ asset('images/keen-creatives-logo.webp') }}" alt="Logo" class="rounded-circle mx-auto d-block custom-img mb-2">
                 <h2 class="fw-bold fs-3">
                 Register</h3>
              </div>
              <div class="px-5">
                 <form action="/register" method="POST" id="registration-form">
                    @csrf
                    <div class="form-group">
                       <label for="first_name-register" class="fs-6">First Name</label>
                       <input name="first_name" id="first_name-register" class="form-control p-2 rounded-pill" type="text" placeholder="John" autocomplete="off" />
                       @error('first_name')
                       <p class="small alert alert-danger shadow-sm rounded-pill my-1 p-1"> {{$message}}</p>
                       @enderror
                    </div>
                    <div class="form-group">
                       <label for="last_name-register" class="fs-6">Last Name</label>
                       <input name="last_name" id="last_name-register" class="form-control p-2 rounded-pill" type="text" placeholder="Doe" autocomplete="off" />
                       @error('last_name')
                       <p class="small alert alert-danger shadow-sm rounded-pill my-1 p-1"> {{$message}}</p>
                       @enderror
                    </div>
                    <div class="form-group">
                       <label for="email-register" class="fs-6">Email</label>
                       <input value="{{ old('email') }}" name="email" id="email-register" class="form-control p-2 rounded-pill" type="email" placeholder="you@example.com" autocomplete="off" />
                       @error('email')
                       <p class="small alert alert-danger shadow-sm rounded-pill my-1 p-1"> {{$message}}</p>
                       @enderror
                    </div>
                    <div class="form-group">
                       <label for="password-register" class="fs-6">Password</label>
                       <input name="password" id="password-register " class="form-control p-2 rounded-pill" type="password" placeholder="Create a password" />
                       @error('password')
                       <p class="small alert alert-danger shadow-sm rounded-pill my-1 p-1"> {{$message}}</p>
                       @enderror
                    </div>
                    <div class="form-group">
                       <label for="password-register-confirm" class="fs-6">Confirm Password</label>
                       <input name="password_confirmation" id="password-register-confirm" class="form-control p-2 rounded-pill" type="password" placeholder="Confirm password" />
                       @error('password_confirmation')
                       <p class="small alert alert-danger shadow-sm rounded-pill my-1 p-1"> {{$message}}</p>
                       @enderror
                    </div>
                    <div class="col-md-auto pt-3">
                       <button type="submit" class="btn login-btn custom-btn fw-bold rounded-pill text-white">Register</button>
                    </div>
                 </form>
              </div>
           </div>
           <a href="/" class="d-flex align-items-center">
              <div class="justify-content-center btn btn-dark login-btn rounded-pill mt-4 w-75 mx-auto">
                 Back to Login Page
              </div>
           </a>
        </div>
     </div>
  </div>
</x-layout>