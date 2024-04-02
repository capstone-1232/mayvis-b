<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-6 py-2 fw-bold">
                        <i class="bi bi-person-fill me-3"></i>Add a Client
                    </h2>
                    <div class="bg-white p-4 rounded-4 mt-2">
                        <form action="{{ route('clients.storeClient') }}" method="POST">
                            @csrf
                            <!-- Form fields for Client Creation -->
                            <div class="form-group mb-3">
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input type="text" name="company_name" field="company_name" placeholder="Company Name" class="form-control" autocomplete="off" :value="old('company_name')"></x-text-input>
                                <x-input-error class="mt-2 productserr" :messages="$errors->get('company_name')" />
                            </div>
    
                            <div class="form-group mb-3">
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input type="text" name="first_name" placeholder="John" class="form-control" :value="old('first_name')"></x-text-input>
                                <x-input-error class="mt-2 productserr" :messages="$errors->get('first_name')" />
                            </div>
            
                            <div class="form-group mb-3">
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input type="text" name="last_name" placeholder="Doe" class="form-control" :value="old('last_name')"></x-text-input>
                                <x-input-error class="mt-2 productserr" :messages="$errors->get('last_name')" />
                            </div>
            
                            <div class="form-group mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input type="email" name="email" placeholder="johndoe@email.com" field="email" class="form-control" autocomplete="off" :value="old('email')"></x-text-input>
                                <x-input-error class="mt-2 productserr" :messages="$errors->get('email')" />
                            </div>
            
                            <div class="form-group mb-3">
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input type="tel" name="phone_number" placeholder="123-456-7891" field="phone_number" class="form-control" autocomplete="off" :value="old('phone_number')"></x-text-input>
                                <x-input-error class="mt-2 productserr" :messages="$errors->get('phone_number')" />
                            </div>
            
                            <!-- Add other necessary form fields -->
                            <div class="d-flex justify-content-end align-items-center mt-3">
                                <a href="{{ route('index-client') }}" class="fs-7 fw-bold me-2">Cancel</a>
                                <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Save Client</x-primary-button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
                
        </div>
    </div>
</x-layout>
