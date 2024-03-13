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
                        // Check if the client object exists and has names, otherwise set to 'No Client'
                        let clientName = 'No Client';
                        let companyName = 'No Company';

                        if(proposal.client.company_name){
                            companyName = `${proposal.client.company_name}`.trim();
                        }
                        if (proposal.client && (proposal.client.first_name || proposal.client.last_name)) {
                            clientName = `${proposal.client.first_name || ''} ${proposal.client.last_name || ''}`.trim();
                        }

                        rowsHtml += `
                            <tr>
                                <td>${proposal.status}</td>
                                <td>${proposal.proposal_title}</td>
                                <td>${companyName}</td>
                                <td>${clientName}</td> 
                                <td>${proposal.start_date}</td>
                                <td>${proposal.created_by}</td>
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
                                    <th scope="col">Author <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($proposals as $proposal)
                                    <tr>
                                        <td>{{ $proposal->status }}</td>
                                        <td>{{ $proposal->proposal_title }}</td>
                                        <td>{{ $proposal->client->company_name }}</td>
                                        <td>{{ $proposal->client->first_name . ' ' . $proposal->client->last_name ?? 'No Client' }}</td>
                                        <td>{{ $proposal->start_date }}</td>
                                        <td>{{ $proposal->user->first_name . ' ' . $proposal->user->last_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>