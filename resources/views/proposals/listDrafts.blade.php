<x-layout>
    <div class="content">
        <div class="container mt-2">
            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="display-6 py-2 fw-bold">
                        <i class="bi bi-file-earmark-diff me-3"></i>Drafts
                    </h2>
                </div>
            </div>

                    <div  class="bg-white p-4 rounded-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Draft Title</th>
                                    <th scope="col" class="d-none d-md-table-cell">Client Name</th>
                                    <th scope="col" class="d-none d-md-table-cell">Proposal Price</th>
                                    <th scope="col" class="d-none d-md-table-cell">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                {{-- Loop through drafts instead of proposals --}}
                                @forelse ($drafts as $draft)
                                    <tr>
                                        <td class="align-middle">{{ $draft->status }}</td>
                                        <td class="align-middle">{{ $draft->proposal_title }}</td>
                                        <td class="align-middle d-none d-md-table-cell">{{ $draft->client->first_name . ' ' . $draft->client->last_name }}</td>
                                        <td class="align-middle d-none d-md-table-cell">${{ $draft->proposal_price }}</td>
                                        <td class="align-middle d-none d-md-table-cell">{{ \Carbon\Carbon::parse($draft->created_at)->format('F j, Y') }}</td>
                                        {{-- <td>{{ $draft->created_at->toDateString() }}</td> --}}
                                        <td class="align-middle">
                                            {{-- The button to view the summary of a draft --}}
                                            <a href="{{ route('proposals.viewDraftSummary', $draft->id) }}" class="btn btn-primary">Resume</a>
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
