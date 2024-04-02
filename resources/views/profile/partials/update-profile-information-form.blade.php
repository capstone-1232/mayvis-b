<section>
    <header class="mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fs-2 py-1 fw-bold">
                <i class="bi bi-person-circle me-3"></i>
                {{ __('My Profile') }}
            </h2>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="bg-white container rounded-xl px-5 pt-5 pb-3">
    <div class="row p-4 bg-gray mx-5 rounded-lg">
    <div class="col-md-6 col-sm-12 d-flex flex-column align-items-center">
    <div>
        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="rounded-circle profile-img">
    </div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label class="form-label" for="photo" :value="__('')">
            <input class="form-control" id="photo" name="photo" type="file" class=""/>
            <x-input-error :messages="$errors->get('photo')" />
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="container-md">
        <div class="mb-2">
            <x-input-label class="fw-bold" for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-100" value="{{ old('first_name', $user->first_name) }}" required autofocus autocomplete="first_name" />            
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div class="mb-2">
            <x-input-label class="fw-bold" for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-100" :value="old('last_name', $user->last_name)" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div class="mb-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-100" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-2">
            <x-input-label for="job_title" :value="__('Job Title')" />
            <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-100" :value="old('job_title', $user->job_title)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
        </div>
    </div>
                
    </div>
</div>
        <div class="mt-4">
            <x-input-label class="fw-bold text-black fs-5 mb-1" for="automated_message" :value="__('Automated Message')" />
            <x-textarea id="automated_message" name="automated_message" type="text" class="mt-1 block w-full" :value="old('automated_message', $user->automated_message)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('automated_message')" />
        </div>

        <div class="mt-4">
            <x-input-label class="fw-bold text-black fs-5 mb-1" for="proposal_message" :value="__('Proposal Message')" />
            <x-textarea id="proposal_message" name="proposal_message" type="text" class="mt-1 block w-full" :value="old('proposal_message', $user->proposal_message)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('proposal_message')" />
        </div>

        <div class="d-flex justify-content-end align-items-center my-3">
            <a href="{{ route('profile.edit') }}" class="fs-7 fw-bold me-2">Cancel</a>
            <x-primary-button class="btn primary-btn text-white px-4">{{ __('Save') }}</x-primary-button>
        
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }"
               x-show="show"
               x-transition
               x-init="setTimeout(() => show = false, 3000)"
               class="text-sm text-gray-600 dark:text-gray-400 mt-2"
            >{{ __('Saved.') }}</p>
        @endif
        
            </div>


    </form>
    </div>
</section>