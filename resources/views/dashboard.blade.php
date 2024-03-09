<x-layout>
    <div class="content">
    <div class="container my-3">
        <div class="row">
            <div class="col-md-8 d-flex">
                <div class="d-flex align-items-center mb-3 bg-dark p-3 rounded-5 w-100 shadow-sm">
                    <div class="me-3">
                        <img src="https://via.placeholder.com/64" alt="Profile Image" class="rounded-circle profile-photo">
                    </div>
                    <div>
                        <h3 class="text-white fw-bold fs-5">Welcome back, {{ Auth::user()->first_name }}</h3>
                        <h4 class="fw-light fs-6 text-white">{{ Auth::user()->job_title }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card mb-3 rounded-5 w-100 d-flex align-items-center justify-content-center flex-column quick-link shadow-sm">
                    <a href="{{ route('servicesIndex') }}" class="text-decoration-none w-100">
                        <div class="card-body text-center text-white">
                            <h3 class="card-title fs-5 fw-bold"><i class="fas fa-cogs fa-lg me-2"></i>Services</h3>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 rounded-5 client-proposal shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between ">
                            <div class="me-3">
                                {{-- SVG --}}
                                <object data="images/svg/client-proposal.svg" width="auto" height="50"></object>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold fs-3">Client Proposal</h3>
                                <p class="card-text mb-3">Initiate a fresh proposal estimate with a single click.</p>
                                <a href="{{ route('proposals.step1') }}" class="btn login-btn custom-btn fw-bold rounded-pill text-uppercase fw-bold text-white">Create New</a>
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
                <div class="card mb-3 rounded-5 w-100 d-flex align-items-center justify-content-center flex-column shadow-sm">
                    {{-- Insert Graph here --}}
                </div>
            </div>
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
                                <th scope="col">Proposal Name <i class="fas fa-sort"></i></th>
                                <th scope="col">Client Name <i class="fas fa-sort"></i></th>
                                <th scope="col">Status <i class="fas fa-sort"></i></th>
                                <th scope="col">Date <i class="fas fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Proposal Name Lorem</td>
                                <td>Client Name</td>
                                <td><span class="badge bg-success">Publishing</span></td>
                                <td>Feb 1, 2024</td>
                            </tr>
                            <tr>
                                <td>Proposal Name Lorem</td>
                                <td>Client Name</td>
                                <td><span class="badge bg-warning text-dark">Ongoing</span></td>
                                <td>Jan 30, 2024</td>
                            </tr>
                            <tr>
                                <td>Proposal Name Lorem</td>
                                <td>Client Name</td>
                                <td><span class="badge bg-danger">Disapproved</span></td>
                                <td>Dec 28, 2024</td>
                            </tr>
                            <tr>
                                <td>Proposal Name Lorem</td>
                                <td>Client Name</td>
                                <td><span class="badge bg-warning text-dark">Ongoing</span></td>
                                <td>Dec 24, 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="btn btn-primary">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</x-layout>