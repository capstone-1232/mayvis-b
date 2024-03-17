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
                    const tableBody = document.getElementById('tableBody'); 
                    tableBody.innerHTML = ''; // Clear existing rows

                    let rowsHtml = '';
                    data.forEach(proposal => {
                        // Check if the client object exists and has names, otherwise set to 'No Client'
                        let clientName = 'No Client';
                        let companyName = 'No Company';

                        if(proposal.client.company_name){
                            companyName = `${proposal.client.company_name}`.trim();
                        }
                        if (proposal.client && (proposal.client.first_name || proposal.client.last_name)) {
                            clientName = `${proposal.client.first_name || ''} ${proposal.client.last_name || ''}`.trim();
                        }

                        // Construct the profile image URL
                        let profileImageUrl = proposal.user && proposal.user.profile_image ? `storage/${proposal.user.profile_image}` : 'default.jpg';
                        let profileImageTag = `<img src="${profileImageUrl}" alt="Profile Image" class="rounded-circle profile-photo">`;

                        // Determine badge based on proposal status
                        let statusBadge;
                        switch(proposal.status) {
                            case "Approved":
                                statusBadge = `<span class="badge bg-success">${proposal.status}</span>`;
                                break;
                            case "Pending":
                                statusBadge = `<span class="badge bg-warning">${proposal.status}</span>`;
                                break;
                            case "Denied":
                                statusBadge = `<span class="badge bg-danger">${proposal.status}</span>`;
                                break;
                            default:
                                statusBadge = `<span class="badge bg-secondary">${proposal.status}</span>`;
                        }
                        
                        // Proposal Feedback Link in the template
                        let actionColumnContent;
                        if (proposal.status === 'Approved' || proposal.status === 'Denied') {
                            actionColumnContent = 'Feedback Submitted';
                        } else {
                            actionColumnContent = `<a href="${proposal.generatedLink}" class="btn btn-primary">Access Proposal</a>`;
                        }
                        

                        rowsHtml += `
                            <tr>
                                <td>${statusBadge}</td>
                                <td>${proposal.proposal_title}</td>
                                <td>${companyName}</td>
                                <td>${clientName}</td> 
                                <td>${proposal.start_date}</td>
                                <td>${actionColumnContent}</td>
                                <td>${profileImageTag}</td>
                            </tr>
                        `;
                    });
                    tableBody.innerHTML = rowsHtml;
                }
                {}

        });


    </script>
    
    <div class="content">
        <div class="container mt-5">
            <div class="my-2">
                <form id="searchForm" action="{{ route('storedProposals.searchProposals') }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="search_term" name="search_term" class="form-control" placeholder="Search by proposal title or client name">
                        <button id="search_button" class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <i class="fas fa-file-alt me-2"></i>Proposals
                    </div>
                    
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Status <i class="fas fa-sort"></i></th>
                                    <th scope="col">Proposal Name <i class="fas fa-sort"></i></th>
                                    <th scope="col">Company Name <i class="fas fa-sort"></i></th>
                                    <th scope="col">Client Name <i class="fas fa-sort"></i></th>
                                    <th scope="col">Date <i class="fas fa-sort"></i></th>
                                    <th scope="col">Active Link <i class="fas fa-sort"></i></th>
                                    <th scope="col">Author <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($proposals as $proposal)
                                    <tr>
                                        <td>
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
                                        <td>{{ $proposal->proposal_title }}</td>
                                        <td>{{ $proposal->client->company_name }}</td>
                                        <td>{{ $proposal->client->first_name . ' ' . $proposal->client->last_name ?? 'No Client' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($proposal->start_date)->format('F j, Y') }}</td>
                                        <td>
                                            @if ($proposal->status === 'Approved' || $proposal->status === 'Denied')
                                                Feedback Submitted
                                            @else
                                                <a href="{{ $generatedLink }}" class="btn btn-primary">Access Proposal</a>
                                            @endif
                                        </td>
                                        <td><img src="{{ asset('storage/' . $proposal->user->profile_image) }}" alt="Profile Image" class="rounded-circle profile-photo"></td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="pagination-container">
            {{ $proposals->links() }}
        </div>
    </div>
</x-layout>