<x-layout>
    <div class="content">
        <div class="container my-5">
            <canvas id="proposalsChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('proposalsChart').getContext('2d');
            const proposalsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    // Using the 'label' property for display on the chart
                    labels: [@foreach ($approvedProposalsSumByWeek as $data) '{{ $data->label }}', @endforeach],

                    datasets: [
                        {
                            label: 'Total Price of Approved Proposals',
                            // Using 'total_price' for the data points
                            data: [@foreach ($approvedProposalsSumByWeek as $data) {{ $data->total_price }}, @endforeach],
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
</x-layout>
