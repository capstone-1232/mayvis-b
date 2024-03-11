<x-layout>
    <div class="content">
        <div class="container mt-5">
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
                            <tbody>
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