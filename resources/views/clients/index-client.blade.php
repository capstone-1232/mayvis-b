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
                            <td>${client.email}</td>
                            <td>
                                <form id="deleteClientForm_${client.id}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this client?');" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            <td><a href="/clients/${client.id}/edit" class="btn btn-primary">Edit</a></td>
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
        <div class="container mt-5">

            
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="display-6 py-2">All Clients</h2>
                <a href="{{ route('clients.createClient') }}" class="btn btn-primary">ADD CLIENT</a>
            </div>

            <div class="container my-4">
                <form id="searchForm" action="{{ route('clients.searchClients') }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="search_term" name="search_term" class="form-control" placeholder="Search for clients...">
                        <button id="search_button" class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table px-5 search-results">
                <thead>
                    <tr>
                        <th scope="col">Company Name</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->company_name }}</td>
                            <td>{{ $client->first_name . ' ' . $client->last_name }}</td>
                            <td>{{ $client->email }}</td>

                            <td>
                                <form action="{{ route('clients.destroyClient', $client->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this client?');">
                                        Delete
                                    </x-danger-button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('clients.editClient', $client->id) }}" class="btn btn-primary">
                                    Edit
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
</x-layout>