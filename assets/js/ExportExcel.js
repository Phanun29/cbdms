function exportToExcel() {
    // Create a new HTML table with only the relevant columns
    var exportTable = document.createElement('table');
    var exportTableBody = document.createElement('tbody');

    // Add the title row "CORN BREEDING DATA"
    var titleRow = document.createElement('tr');
    var titleCell = document.createElement('td');
    titleCell.textContent = "បញ្ជីទិន្នន័យបង្កាត់ពូជពោត";

    // Set styles for the title
    titleCell.colSpan = 38; // Adjust this according to the number of columns
    titleCell.style.backgroundColor = '#FFFFFF'; // Green background
    titleCell.style.color = '#000000'; // White text
    titleCell.style.border = '1px solid black'; // Border
    titleCell.style.textAlign = 'center'; // Center alignment
    titleCell.style.fontFamily = 'Battambang'; // Khmer font
    titleCell.style.fontSize = '30px'; // Larger font for the title
    titleRow.appendChild(titleCell);

    // Append the title row to the table body
    exportTableBody.appendChild(titleRow);

    // Get the header row from the HTML table
    var headerRow = document.querySelector('#tableForExport thead tr');

    // Create a new row for the export table and add the header cells with custom styles
    var exportHeaderRow = document.createElement('tr');
    headerRow.querySelectorAll('th').forEach(function(cell) {
        var exportCell = document.createElement('td');
        exportCell.textContent = cell.textContent;

        // Add styles for header (green background, white text, font-family)
        exportCell.style.backgroundColor = '#185519'; // Green background
        exportCell.style.color = '#FFFFFF'; // White text
        exportCell.style.border = '1px solid black'; // Border
        exportCell.style.textAlign = 'center'; // Center alignment
        exportCell.style.fontFamily = 'Battambang'; // Khmer font
        exportHeaderRow.appendChild(exportCell);
    });
    exportTableBody.appendChild(exportHeaderRow);

    // Iterate over each row of the HTML table and add the data rows
    var tableRows = document.querySelectorAll('#tableForExport tbody tr');
    tableRows.forEach(function(row) {
        // Create a new row for the export table
        var exportRow = document.createElement('tr');

        // Iterate over each cell of the row and create corresponding cells in the export table
        row.querySelectorAll('td').forEach(function(cell) {
            var exportCell = document.createElement('td');
            exportCell.textContent = cell.textContent;

            // Add styles for the data cells
            exportCell.style.border = '1px solid black'; // Border
            exportCell.style.textAlign = 'left'; // Left alignment
            exportCell.style.padding = '5px'; // Padding to add some space
            exportCell.style.fontFamily = 'Khmer OS Battambang'; // Khmer font
            exportRow.appendChild(exportCell);
        });

        // Append the row to the export table body
        exportTableBody.appendChild(exportRow);
    });

    // Append the table body to the export table
    exportTable.appendChild(exportTableBody);

    // Create a Blob object containing the HTML table
    var blob = new Blob(['\ufeff', exportTable.outerHTML], {
        type: 'application/vnd.ms-excel'
    });

    // Create a link element to download the Blob
    var url = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = url;
    a.download = "data_corn.xls";
    document.body.appendChild(a);
    a.click();

    // Cleanup
    setTimeout(function() {
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }, 0);
}