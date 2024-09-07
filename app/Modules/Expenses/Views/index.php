<div class="d-flex flex-column justify-content-center align-items-center mt-5">
    <h1>Expenses Chart for <?= $username ?></h1>
    <!-- Bar Graph Container -->
    <canvas id="expensesByDateChart"></canvas>

    <script>
        const ctx = document.getElementById('expensesByDateChart').getContext('2d');
        const expensesByDateChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= $dates ?>, // Dates for x-axis
                datasets: [{
                    label: 'Expenses',
                    data: <?= $expenses ?>, // Expenses for y-axis
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Bar color
                    borderColor: 'rgba(255, 99, 132, 1)', // Bar border color
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Expenses by Date'
                    }
                }
            }
        });
    </script>
</div>