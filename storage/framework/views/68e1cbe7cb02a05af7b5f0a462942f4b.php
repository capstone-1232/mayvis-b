<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('proposalsChart').getContext('2d');
            const proposalsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    // Using the 'label' property for display on the chart
                    labels: [<?php $__currentLoopData = $approvedProposalsSumByWeek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> '<?php echo e($data->label); ?>', <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],

                    datasets: [
                        {
                            label: 'Total Price of Approved Proposals',
                            // Using 'total_price' for the data points
                            data: [<?php $__currentLoopData = $approvedProposalsSumByWeek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->total_price); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Proposal Price'
                            }
                        },
                        x: {
                            // This will be handled by the 'labels' array
                            title: {
                                display: true,
                                text: 'Weeks of the Year'
                            }
                        }
                    }
                }
            });
        });
    </script>

    <div class="content">
    <div class="container my-3">
        <div class="row">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <div class="col-md-8 d-flex">
                <div class="d-flex align-items-center mb-3 bg-dark p-3 rounded-5 w-100 shadow-sm">
                    <div class="me-3">
                        <img src="<?php echo e(asset('storage/' . Auth::user()->profile_image)); ?>" alt="Profile Image" class="rounded-circle profile-photo">
                    </div>
                    <div>
                        <h3 class="text-white fw-bold fs-5">Welcome back, <?php echo e(Auth::user()->first_name); ?></h3>
                        <h4 class="fw-light fs-6 text-white"><?php echo e(Auth::user()->job_title); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card mb-3 rounded-5 w-100 d-flex align-items-center justify-content-center flex-column quick-link shadow-sm">
                    <a href="<?php echo e(route('servicesIndex')); ?>" class="text-decoration-none w-100">
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
                                
                                <object data="images/svg/client-proposal.svg" width="auto" height="50"></object>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold fs-3">Client Proposal</h3>
                                <p class="card-text mb-3">Initiate a fresh proposal estimate with a single click.</p>
                                <a href="<?php echo e(route('proposals.step1')); ?>" class="btn login-btn custom-btn fw-bold rounded-pill text-uppercase fw-bold text-white">Create New</a>
                            </div>
                            <div>
                                
                                <object data="images/svg/proposal.svg" width="auto" height="150"></object>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card mb-3 rounded-5 w-100 d-flex align-items-center justify-content-center flex-column shadow-sm">
                    <canvas id="proposalsChart" style="width:100%; height:180px;"></canvas> 
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
                            <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($proposal->proposal_title); ?></td>
                                    <td><?php echo e($proposal->client->first_name . ' ' . $proposal->client->last_name ?? 'No Client'); ?></td>
                                    <td>
                                        <?php switch($proposal->status):
                                            case ('Approved'): ?>
                                                <span class="badge bg-success"><?php echo e($proposal->status); ?></span>
                                                <?php break; ?>
                                    
                                            <?php case ('Pending'): ?>
                                                <span class="badge bg-warning"><?php echo e($proposal->status); ?></span>
                                                <?php break; ?>
                                    
                                            <?php case ('Denied'): ?>
                                                <span class="badge bg-danger"><?php echo e($proposal->status); ?></span>
                                                <?php break; ?>
                                    
                                            <?php default: ?>
                                                <span class="badge bg-secondary"><?php echo e($proposal->status); ?></span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td><?php echo e(\Carbon\Carbon::parse($proposal->start_date)->format('F j, Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="<?php echo e(route('storedProposals.storedProposalsIndex')); ?>" class="btn btn-primary">View All</a>
                </div>
            </div>
        </div>
    </div>

    <div id="pagination-container">
        <?php echo e($proposals->links()); ?>

    </div>
</div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>