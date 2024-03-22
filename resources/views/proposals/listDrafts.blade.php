<x-layout>
    <div class="content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card shadow-sm">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
            
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    <div class="card-header bg-white">
                        <i class="fas fa-file-alt me-2"></i>Drafts
                    </div>


                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Draft Title</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Proposal Price</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Resume</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                {{-- Loop through drafts instead of proposals --}}
                                @forelse ($drafts as $draft)
                                    <tr>
                                        <td>
                                            @switch($draft->status)
                                            @case('Approved')
                                                <span class="badge bg-success">{{ $draft->status }}</span>
                                                @break
                                    
                                            @case('Pending')
                                                <span class="badge bg-warning">{{ $draft->status }}</span>
                                                @break
                                    
                                            @case('Denied')
                                                <span class="badge bg-danger">{{ $draft->status }}</span>
                                                @break
                                    
                                            @default
                                                <span class="badge bg-secondary">{{ $draft->status }}</span>
                                        @endswitch   
                                        </td>
                                        <td>{{ $draft->proposal_title }}</td>
                                        <td>{{ $draft->client->first_name . ' ' . $draft->client->last_name }}</td>
                                        <td>${{ $draft->proposal_price }}</td>
                                        <td>{{ \Carbon\Carbon::parse($draft->created_at)->format('F j, Y') }}</td>
                                        <td>
                                            {{-- The button to view the summary of a draft --}}
                                            <a href="{{ route('proposals.viewDraftSummary', $draft->id) }}" class="btn btn-primary">Resume</a>
                                        </td>
                                        <td class="align-middle">
                                            <form action="{{ route('proposals.destroyDraft', $draft->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button type="submit" class="no-style fs-3" onclick="return confirm('Are you sure you want to delete this draft?');">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </x-danger-button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No drafts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
