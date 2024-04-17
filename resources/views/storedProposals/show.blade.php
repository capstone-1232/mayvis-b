<x-layout>
    <div class="content">
       <div class="container my-5">
          <div class="row justify-content-center">
             <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="bg-white p-4 rounded-5 shadow">
                   <div class="mb-4">
                      <div class="d-flex justify-content-between align-items-center">
                         <h2 class="display-6 fw-bold">
                            <i class="bi bi-file-earmark-text me-3"></i>Proposal Details
                         </h2>
                      </div>
                   </div>
                   <div class="ms-3">
                      <h5 class="card-title">{{ $proposal->proposal_title }}</h5>
                      <p class="card-text ms-2">Client: <span class="text-decoration-underline">{{ $proposal->client->first_name ?? '' }} {{ $proposal->client->last_name ?? '' }}</span></p>
                      <p class="card-text mt-1 ms-2">Status: <span class="badge {{ $proposal->status == 'Approved' ? 'bg-success' : ($proposal->status == 'Pending' ? 'bg-warning' : ($proposal->status == 'Denied' ? 'bg-danger' : 'bg-secondary')) }}">{{ $proposal->status }}</span></p>
                      <p class="card-text mt-1 ms-2">Start Date: {{ \Carbon\Carbon::parse($proposal->start_date)->format('F j, Y') }}</p>
                      <p class="card-text mt-1 ms-2">Created By: {{ $proposal->user->first_name ?? '' }} {{ $proposal->user->last_name ?? '' }}</p>
                      <div class="mt-4">
                         <h4 class="text-uppercase fw-bold mb-2">Projects and Scopes:</h4>
                         @foreach ($products as $product)
                         <div class=" bg-secondary-subtle rounded-3 p-3 mb-2  ms-2">
                            <h3 class="fw-bold mt-1">{{ $product->product_name }}</h3>
                            @if (isset($projectScopes[$loop->index]))
                            <div class="project-scope">
                              <span class="text-black">{!! $projectScopes[$loop->index] !!}</span>
                            </div>
                            @endif
                         </div>
                         @endforeach
                      </div>
                      <p class="card-text mt-1">Proposal Total: <span class="text-decoration-underline">$ {{ $proposal->proposal_price }}</span></p>
                   </div>
                </div>
             </div>
             <div class="d-flex justify-content-start align-items-center mt-4">
                <a href="{{ route('storedProposals.storedProposalsIndex') }}" class="fs-7 fw-semibold me-2"><i class="bi bi-caret-left-fill me-2"></i>Back to Proposal List</a>
             </div>
          </div>
       </div>
    </div>
 </x-layout>