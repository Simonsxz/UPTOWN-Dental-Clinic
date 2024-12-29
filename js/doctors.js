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
})


// Search functionality
document.querySelector(".search-button").addEventListener("click", () => {
    const searchTerm = document.getElementById("tableSearch").value.toLowerCase();
    const filteredData = tableData.filter(row =>
        row.firstName.toLowerCase().includes(searchTerm) ||
        row.lastName.toLowerCase().includes(searchTerm) ||
        row.date.toLowerCase().includes(searchTerm)
    );

    tableData.length = 0; // Clear tableData and refill with filtered data
    Array.prototype.push.apply(tableData, filteredData);
    currentPage = 1;
    renderTable(tableData);
});

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


  document.getElementById("togglePassword").addEventListener("click", function () {
	const passwordInput = document.getElementById("password");
	const eyeIcon = document.getElementById("eyeIcon");
	if (passwordInput.type === "password") {
	  passwordInput.type = "text";
	  eyeIcon.classList.replace("bi-eye", "bi-eye-slash");
	} else {
	  passwordInput.type = "password";
	  eyeIcon.classList.replace("bi-eye-slash", "bi-eye");
	}
  });
  



sidebar.addEventListener('mouseleave', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})
	}
})



sidebar.addEventListener('mouseenter', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




// PROFILE DROPDOWN
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');

imgProfile.addEventListener('click', function () {
	dropdownProfile.classList.toggle('show');
})




// MENU
const allMenu = document.querySelectorAll('main .content-data .head .menu');

allMenu.forEach(item=> {
	const icon = item.querySelector('.icon');
	const menuLink = item.querySelector('.menu-link');

	icon.addEventListener('click', function () {
		menuLink.classList.toggle('show');
	})
})



window.addEventListener('click', function (e) {
	if(e.target !== imgProfile) {
		if(e.target !== dropdownProfile) {
			if(dropdownProfile.classList.contains('show')) {
				dropdownProfile.classList.remove('show');
			}
		}
	}

	allMenu.forEach(item=> {
		const icon = item.querySelector('.icon');
		const menuLink = item.querySelector('.menu-link');

		if(e.target !== icon) {
			if(e.target !== menuLink) {
				if (menuLink.classList.contains('show')) {
					menuLink.classList.remove('show')
				}
			}
		}
	})
})

let currentPage = 1;
let rowsPerPage = 3; // Default rows per page
let filteredRows = []; // For search functionality

// Update rows per page
function updateRowsPerPage() {
    const rowsPerPageValue = document.getElementById('rowsPerPage').value;
    rowsPerPage = rowsPerPageValue === "all" ? Number.MAX_VALUE : parseInt(rowsPerPageValue, 10);
    currentPage = 1; // Reset to the first page
    displayTableRows();
}

// Search table rows
function searchTable() {
    const searchQuery = document.getElementById('tableSearch').value.toLowerCase();
    const rows = Array.from(document.querySelectorAll('#tableBody tr'));

    // Filter rows based on search query
    filteredRows = rows.filter(row =>
        Array.from(row.cells).some(cell =>
            cell.textContent.toLowerCase().includes(searchQuery)
        )
    );

    currentPage = 1; // Reset to the first page
    displayTableRows();
}

// Display rows based on pagination and filtering
function displayTableRows() {
    const rows = filteredRows.length > 0 ? filteredRows : Array.from(document.querySelectorAll('#tableBody tr'));
    const totalRows = rows.length;

    // Pagination logic
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const end = currentPage * rowsPerPage;

    // Show or hide rows
    Array.from(document.querySelectorAll('#tableBody tr')).forEach(row => (row.style.display = 'none'));
    rows.slice(start, end).forEach(row => (row.style.display = ''));

    renderPagination(totalPages);
    updateEntriesInfo(totalRows, rows.length);
}

// Render pagination
function renderPagination(totalPages) {
    const paginationContainer = document.getElementById('pageNumbers');
    paginationContainer.innerHTML = ''; // Clear previous pagination

    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        pageButton.className = i === currentPage ? 'active' : '';
        pageButton.onclick = () => {
            currentPage = i;
            displayTableRows();
        };
        paginationContainer.appendChild(pageButton);
    }
}

// Update entries information text
function updateEntriesInfo(totalRowsCount, visibleRowsCount) {
    const entriesInfo = document.getElementById('entriesInfo');
    entriesInfo.textContent = `Showing ${Math.min(
        visibleRowsCount,
        rowsPerPage * currentPage
    )} of ${totalRowsCount} entries`;
}

// Initialize search functionality on page load
document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners
    document.getElementById('tableSearch').addEventListener('input', searchTable);
    document.getElementById('rowsPerPage').addEventListener('change', updateRowsPerPage);

    // Initialize display
    displayTableRows();
});


// PROGRESSBAR
const allProgress = document.querySelectorAll('main .card .progress');

allProgress.forEach(item=> {
	item.style.setProperty('--value', item.dataset.value)
})


function submitAddUserForm() {
    // Display confirmation alert
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
            const formData = new FormData(document.getElementById("addUserForm"));

            // Send data to the server
            fetch('../functions/function.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(result => {
                // Display success or error message
                Swal.fire({
                    title: 'Response',
                    text: result,
                    icon: result.includes('successfully') ? 'success' : 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (result.includes('successfully')) {
                        // Optional: Reload or close modal
                        location.reload(); // Reload the page
                    }
                });
            })
            .catch(error => {
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





