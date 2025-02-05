// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');

allDropdown.forEach(item => {
    const a = item.parentElement.querySelector('a:first-child');
    a.addEventListener('click', function (e) {
        e.preventDefault();

        if (!this.classList.contains('active')) {
            allDropdown.forEach(i => {
                const aLink = i.parentElement.querySelector('a:first-child');
                aLink.classList.remove('active');
                i.classList.remove('show');
            })
        }

        this.classList.toggle('active');
        item.classList.toggle('show');
    })
});


function searchTable() {
    const searchQuery = document.getElementById('tableSearch').value.toLowerCase();
    const rows = Array.from(document.querySelectorAll('#tableBody tr'));

    if (searchQuery.trim() === "") {
        filteredRows = rows; // Show all rows if search is empty
    } else {
        filteredRows = rows.filter(row =>
            Array.from(row.cells).some(cell =>
                cell.textContent.toLowerCase().includes(searchQuery)
            )
        );
    }

    currentPage = 1;
    displayTableRows();
}


// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if (sidebar.classList.contains('hide')) {
    allSideDivider.forEach(item => {
        item.textContent = '-';
    })
    allDropdown.forEach(item => {
        const a = item.parentElement.querySelector('a:first-child');
        a.classList.remove('active');
        item.classList.remove('show');
    })
} else {
    allSideDivider.forEach(item => {
        item.textContent = item.dataset.text;
    })
}

toggleSidebar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');

    if (sidebar.classList.contains('hide')) {
        allSideDivider.forEach(item => {
            item.textContent = '-';
        })

        allDropdown.forEach(item => {
            const a = item.parentElement.querySelector('a:first-child');
            a.classList.remove('active');
            item.classList.remove('show');
        })
    } else {
        allSideDivider.forEach(item => {
            item.textContent = item.dataset.text;
        })
    }
})


let currentPage = 1;
let rowsPerPage = 20; // Default rows per page
let filteredRows = []; // Store filtered rows separately

// Update rows per page based on selection
function updateRowsPerPage() {
    const rowsPerPageValue = document.getElementById('rowsPerPage').value;
    rowsPerPage = rowsPerPageValue === "all" ? Number.MAX_VALUE : parseInt(rowsPerPageValue, 10);
    currentPage = 1; // Reset to the first page
    displayTableRows();
}

// Search function
function searchTable() {
    const searchQuery = document.getElementById('tableSearch').value.toLowerCase();
    const rows = Array.from(document.querySelectorAll('#tableBody tr'));

    if (searchQuery.trim() === "") {
        filteredRows = rows; // Show all rows if search is empty
    } else {
        filteredRows = rows.filter(row =>
            Array.from(row.cells).some(cell =>
                cell.textContent.toLowerCase().includes(searchQuery)
            )
        );
    }

    currentPage = 1; // Reset to first page when searching
    displayTableRows();
}

// Display table rows based on pagination and filtering
function displayTableRows() {
    const rows = filteredRows.length > 0 ? filteredRows : Array.from(document.querySelectorAll('#tableBody tr'));
    const totalRows = rows.length;

    // Hide all rows initially
    document.querySelectorAll('#tableBody tr').forEach(row => row.style.display = 'none');

    // Determine the range of rows to display
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const visibleRows = rows.slice(start, end);

    // Show only the relevant rows
    visibleRows.forEach(row => row.style.display = '');

    renderPagination(totalRows);
    updateEntriesInfo(totalRows, visibleRows.length);
}

// Attach search function to input event
document.getElementById('tableSearch').addEventListener('input', searchTable);

// Initialize event listeners on page load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('rowsPerPage').addEventListener('change', updateRowsPerPage);
    filteredRows = Array.from(document.querySelectorAll('#tableBody tr')); // Initialize filtered rows with all rows
    displayTableRows();
});


// Render pagination controls
function renderPagination(totalRows) {
    const paginationContainer = document.getElementById('pageNumbers');
    paginationContainer.innerHTML = ''; // Clear previous pagination

    if (rowsPerPage === Number.MAX_VALUE) {
        return; // No pagination needed if "All" is selected
    }

    const totalPages = Math.ceil(totalRows / rowsPerPage);
    const maxVisibleButtons = 5; // Limit visible pagination buttons

    if (totalPages <= 1) return; // Hide pagination if only one page

    function createPageButton(pageNumber, isActive = false) {
        const pageButton = document.createElement('button');
        pageButton.textContent = pageNumber;
        pageButton.className = isActive ? 'active' : '';
        pageButton.onclick = () => {
            currentPage = pageNumber;
            displayTableRows();
        };
        return pageButton;
    }

    paginationContainer.appendChild(createPageButton(1, currentPage === 1));

    if (currentPage > 3) {
        const dots = document.createElement('span');
        dots.textContent = "...";
        paginationContainer.appendChild(dots);
    }

    let startPage = Math.max(2, currentPage - 2);
    let endPage = Math.min(totalPages - 1, currentPage + 2);

    for (let i = startPage; i <= endPage; i++) {
        paginationContainer.appendChild(createPageButton(i, i === currentPage));
    }

    if (currentPage < totalPages - 2) {
        const dots = document.createElement('span');
        dots.textContent = "...";
        paginationContainer.appendChild(dots);
    }

    paginationContainer.appendChild(createPageButton(totalPages, currentPage === totalPages));

    paginationContainer.style.display = 'flex'; // Ensure pagination is displayed correctly
    paginationContainer.style.flexWrap = 'wrap'; // Prevent overlap when too many pages
}

// Update entries information text
function updateEntriesInfo(totalRows, visibleRowsCount) {
    const entriesInfo = document.getElementById('entriesInfo');
    entriesInfo.textContent = `Showing ${Math.min(visibleRowsCount, rowsPerPage)} of ${totalRows} entries`;
}

// Initialize event listeners on page load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('rowsPerPage').addEventListener('change', updateRowsPerPage);
    displayTableRows();
});



function submitAddPatientForm(event) {
    if (event) event.preventDefault(); // Prevent default form submission behavior

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to add this new user?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add user',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gather form data
            const form = document.getElementById("addPatientForm");
            const formData = new FormData(form);

            // Send data to the server
            fetch('../functions/patient_add.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(result => {
                // Display success or error message
                return Swal.fire({
                    title: 'Response',
                    text: result,
                    icon: result.includes('successfully') ? 'success' : 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (result.includes('successfully')) {
                        // Reload the page after the user acknowledges success
                        location.reload();
                    }
                });
            })
            .catch(error => {
                // Handle errors gracefully
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error:', error);
            });
        }
    });
}


document.getElementById('cancelButton').addEventListener('click', () => {
    const form = document.getElementById('addUserForm');
    form.reset(); // Clears all input fields in the form
});



