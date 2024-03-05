<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proposals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg mt-2">

                <!-- Message should be highlighted here -->
                <div class="container my-4">
                    <ul class="step-progress-bar">
                      <li>Client</li>
                      <li>Title</li>
                      <li>Message</li>
                      <li>Deliverables</li>
                      <li>Finalize</li>
                    </ul>
                </div>

                <div class="container my-4">
                    <div class="row">
                      <div class="col">
                        <h1 class="display-3">Compose a message to your client</h1>
                      </div>
                    </div>
                </div>
                
                
               <!-- This form will be routed to the storeStep3 function inside 'ProposalController.php' -->
                <form action="{{ route('proposals.storeStep3') }}" method="post">
                    @csrf
                    <label for="sender">Sender</label>
                    <x-text-input type="text" name="sender" field="sender" placeholder="Staff Sender" class="w-full my-2" autocomplete="off" :value="old('sender', Auth::user()->name)"></x-text-input>

                    <label for="automated_message">Automated Message</label>
                    <x-textarea id="automated_message" name="automated_message" class="mt-1 block w-full" value="{{ Auth::user()->automated_message }}"></x-textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('automated_message')" />


                    
                    <a href="{{ route('proposals.step2') }}">Previous</a>
                    <x-primary-button class="mt-6">Next</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
    