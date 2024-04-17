<x-layout>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
       const paginationContainer = document.getElementById('pagination-container');
       const searchForm = document.getElementById('searchForm');
       function togglePaginationVisibility() {
           if (searchForm.search_term.value) {
               paginationContainer.style.display = 'none';
           } else {
               paginationContainer.style.display = 'block';
           }
       }
       function handleFormSubmit(e) {
           e.preventDefault();
       
           let searchTerm = document.getElementById('search_term').value;
           let tableBody = document.querySelector('.table tbody');
       
           fetch(`{{ route('clients.searchClients') }}?search_term=${encodeURIComponent(searchTerm)}`, {
               headers: {
                   'Accept': 'application/json',
                   'X-Requested-With': 'XMLHttpRequest',
               }
           })
           .then(response => response.json())
           .then(data => {
               tableBody.innerHTML = ''; 
       
               if(data.length > 0) {
                   data.forEach(client => {
                       tableBody.innerHTML += `
                       <tr>
                               <td  class="align-middle ps-5">${client.company_name}</td>
                               <td  class="align-middle ps-5">${client.first_name} ${client.last_name}</td>
                               <td  class="align-middle ps-5">${client.email}</td>
                               <td  class="align-middle text-center">
                                   <form id="deleteClientForm_${client.id}" method="POST">
                                       @csrf
                                       @method('DELETE')
                                       <x-danger-button type="submit" class="no-style fs-3" onclick="return confirm('Are you sure you want to delete this client?');">
                                           <i class="bi bi-trash3-fill"></i>
                                       </x-danger-button>
                                   </form>
                               </td>
                               <td  class="align-middle text-center">
                                   <a href="/clients/${client.id}/edit" class="fs-3">
                                       <i class="bi bi-pencil-square"></i>
                                   </a>
                               </td>
                           </tr>
       
                       `;
                    document.getElementById(`deleteClientForm_${client.id}`).action = `/clients/${client.id}`;
                   });
               } else {
                   tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No clients found.</td></tr>';
               }
               togglePaginationVisibility();
           })
           .catch(error => {
               console.error('Error:', error);
               tableBody.innerHTML = '<tr><td colspan="5" class="text-center">An error occurred while searching. Please try again later.</td></tr>';
           });
       }
       
       document.getElementById('searchForm').addEventListener('submit', handleFormSubmit);
       
       togglePaginationVisibility();
       });
       
    </script>
    <div class="content">
       <div class="container mt-2">
          <div class="my-4">
             <div class="d-flex justify-content-between align-items-center">
                <h2 class="display-6 py-2 fw-bold">
                   <i class="bi bi-people me-3"></i>All Clients
                </h2>
                <a href="{{ route('clients.createClient') }}" class="btn primary-btn rounded-pill text-white fw-bold px-5">Add Client</a>
             </div>
          </div>
          <div class="bg-white p-4 rounded-5 shadow">
             <div class="container">
                <form id="searchForm" action="{{ route('clients.searchClients') }}" method="GET">
                   <div class="input-group mb-4 border-2 rounded-pill mt-2">
                      <input type="text" id="search_term" name="search_term" class="form-control border-0 rounded-start-pill " placeholder="Search by Client Name">
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
                <thead class="border-bottom border-secondary-subtle">
                   <tr class="fs-5 text-center text-dark">
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
                      <td class="align-middle ps-5 fw-medium">{{ $client->company_name }}</td>
                      <td class="align-middle ps-5 fst-italic">{{ $client->first_name . ' ' . $client->last_name }}</td>
                      <td class="align-middle d-none d-lg-table-cell ps-5 fw-medium">{{ $client->email }}</td>
                      <td class="align-middle text-center">
                         <form action="{{ route('clients.destroyClient', $client->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" class="no-style fs-3" onclick="return confirm('Are you sure you want to delete this client?');">
                               <i class="bi bi-trash3-fill"></i>
                            </x-danger-button>
                         </form>
                      </td>
                      <td class="align-middle text-center">
                         <a href="{{ route('clients.editClient', $client->id) }}" class="fs-3">
                         <i class="bi bi-pencil-square"></i>
                         </a>
                      </td>
                   </tr>
                   @endforeach
                </tbody>
             </table>
             @if(!request()->has('search_term'))
             <div id="pagination-container" class="mt-3 pagination-container">
                {{ $clients->links() }}
             </div>
             @endif
          </div>
       </div>
    </div>
 </x-layout>