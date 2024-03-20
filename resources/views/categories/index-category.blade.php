<x-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting traditionally

            let searchTerm = document.getElementById('search_term').value;
            let tableBody = document.querySelector('.table tbody'); // Select the table body directly

            fetch(`{{ route('clients.searchClients') }}?search_term=${encodeURIComponent(searchTerm)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Ensures Laravel treats the request as AJAX
                }
            })
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = ''; // Clear current table rows

                if(data.length > 0) {
                    data.forEach(client => {
                        tableBody.innerHTML += `
    <tr>
        <td>${client.company_name}</td>
        <td>${client.first_name} ${client.last_name}</td>
        <td class="d-none d-lg-table-cell">${client.email}</td>
        <td>
            <!-- Action buttons -->
        </td>
        <td>
            <!-- Action buttons -->
        </td>
    </tr>
`;


                        // Dynamically set the action attribute of the delete form
                        document.getElementById(`deleteClientForm_${client.id}`).action = `/clients/${client.id}`;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No clients found.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">An error occurred while searching. Please try again later.</td></tr>';
            });
        });
    });

    </script>
    <div class="content">
        <div class="container mt-2">
            
            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="display-6 py-2 fw-bold">
                        <i class="bi bi-person-fill me-3"></i>All Clients
                    </h2>
                    <a href="{{ route('clients.createClient') }}" class="btn primary-btn text-white rounded-pill text-uppercase fw-bold px-5">Add Client</a>
                </div>
            </div>

            

            <div class="bg-white p-4 rounded-4">
                <div class="container">
                    <form id="searchForm" action="{{ route('clients.searchClients') }}" method="GET">
                        <div class="input-group mb-4 border-2 rounded-pill">
                            <input type="text" id="search_term" name="search_term" class="form-control border-0 rounded-start-pill " placeholder="Search">
                            <button id="search_button" class="btn text-white primary-btn fw-bold px-5 rounded-pill" type="submit">Search</button>
                        </div>
                    </form>
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
    
    
                <table class="table px-5 search-results">
                    <thead>
                        <tr>
                            <th scope="col">Company Name</th>
                            <th scope="col">Client Name</th>
                            <th scope="col" class="d-none d-lg-table-cell">Email</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td class="align-middle">{{ $client->company_name }}</td>
                                <td class="align-middle">{{ $client->first_name . ' ' . $client->last_name }}</td>
                                <td class="align-middle d-none d-lg-table-cell">{{ $client->email }}</td>
    
                                <td class="align-middle">
                                    <form action="{{ route('clients.destroyClient', $client->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" class="no-style fs-3" onclick="return confirm('Are you sure you want to delete this client?');">
                                            <i class="bi bi-trash3-fill"></i>
                                        </x-danger-button>
                                    </form>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('clients.editClient', $client->id) }}" class="fs-3">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <!-- Pagination links -->
                    <div>
                        {{ $clients->links() }}
                    </div>
            </div>

        </div>
    </div>
</x-layout>