<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
            <h2 class="display-6 py-2 fw-bold">
                <i class="bi bi-pencil-square me-3"></i>Edit Client
            </h2>
            <div class="bg-white p-4 rounded-4 mt-2">
            <form action="{{ route('clients.updateClient', $client->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- This is important for the update method --}}
        
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control mb-3" id="first_name" name="first_name" value="{{ $client->first_name }}">
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('first_name')" />

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control mb-3" id="last_name" name="last_name" value="{{ $client->last_name }}">
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('last_name')" />

                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="company_name" field="company_name" class="form-control mb-3" autocomplete="off" value="{{ $client->company_name }}"></input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('company_name')" />

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" field="email" class="form-control mb-3" autocomplete="off" value="{{ $client->email }}"></input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('email')" />

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" name="phone_number" field="phone_number" placeholder="Client Phone" class="form-control mb-3" autocomplete="off" value="{{ $client->phone_number}}"></input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('phone_number')" />

                
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <a href="{{ route('index-client') }}" class="fs-7 fw-bold me-2">Cancel</a>
                        <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Update Client</x-primary-button>
                    </div>

            </form>
            </div>

                </div>
            </div>
        </div>
    </div>
</x-layout>