<x-layout>
    <div class="content">
        <div class="container my-3">
            <h1 class="display-6">Create New Client</h1>
            <form action="{{ route('clients.storeClient') }}" method="POST">
                @csrf
                <!-- Form fields for product creation -->
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <x-text-input type="text" name="first_name" class="form-control" :value="old('first_name')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('first_name')" />
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <x-text-input type="text" name="last_name" class="form-control" :value="old('last_name')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('last_name')" />
                </div>

                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <x-text-input type="text" name="company_name" field="company_name" placeholder="Company Name" class="form-control" autocomplete="off" :value="old('company_name')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('company_name')" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <x-text-input type="email" name="email" field="email" class="form-control" autocomplete="off" :value="old('email')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('email')" />
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <x-text-input type="tel" name="phone_number" field="phone_number" class="form-control" autocomplete="off" :value="old('phone_number')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('phone_number')" />
                </div>



                <!-- Add other necessary form fields -->
                <x-primary-button type="submit" class="btn btn-primary">Save Client</x-primary-button>
            </form>
        </div>
    </div>
</x-layout>
