<x-layout>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const firstNameInput = document.querySelector('input[name="first_name"]');
        let debounceTimer;
        let spinner = document.createElement('div');
        spinner.classList.add('spinner-border', 'text-primary', 'mt-3');
        spinner.setAttribute('role', 'status');
        spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';

        firstNameInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            
            // Show the spinner
            let existingSpinner = document.querySelector('.spinner-border');
            if (!existingSpinner) {
                firstNameInput.parentNode.insertBefore(spinner, firstNameInput.nextSibling);
            }
            
            debounceTimer = setTimeout(() => {
                const firstName = this.value;
                fetch(`/ajax/client-info?first_name=${firstName}`)
                .then(response => response.json())
                .then(data => {
                    // Remove the spinner
                    spinner.remove();
                    
                    if(data.clients && data.clients.length >= 2) {
                        let selectDropdown = document.createElement('select');
                        selectDropdown.setAttribute('name', 'clients_dropdown');
                        selectDropdown.classList.add('form-select', 'mt-3', 'rounded-pill');
                        selectDropdown.innerHTML = `<option value="">Select a client</option>`;
                        data.clients.forEach(client => {
                            selectDropdown.innerHTML += `<option value="${client.id}">${client.first_name} ${client.last_name} - ${client.company_name} - ${client.phone_number} - ${client.email}</option>`;
                        });
                        let existingDropdown = document.querySelector('select[name="clients_dropdown"]');
                        if(existingDropdown) {
                            firstNameInput.parentNode.replaceChild(selectDropdown, existingDropdown);
                        } else {
                            firstNameInput.parentNode.insertBefore(selectDropdown, firstNameInput.nextSibling);
                        }
                        selectDropdown.addEventListener('change', function() {
                            fillClientInfo.call(this);
                            this.remove(); // Remove the dropdown after selection
                        });
                    } else if (data.clients.length === 1) {
                        fillClientInfoDirectly(data.clients[0]);
                    }
                }).catch(error => {
                    console.log(error);
                    spinner.remove(); 
                });
            }, 300);
        });
    });

    function fillClientInfo() {
        const selectedClientId = this.value;
        const clientDetails = this.options[this.selectedIndex].text.split(' - ');
        document.querySelector('input[name="first_name"]').value = clientDetails[0].split(' ')[0];
        document.querySelector('input[name="last_name"]').value = clientDetails[0].split(' ')[1];
        document.querySelector('input[name="company_name"]').value = clientDetails[1];
        document.querySelector('input[name="email"]').value = clientDetails[3];
        document.querySelector('input[name="phone_number"]').value = clientDetails[2];
        this.remove();
    }

    function fillClientInfoDirectly(client) {
        document.querySelector('input[name="first_name"]').value = client.first_name || '';
        document.querySelector('input[name="last_name"]').value = client.last_name || '';
        document.querySelector('input[name="company_name"]').value = client.company_name || '';
        document.querySelector('input[name="email"]').value = client.email || '';
        document.querySelector('input[name="phone_number"]').value = client.phone_number || '';
        let existingDropdown = document.querySelector('select[name="clients_dropdown"]');
        if(existingDropdown) {
            existingDropdown.remove();
        }
    }
    </script>
        
        


    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const firstNameInput = document.querySelector('input[name="first_name"]');
        let debounceTimer;
        let spinner = document.createElement('div');
        spinner.classList.add('spinner-border', 'text-primary', 'mt-3');
        spinner.setAttribute('role', 'status');
        spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';

        firstNameInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            
            // Show the spinner
            let existingSpinner = document.querySelector('.spinner-border');
            if (!existingSpinner) {
                firstNameInput.parentNode.insertBefore(spinner, firstNameInput.nextSibling);
            }
            
            debounceTimer = setTimeout(() => {
                const firstName = this.value;
                fetch(`/ajax/client-info?first_name=${firstName}`)
                .then(response => response.json())
                .then(data => {
                    // Remove the spinner
                    spinner.remove();
                    
                    if(data.clients && data.clients.length >= 2) {
                        let selectDropdown = document.createElement('select');
                        selectDropdown.setAttribute('name', 'clients_dropdown');
                        selectDropdown.classList.add('form-select', 'mt-3', 'rounded-pill');
                        selectDropdown.innerHTML = `<option value="">Select a client</option>`;
                        data.clients.forEach(client => {
                            selectDropdown.innerHTML += `<option value="${client.id}">${client.first_name} ${client.last_name} - ${client.company_name} - ${client.phone_number} - ${client.email}</option>`;
                        });
                        let existingDropdown = document.querySelector('select[name="clients_dropdown"]');
                        if(existingDropdown) {
                            firstNameInput.parentNode.replaceChild(selectDropdown, existingDropdown);
                        } else {
                            firstNameInput.parentNode.insertBefore(selectDropdown, firstNameInput.nextSibling);
                        }
                        selectDropdown.addEventListener('change', function() {
                            fillClientInfo.call(this);
                            this.remove(); // Remove the dropdown after selection
                        });
                    } else if (data.clients.length === 1) {
                        fillClientInfoDirectly(data.clients[0]);
                    }
                }).catch(error => {
                    console.log(error);
                    spinner.remove(); 
                });
            }, 300);
        });
    });

    function fillClientInfo() {
        const selectedClientId = this.value;
        const clientDetails = this.options[this.selectedIndex].text.split(' - ');
        document.querySelector('input[name="first_name"]').value = clientDetails[0].split(' ')[0];
        document.querySelector('input[name="last_name"]').value = clientDetails[0].split(' ')[1];
        document.querySelector('input[name="company_name"]').value = clientDetails[1];
        document.querySelector('input[name="email"]').value = clientDetails[3];
        document.querySelector('input[name="phone_number"]').value = clientDetails[2];
        this.remove();
    }

    function fillClientInfoDirectly(client) {
        document.querySelector('input[name="first_name"]').value = client.first_name || '';
        document.querySelector('input[name="last_name"]').value = client.last_name || '';
        document.querySelector('input[name="company_name"]').value = client.company_name || '';
        document.querySelector('input[name="email"]').value = client.email || '';
        document.querySelector('input[name="phone_number"]').value = client.phone_number || '';
        let existingDropdown = document.querySelector('select[name="clients_dropdown"]');
        if(existingDropdown) {
            existingDropdown.remove();
        }
    }
    </script>
        
        
    <div class="content">
        <div class="my-4">
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fs-2 py-2 fw-bold mb-2">
                        <i class="bi bi-file-earmark-plus-fill"></i>
                        Proposal
                    </h2>
                </div>
                <div>
                    <ul class="step-progress-bar">
                        <li class="text-white bg-blue py-3">Client</li>
                        <li class="bg-lblue py-3">Title</li>
                        <li class="bg-lblue py-3">Message</li>
                        <li class="bg-lblue py-3">Deliverables</li>
                        <li class="bg-lblue py-3">Finalize</li>
                      </ul>
                </div>
            </div>
            <!-- Client should be highlighted here -->
            
            <div class="container">
                <div class="p-4 bg-white rounded-5 shadow col-lg-8 col-sm-12 mx-auto">
                <div class="p-4 bg-white rounded-5 shadow col-lg-8 col-sm-12 mx-auto">
                    <div class="px-4">
                    <div class="">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="fs-3 py-2 fw-semibold mb-2">
                            <h2 class="fs-3 py-2 fw-semibold mb-2">
                                Client Information
                            </h2>
                        </div>
                    </div>
                                      
                   <!-- This form will be routed to the storeStep1 function inside 'ProposalController.php' -->
                    <form action="{{ route('proposals.storeStep1') }}" method="post">
                        @csrf
                        <div class="mb-3">
                        <x-input-label for="first_name" class="fw-bold">First Name</x-input-label>
                        <x-text-input type="text" name="first_name" field="first_name" placeholder="Client First Name" class="w-100" autocomplete="off" :value="old('first_name', session('step1_data.first_name', ''))"></x-text-input>                   
                        </div>
    
                        <div class="mb-3">
                        <x-input-label for="last_name" class="fw-bold">Last Name</x-input-label>
                        <x-text-input type="text" name="last_name" field="last_name" placeholder="Client Last Name" class="w-100" autocomplete="off" :value="old('last_name', session('step1_data.last_name', ''))"></x-text-input>
                        </div>

                        <div class="mb-3">
                        <x-input-label for="company_name" class="fw-bold">Company Name</x-input-label>
                        <x-input-label for="company_name" class="fw-bold">Company Name</x-input-label>
                        <x-text-input type="text" name="company_name" field="company_name" placeholder="Company Name" class="w-100" autocomplete="off" :value="old('company_name', session('step1_data.company_name', ''))"></x-text-input>
                        </div>

                        <div class="mb-3">
                        <x-input-label for="email" class="fw-bold">Email</x-input-label>
                        <x-input-label for="email" class="fw-bold">Email</x-input-label>
                        <x-text-input type="email" name="email" field="email" placeholder="Client Email" class="w-100" autocomplete="off" :value="old('email', session('step1_data.email', ''))"></x-text-input>
                        </div>

                        <div class="mb-3">
                        <x-input-label for="phone_number" class="fw-bold">Phone Number</x-input-label>
                        <x-text-input type="tel" name="phone_number" field="phone_number" placeholder="+1 780-999-9999" class="w-100" autocomplete="off" :value="old('phone_number', session('step1_data.phone_number', ''))" ></x-text-input>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('dashboard') }}" class="fs-7 fw-bold me-2">Cancel</a>
                            <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 fw-bold btn-width">Next</x-primary-button>
                        </div>

                    </form>
                </div>
                                        
            </div>
            </div>
        </div>
    </div>
</x-layout>
    