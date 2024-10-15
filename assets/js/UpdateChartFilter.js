$(document).ready(function () {
    let averageFruitHeight1 = null;
    let averageFruitHeight2 = null;
    let averageStemHeight1 = null;
    let averageStemHeight2 = null;
    let averageMaleFloweringDay1 = null;
    let averageMaleFloweringDay2 = null;
    let averageFlowerDay1 = null;
    let averageFlowerDay2 = null;

    let combinedChart;

    $("#applyFiltersBtn").click(function () {
        var first_corn_variety1 = $("#filterBreedA1").val();
        var second_corn_variety1 = $("#filterBreedB1").val();
        var version1 = $("#version1").val();

        var first_corn_variety2 = $("#filterBreedA2").val();
        var second_corn_variety2 = $("#second_corn_variety2").val();
        var version2 = $("#version2").val();

        // Ajax request for table 1
        if (first_corn_variety1 || second_corn_variety1 || version1) {
            $.ajax({
                type: "POST",
                url: "retrieveData.php",
                data: {
                    first_corn_variety: first_corn_variety1,
                    second_corn_variety: second_corn_variety1,
                    version: version1
                },
                success: function (response) {
                    $("#tableBody1").html(response.tableHtml);
                    averageFruitHeight1 = parseFloat(response.averageFruitHeight);
                    averageStemHeight1 = parseFloat(response.averageStemHeight);
                    averageMaleFloweringDay1 = parseFloat(response.averageMaleFloweringDay);
                    averageFlowerDay1 = parseFloat(response.averageFlowerDay);
                    updateCombinedChart(
                        first_corn_variety1 + " & " + second_corn_variety1 + " (v" + version1 + ")",
                        first_corn_variety2 + " & " + second_corn_variety2 + " (v" + version2 + ")"
                    );
                },
                error: function (xhr, status, error) {
                    console.error("Error occurred while fetching data for Table 1:", error);
                }
            });
        }

        // Ajax request for table 2
        if (first_corn_variety2 || second_corn_variety2 || version2) {
            $.ajax({
                type: "POST",
                url: "retrieveData.php",
                data: {
                    first_corn_variety: first_corn_variety2,
                    second_corn_variety: second_corn_variety2,
                    version: version2
                },
                success: function (response) {
                    $("#tableBody2").html(response.tableHtml);
                    averageFruitHeight2 = parseFloat(response.averageFruitHeight);
                    averageStemHeight2 = parseFloat(response.averageStemHeight);
                    averageMaleFloweringDay2 = parseFloat(response.averageMaleFloweringDay);
                    averageFlowerDay2 = parseFloat(response.averageFlowerDay);
                    updateCombinedChart(
                        filterBreed1A + " & " + second_corn_variety1 + " (v" + version1 + ")",
                        first_corn_variety2 + " & " + second_corn_variety2 + " (v" + version2 + ")"
                    );
                },
                error: function (xhr, status, error) {
                    console.error("Error occurred while fetching data for Table 2:", error);
                }
            });
        }
    });

    function updateCombinedChart(label1, label2) {

        var labels = ['កម្ពស់ផ្លែ (ជាមធ្យម)', 'កម្ពស់ដើម​ (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាញី​ ៥០% (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% (ជាមធ្យម)'];

        var data = {
            labels: labels,
            datasets: [{
                label: label1 || 'Breed 1', // Dynamically set based on selected Breed 1 and version
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: [
                    averageFruitHeight1 || 0,
                    averageStemHeight1 || 0,
                    averageMaleFloweringDay1 || 0,
                    averageFlowerDay1 || 0
                ]
            },
            {
                label: label2 || 'Breed 2', // Dynamically set based on selected Breed 2 and version
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                data: [
                    averageFruitHeight2 || 0,
                    averageStemHeight2 || 0,
                    averageMaleFloweringDay2 || 0,
                    averageFlowerDay2 || 0
                ]
            }
            ]
        };

        // Check if the chart already exists
        if (combinedChart) {
            combinedChart.data.datasets = data.datasets; // Update the data for all datasets
            combinedChart.update(); // Update the chart
        } else {
            var ctx = document.getElementById('combinedChart').getContext('2d');
            combinedChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            font: {
                                size: 14 // Font size for y-axis labels
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
                                    family: "'Noto Serif Khmer', sans-serif", // Khmer font for legend
                                    weight: 'bold'
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Comparison of Breeds and Versions for Different Metrics',
                            font: {
                                size: 18, // Font size for title
                                family: "'Noto Serif Khmer', sans-serif", // Khmer font for title
                                weight: 'bold'
                            }
                        }
                    }
                }
            });
        }
    }
});