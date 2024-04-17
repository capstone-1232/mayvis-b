<section>
    <header class="mb-2">
       <div class="d-flex justify-content-between align-items-center">
          <h2 class="fs-2 py-1 fw-bold">
             <i class="bi bi-shield-lock-fill me-3"></i>
             {{ __('Update Password') }}
          </h2>
       </div>
    </header>
    <div class="bg-white container rounded-5 shadow px-5 py-2">
       <div class="d-flex justify-content-center">
          <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 w-75">
             @csrf
             @method('put')
             <div class="mb-2">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-100 border-2" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
             </div>
             <div class="mb-2">
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-100 border-2" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
             </div>
             <div class="mb-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-100 border-2" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
             </div>
             <div class="d-flex justify-content-end align-items-center my-3">
                <a href="{{ route('profile.edit') }}" class="fs-7 fw-bold me-2">Cancel</a>
                <x-primary-button class="btn primary-btn text-white px-4">{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'password-updated')
                <p
                   x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="fs-5"
                   >{{ __('Saved.') }}</p>
                @endif
             </div>
          </form>
       </div>
    </div>
 </section>