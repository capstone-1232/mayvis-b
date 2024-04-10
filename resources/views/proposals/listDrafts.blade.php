<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="display-6 py-2 fw-bold">
                        <i class="bi bi-file-earmark-diff me-3"></i>Drafts
                    </h2>
                </div>
            </div>

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


                    <div  class="bg-white p-4 rounded-5 shadow">
                        <table class="table">
                            <thead class="border-bottom border-secondary-subtle">
                                <tr class="fs-5 text-center text-dark">
                                    <th scope="col">Status</th>
                                    <th scope="col">Draft Title</th>
                                    <th scope="col" class="d-none d-md-table-cell">Client Name</th>
                                    <th scope="col" class="d-none d-md-table-cell">Proposal Price</th>
                                    <th scope="col" class="d-none d-md-table-cell">Created At</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                {{-- Loop through drafts instead of proposals --}}
                                @forelse ($drafts as $draft)
                                    <tr>
                                        <td class="align-middle">
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
                                        <td class="align-middle fw-semibold">{{ $draft->proposal_title }}</td>
                                        <td class="align-middle d-none d-md-table-cell fst-italic">{{ $draft->client->first_name . ' ' . $draft->client->last_name }}</td>
                                        <td class="align-middle d-none d-md-table-cell text-center fw-semibold">${{ $draft->proposal_price }}</td>
                                        <td class="align-middle d-none d-md-table-cell text-center">{{ \Carbon\Carbon::parse($draft->created_at)->format('F j, Y') }}</td>
                                        {{-- <td>{{ $draft->created_at->toDateString() }}</td> --}}
                                        <td class="align-middle">
                                            {{-- The button to view the summary of a draft --}}
                                            <a href="{{ route('proposals.viewDraftSummary', $draft->id) }}" class="btn btn-info-custom border rounded-pill w-100 fw-semibold">Resume</a>
                                        </td>
                                        <td class="align-middle text-center">
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
</x-layout>
