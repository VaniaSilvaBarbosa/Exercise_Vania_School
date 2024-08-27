// Add script after the DOM has loaded
document.addEventListener('DOMContentLoaded', function () {
    // Get the search input element
    const input = document.getElementById('search-input');
    // Get the table element
    const table = document.querySelector('.students-table-section--table tbody');
    // Get all the rows in the table
    const rows = table.getElementsByTagName('tr');

    // Add event listener for input changes
    input.addEventListener('input', function () {
        const filter = input.value.toLowerCase();

        // Loop through each row in the table
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            // Get all the cells in the current row
            const cells = row.getElementsByTagName('td');
            let shouldShow = false;

            // Loop through each cell in the row
            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                // Check if the cell exists
                if (cell) {
                    const text = cell.textContent.toLowerCase();
                    // Check if the cell text contains the filter
                    if (text.indexOf(filter) > -1) {
                        shouldShow = true;
                        break;
                    }
                }
            }

            // Show or hide the row based on the filter
            if (shouldShow) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
