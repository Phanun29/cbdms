// Chart.defaults.global.defaultFontFamily = 'Nunito', 'Khmer OS', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
// Chart.defaults.global.defaultFontColor = '#858796';
// Graph 1 (with two values)
var ctx1 = document.getElementById('combinedChart').getContext('2d');
//  combinedChart = new Chart(ctx, {
var chart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['កម្ពស់ផ្លែ (ជាមធ្យម)', 'កម្ពស់ដើម​ (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាញី​ ៥០% (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% (ជាមធ្យម)'],
        datasets: [{
            label: '',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            data: [0, 0, 0, 0]

        }, {
            label: '',
            backgroundColor: 'rgba(15, 12, 92, 0.32)',
            borderColor: 'rgba(75, 192, 192, 1)',
            data: [0, 0, 0, 0]
        }]

    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
            labels: {
                font: {
                    size: 16, // Font size for legend
                    family: "'Khmer OS Battambang','Arial', sans-serif", // Font family for legend
                    weight: 'bold' // Font weight for legend
                }
            }
        },
        title: {
            display: true,
            text: 'Comparison of Breeds and Versions for Different Metrics',
            font: {
                size: 18, // Font size for title
                family: "'Khmer OS Battambang','Arial', sans-serif", // Font family for title
                weight: 'bold', // Font weight for title
                style: 'italic' // Font style for title
            }
        }
    }
});