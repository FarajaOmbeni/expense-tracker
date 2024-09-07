<h1>Income Chart for <?= $username ?></h1>
<canvas id="incomeByDateChart"></canvas>

<script>
    const ctx = document.getElementById('incomeByDateChart').getContext('2d');
    const incomeByDateChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $dates ?>,
            datasets: [{
                label: 'Income',
                data: <?= $income ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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
                    text: 'Income by Date'
                }
            }
        }
    });
</script>