<x-layout>
    <x-slot name="header">
       <h2 class="fw-semibold">
          {{ __('Profile') }}
       </h2>
    </x-slot>
    <div class="content">
       <div class="container my-5">
          <div class="max-w-7xl mx-auto">
             <div class="">
                <div>
                   @include('profile.partials.update-profile-information-form')
                </div>
             </div>
             <div class="row mt-4">
                <div class="col">
                   <div>
                      @if (empty($user->google_id))
                      @include('profile.partials.update-password-form')
                      @endif
                   </div>
                </div>
                <div class="col">
                   <div>
                      @if (empty($user->google_id))
                      @include('profile.partials.delete-user-form')
                      @endif
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </x-layout>