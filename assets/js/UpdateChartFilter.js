$(document).ready(function () {
    let averages1 = {};
    let averages2 = {};
    let combinedChart;

    $("#applyFiltersBtn").click(function () {
        const first_corn_variety1 = $("#filterBreedA1").val();
        const second_corn_variety1 = $("#filterBreedB1").val();
        const version1 = $("#version1").val();

        const first_corn_variety2 = $("#filterBreedA2").val();
        const second_corn_variety2 = $("#filterBreedB2").val();
        const version2 = $("#version2").val();

        // Fetch names for both sets of varieties
        const requestData = {
            ids: [first_corn_variety1, second_corn_variety1, first_corn_variety2, second_corn_variety2]
        };

        $.ajax({
            type: "POST",
            url: "getVarietyNames.php",
            data: requestData,
            dataType: "json",
            success: function (namesResponse) {
                const label1 = `${namesResponse[first_corn_variety1]} & ${namesResponse[second_corn_variety1]} (${version1})`;
                const label2 = `${namesResponse[first_corn_variety2]} & ${namesResponse[second_corn_variety2]} (${version2})`;

                // Request data for Table 1
                if (first_corn_variety1 || second_corn_variety1 || version1) {
                    requestTableData(
                        "retrieveDataForCompare.php",
                        first_corn_variety1,
                        second_corn_variety1,
                        version1,
                        "#tableBody1",
                        (response) => {
                            averages1 = parseAverages(response);
                            updateCombinedChart(label1, label2);
                        }
                    );
                }

                // Request data for Table 2
                if (first_corn_variety2 || second_corn_variety2 || version2) {
                    requestTableData(
                        "retrieveDataForCompare.php",
                        first_corn_variety2,
                        second_corn_variety2,
                        version2,
                        "#tableBody2",
                        (response) => {
                            averages2 = parseAverages(response);
                            updateCombinedChart(label1, label2);
                        }
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching variety names:", error);
            }
        });
    });

    function requestTableData(url, varietyA, varietyB, version, tableSelector, callback) {
        $.ajax({
            type: "POST",
            url: url,
            data: { first_corn_variety: varietyA, second_corn_variety: varietyB, version: version },
            success: function (response) {
                $(tableSelector).html(response.tableHtml);
                callback(response);
            },
            error: function (xhr, status, error) {
                console.error("Error occurred while fetching table data:", error);
            }
        });
    }

    function parseAverages(response) {
        const averages = {};
        for (const key in response) {
            if (key.startsWith("average")) {
                const metric = key.replace("average", "").trim();
                averages[metric] = parseFloat(response[key]);
            }
        }
        return averages;
    }

    function updateCombinedChart(label1, label2) {
        const labels = Object.keys(averages1); // Dynamically set labels based on metrics

        const data = {
            labels: labels,
            datasets: [
                {
                    label: label1 || "Breed 1",
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    data: Object.values(averages1)
                },
                {
                    label: label2 || "Breed 2",
                    backgroundColor: "rgba(153, 102, 255, 0.2)",
                    borderColor: "rgba(153, 102, 255, 1)",
                    data: Object.values(averages2)
                }
            ]
        };

        if (combinedChart) {
            combinedChart.data = data; // Update data dynamically
            combinedChart.update();
        } else {
            const ctx = document.getElementById("combinedChart").getContext("2d");
            combinedChart = new Chart(ctx, {
                type: "bar",
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16,
                                    family: "'Noto Serif Khmer', sans-serif",
                                    weight: "bold"
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: "Comparison of Breeds and Versions for Different Metrics",
                            font: {
                                size: 18,
                                family: "'Noto Serif Khmer', sans-serif",
                                weight: "bold"
                            }
                        }
                    }
                }
            });
        }
    }
});
