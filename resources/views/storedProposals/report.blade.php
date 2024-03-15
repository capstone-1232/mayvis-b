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
                    labels: [@foreach ($approvedProposalsCountByMonth as $data) '{{ date("F", mktime(0, 0, 0, $data->month, 10)) }}', @endforeach],
                    datasets: [
                        {
                            label: 'Approved Proposals',
                            data: [@foreach ($approvedProposalsCountByMonth as $data) {{ $data->count }}, @endforeach],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Denied Proposals',
                            data: [@foreach ($deniedProposalsCountByMonth as $data) {{ $data->count }}, @endforeach],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255,99,132,1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-layout>
