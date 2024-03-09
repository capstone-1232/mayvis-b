<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sending Options') }}
        </h2>
    </x-slot>

    <div class="content">
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <h1 class="text-3xl font-bold mb-6">Sending Options</h1>
                        <p class="mb-10">Please choose between sending a printed PDF copy or generating a URL to share with your client. Alternatively, you may choose both options.</p>
                        
                        <div class="flex justify-around items-center mb-6">
                            <div class="p-4 max-w-sm bg-gray-100 rounded-lg border border-gray-200 shadow-md">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Send a PDF Copy</h5>
                                <p class="mb-3 font-normal text-gray-700">Note: Printable proposals are less desirable than soliciting feedback via client approval links.</p>
                                <a href="{{ route('session.info.pdf') }}" class="btn btn-primary">View PDF</a>
    
                            </div>
                            <div class="p-4 max-w-sm bg-gray-100 rounded-lg border border-gray-200 shadow-md">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Send using a link</h5>
                                <p class="mb-3 font-normal text-gray-700">Note: This proposal cannot be edited once the link has been created.</p>
                                <a href="{{ route('link.generate') }}" class="btn btn-primary">Generate Link</a>
                            </div>
                        </div>
    
                        <a href="{{ route('proposals.step6') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
