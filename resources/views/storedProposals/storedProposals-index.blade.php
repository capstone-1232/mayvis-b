<x-layout>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Search Function
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    let searchTerm = document.getElementById('search_term').value;
                    fetch("{{ route('storedProposals.searchProposals') }}?search_term=" + searchTerm)
                        .then(response => response.json())
                        .then(data => {
                            renderProducts(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });

                    function renderProducts(data) {
                    const tableBody = document.getElementById('tableBody'); // Ensure this ID matches your table body
                    tableBody.innerHTML = ''; // Clear existing rows

                    let rowsHtml = '';
                    data.forEach(proposal => {
    // Check if the client object exists and has names, otherwise set to 'No Client' and 'No Company'
    let clientName = 'No Client';
    let companyName = 'No Company';

    if (proposal.client && proposal.client.company_name) {
        companyName = proposal.client.company_name.trim();
    }
    if (proposal.client && (proposal.client.first_name || proposal.client.last_name)) {
        clientName = `${proposal.client.first_name || ''} ${proposal.client.last_name || ''}`.trim();
    }

    // Format the date in 'F j, Y' format
    const startDate = new Date(proposal.start_date);
    const formattedDate = startDate.toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric',
    });

    // Determine status badge based on proposal status
    let statusBadgeClass = '';
    let statusText = proposal.status || 'Unknown';
    switch (proposal.status) {
        case 'Approved':
            statusBadgeClass = 'bg-success';
            break;
        case 'Pending':
            statusBadgeClass = 'bg-warning';
            break;
        case 'Denied':
            statusBadgeClass = 'bg-danger';
            break;
        default:
            statusBadgeClass = 'bg-secondary';
            break;
    }
    const statusBadge = `<span class="badge ${statusBadgeClass}">${statusText}</span>`;

     // Construct the profile image URL
     let profileImageUrl = proposal.user && proposal.user.profile_image ? `storage/${proposal.user.profile_image}` : 'default.jpg';
    let profileImageTag = `<img src="${profileImageUrl}" alt="Profile Image" class="rounded-circle profile-photo">`;

                            // Proposal Feedback Link in the template
                            let actionColumnContent;
                        if (proposal.status === 'Approved' || proposal.status === 'Denied') {
                            actionColumnContent = 'Feedback Submitted';
                        } else if (proposal.view_link) { // Make sure view_link is available
                            actionColumnContent = `<a href="${proposal.view_link}" class="btn btn-primary">Access Proposal</a>`;
                        } else {
                            actionColumnContent = 'Link Unavailable'; // Provide a fallback text
                        }

    rowsHtml += `
        <tr>
            <td class="align-middle">${statusBadge}</td>
            <td class="align-middle">${proposal.proposal_title}</td>
            <td class="align-middle d-none d-md-table-cell">${companyName}</td>
            <td class="align-middle d-none d-md-table-cell">${clientName}</td> 
            <td class="align-middle d-none d-md-table-cell">${formattedDate}</td>
            <td class="align-middle d-none d-md-table-cell">${actionColumnContent}</td>
            <td class="align-middle">${profileImageTag}</td>
        </tr>
    `;
});

                    tableBody.innerHTML = rowsHtml;
                }
                {}

        });


    </script>
    
    <div class="content">
        <div class="container mt-2">
                    <div class="my-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="display-6 py-2 fw-bold">
                                <i class="fas fa-file-alt me-3"></i>Proposals
                            </h2>
                            <a href="{{ route('proposals.step1') }}" class="btn primary-btn text-white rounded-pill text-uppercase fw-bold px-5">Create New</a>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-4">
                        <div class="container">
                            <form id="searchForm" action="{{ route('storedProposals.searchProposals') }}" method="GET">
                                <div class="input-group mb-4 border-2 rounded-pill">
                                    <input type="text" id="search_term" name="search_term" class="form-control border-0 rounded-start-pill " placeholder="Search">
                                    <button id="search_button" class="btn text-white primary-btn fw-bold px-5 rounded-pill" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Proposal Name <i class="fas fa-sort"></i></th>
                                    <th scope="col" class="d-none d-md-table-cell">Company Name <i class="fas fa-sort"></i></th>
                                    <th scope="col" class="d-none d-md-table-cell">Client Name <i class="fas fa-sort"></i></th>
                                    <th scope="col" class="d-none d-md-table-cell">Date <i class="fas fa-sort"></i></th>
                                    <th scope="col" class="d-none d-md-table-cell">Active Link</th>
                                    <th scope="col">Author</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($proposals as $proposal)
                                    <tr>
                                        <td class="align-middle">
                                            @switch($proposal->status)
                                                @case('Approved')
                                                    <span class="badge bg-success">{{ $proposal->status }}</span>
                                                    @break
                                        
                                                @case('Pending')
                                                    <span class="badge bg-warning">{{ $proposal->status }}</span>
                                                    @break
                                        
                                                @case('Denied')
                                                    <span class="badge bg-danger">{{ $proposal->status }}</span>
                                                    @break
                                        
                                                @default
                                                    <span class="badge bg-secondary">{{ $proposal->status }}</span>
                                            @endswitch
                                        </td>
                                        <td class="align-middle">{{ $proposal->proposal_title }}</td>
                                        <td class="align-middle d-none d-md-table-cell">{{ $proposal->client->company_name }}</td>
                                        <td class="align-middle d-none d-md-table-cell">{{ $proposal->client->first_name . ' ' . $proposal->client->last_name ?? 'No Client' }}</td>
                                        <td class="align-middle d-none d-md-table-cell">{{ \Carbon\Carbon::parse($proposal->start_date)->format('F j, Y') }}</td>
                                        <td class="align-middle d-none d-md-table-cell">
                                            @if ($proposal->status === 'Approved' || $proposal->status === 'Denied')
                                            <p class="text-warning">Feedback Submitted</p>
                                        @elseif ($proposal->view_link)
                                            {{-- Use the view_link directly from the Proposal model --}}
                                            <a href="{{ $proposal->viewLink }}" class="btn btn-primary">Access Proposal</a>
                                        @else
                                            Link Unavailable
                                        @endif
                                        </td>
                                        <td class="align-middle"><img src="{{ asset('storage/' . $proposal->user->profile_image) }}" alt="Profile Image" class="rounded-circle profile-photo"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
        </div>
        <div id="pagination-container">
            {{ $proposals->links() }}
        </div>
    </div>
</x-layout>