<x-layout>

    <!-- Google Charts Drawing Script -->
    <script>
         google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Period', 'Approved Proposals', 'Denied Proposals'],
                @foreach ($proposalsData as $data)
                    ['{{ $data->label }}', {{ $data->total_approved_price }}, {{ $data->total_denied_price }}],
                @endforeach
            ]);

            var options = {
                chart: {
                    title: 'Proposal Prices by Period',
                    subtitle: 'Comparison of approved and denied proposal prices',
                },
                bars: 'vertical',
                vAxis: {format: 'currency'},
                height: 200,
                colors: ['#1b9e77', '#d9534f']
            };

            var chart = new google.charts.Bar(document.getElementById('proposalsChart'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

    <div class="content">
    <div class="container my-3">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('debug'))
                <div class="alert alert-info">{{ session('debug') }}</div>
            @endif

            <div class="col-md-8 d-flex">
                <div class="d-flex align-items-center mb-4 bg-head p-3 rounded-5 w-100 shadow-sm">
                    <div class="me-4">
                        @if (Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="rounded-circle profile-photo">
                        @else
                            <img src="{{ asset('storage/placeholder.jpg') }}" alt="Profile Image" class="rounded-circle profile-photo">
                        @endif
                    </div>
                    
                    <div>
                        <h3 class="text-white fw-bold fs-4">Welcome back, {{ Auth::user()->first_name }}</h3>
                        <h4 class="fw-light fs-6 text-white">{{ Auth::user()->job_title }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card mb-4 rounded-5 w-100 d-flex align-items-center justify-content-center flex-column quick-link shadow-sm">
                    <a href="{{ route('servicesIndex') }}" class="text-decoration-none w-100 py-sm-3">
                        <div class="text-center">
                            <h3 class="fs-4 fw-bold text-white"><i class="bi bi-boxes me-2"></i>Services</h3>
                        </div>
                    </a>
                </div>
            </div>            
            
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4 rounded-5 client-proposal shadow-sm p-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between ">
                            <div class="me-3">
                                {{-- SVG --}}
                                <object data="images/svg/client-proposal.svg" width="auto" height="50"></object>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold fs-3">Client Proposal</h3>
                                <p class="card-text mb-4">Initiate a fresh proposal estimate with a single click.</p>
                                <a href="{{ route('proposals.step1') }}" class="btn btn-warning-custom border rounded-pill w-75 fw-semibold text-uppercase ">Create New</a>
                            </div>
                            <div>
                                {{-- SVG --}}
                                <object data="images/svg/proposal.svg" width="auto" height="150"></object>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card mb-4 rounded-5 w-100 d-flex align-items-center justify-content-center flex-column shadow-sm p-4">
                    <!-- Change this to a div instead of canvas -->
                    <div id="proposalsChart" style="width:100%; height:auto;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 ">
                <div class="bg-white shadow-sm rounded-5 p-4">
                    <div class="">
                        <table class="table mb-0">
                            <thead class="border-bottom border-secondary-subtle">
                                <tr class="fs-5 text-center text-dark">
                                    <th scope="col">Proposal Name <i class="fas fa-sort ms-2"></i></th>
                                    <th scope="col">Client Name <i class="fas fa-sort ms-2"></i></th>
                                    <th scope="col">Status <i class="fas fa-sort ms-2"></i></th>
                                    <th scope="col">Date <i class="fas fa-sort ms-2"></i></th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($proposals as $proposal)
                                    <tr>
                                        <td class="ps-md-5 fs-6">{{ $proposal->proposal_title }}</td>
                                        <td class="ps-md-5 fs-6">{{ $proposal->client->first_name . ' ' . $proposal->client->last_name ?? 'No Client' }}</td>
                                        <td class="text-center fs-6">
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
                                        <td class="text-center fs-6">{{ \Carbon\Carbon::parse($proposal->start_date)->format('F j, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-container" class="mt-3">
                        {{ $proposals->links() }}
                    </div>
                    <div class=" bg-white text-center mt-4">
                        <a href="{{ route('storedProposals.storedProposalsIndex') }}" class="btn primary-btn text-white rounded-pill w-25 fw-semibold">View All</a>
                    </div>
                </div>

            </div>

    </div>
</div>
</div>
</x-layout>