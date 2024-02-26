<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proposals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg mt-2">

                <h2 class="mb-5 ">Info about your Client</h2>

                <form action="{{ route('proposals.storeStep1') }}" method="post">
                    @csrf
                    <label for="first_name">First Name</label>
                    <x-text-input type="text" name="first_name" field="first_name" placeholder="Client First Name" class="w-full my-2" autocomplete="off" :value="@old('first_name')"></x-text-input>

                    <label for="last_name">Last Name</label>
                    <x-text-input type="text" name="last_name" field="last_name" placeholder="Client Last Name" class="w-full my-2" autocomplete="off" :value="@old('last_name')"></x-text-input>
                    
                    <label for="company_name">Company Name</label>
                    <x-text-input type="text" name="company_name" field="company_name" placeholder="Company Name" class="w-full my-2" autocomplete="off" :value="@old('company_name')"></x-text-input>

                    <label for="email">Email</label>
                    <x-text-input type="email" name="email" field="email" placeholder="Client Email" class="w-full my-2" autocomplete="off" :value="@old('email')"></x-text-input>

                    <label for="phone_number">Phone Number</label>
                    <x-text-input type="text" name="phone_number" field="phone_number" placeholder="Client Phone" class="w-full my-2" autocomplete="off" :value="@old('phone_number')"></x-text-input>
                        
                    <x-primary-button class="mt-6">Next</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
    