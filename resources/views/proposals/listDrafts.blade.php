<x-layout>
    <div class="content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card shadow-sm">
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                {{-- Loop through drafts instead of proposals --}}
                                @forelse ($drafts as $draft)
                                    <tr>
                                        <td>{{ $draft->status }}</td>
                                        <td>{{ $draft->proposal_title }}</td>
                                        <td>{{ $draft->client->first_name . ' ' . $draft->client->last_name }}</td>
                                        <td>${{ $draft->proposal_price }}</td>
                                        <td>{{ $draft->created_at->toDateString() }}</td>
                                        <td>
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
        </div>
    </div>
</x-layout>
