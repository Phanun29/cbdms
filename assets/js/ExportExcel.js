function exportToExcel() {
    // Create a new HTML table for export
    var exportTable = document.createElement('table');
    var exportTableBody = document.createElement('tbody');

    // Get the header row from the HTML table
    var headerRow = document.querySelector('#tableForExport thead tr');
    var columnCount = headerRow.querySelectorAll('th').length; // Get column count for colspan

    // Add the title row "CORN BREEDING DATA" with dynamic colspan
    var titleRow = document.createElement('tr');
    var titleCell = document.createElement('td');
    titleCell.textContent = "បញ្ជីទិន្នន័យបង្កាត់ពូជពោត";

    // Set styles for the title
    titleCell.colSpan = columnCount; // Set colspan equal to number of columns
    titleCell.style.backgroundColor = '#FFFFFF';
    titleCell.style.color = '#000000';
    titleCell.style.border = '1px solid black';
    titleCell.style.textAlign = 'center';
    titleCell.style.fontFamily = 'Battambang';
    titleCell.style.fontSize = '30px';

    titleRow.appendChild(titleCell);
    exportTableBody.appendChild(titleRow);

    // Create and style the header row
    var exportHeaderRow = document.createElement('tr');
    headerRow.querySelectorAll('th').forEach(function (cell) {
        var exportCell = document.createElement('td');
        exportCell.textContent = cell.textContent;
        exportCell.style.backgroundColor = '#185519';
        exportCell.style.color = '#FFFFFF';
        exportCell.style.border = '1px solid black';
        exportCell.style.textAlign = 'center';
        exportCell.style.fontFamily = 'Battambang';
        exportHeaderRow.appendChild(exportCell);
    });
    exportTableBody.appendChild(exportHeaderRow);

    // Iterate over each row and add data
    document.querySelectorAll('#tableForExport tbody tr').forEach(function (row) {
        var exportRow = document.createElement('tr');
        row.querySelectorAll('td').forEach(function (cell) {
            var exportCell = document.createElement('td');
            exportCell.textContent = cell.textContent;
            exportCell.style.border = '1px solid black';
            exportCell.style.textAlign = 'left';
            exportCell.style.padding = '5px';
            exportCell.style.fontFamily = 'Khmer OS Battambang';
            exportRow.appendChild(exportCell);
        });
        exportTableBody.appendChild(exportRow);
    });

    // Append the table body to the export table
    exportTable.appendChild(exportTableBody);

    // Create and download the Excel file
    var blob = new Blob(['\ufeff', exportTable.outerHTML], { type: 'application/vnd.ms-excel' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = url;
    a.download = "corn_breeding_data.xls";
    document.body.appendChild(a);
    a.click();

    setTimeout(function () {
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }, 0);
}
