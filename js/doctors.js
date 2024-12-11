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

// Fetch data from the server and render it in the table
function fetchData() {
    fetch('../functions/fetch_users.php')
        .then(response => response.json())
        .then(data => {
            // Check if data is valid and render it
            if (Array.isArray(data)) {
                tableData = data; // Store the fetched data in the global variable
                renderTable(tableData);
            } else {
                console.error('Failed to fetch data or no data found');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Call fetchData on page load
document.addEventListener('DOMContentLoaded', fetchData);


// Global variable to store the fetched data
let tableData = [];

// Rows per page and current page settings
let rowsPerPage = 3; // Default rows per page
let currentPage = 1;

// Render table rows
// Render table rows using innerHTML
function renderTable(data) {
    const tableBody = document.getElementById("tableBody");
    let tableRows = ""; // Initialize an empty string to hold the table rows

    const start = (currentPage - 1) * rowsPerPage;
    const end = rowsPerPage === "all" ? data.length : Math.min(currentPage * rowsPerPage, data.length);
    const paginatedData = data.slice(start, end);

    // Build table rows as a string
    paginatedData.forEach(row => {
        tableRows += `
            <tr>
                <th scope="row">${row.id}</th>
                <td>${row.user_ID}</td>
                <td>${row.user_fName}</td>
                <td>${row.user_lName}</td>
                <td>${row.user_role}</td>
                <td>${row.user_created}</td>
                <td>
                    <button class="action-button view-button1" title="View Details"><i class="fas fa-eye"></i></button>
                    <button class="action-button edit-button" title="Edit Details"><i class="fas fa-edit"></i></button>
                    <button class="action-button delete-button" title="Delete Record"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        `;
    });

    // Set the innerHTML of the table body to the constructed string
    tableBody.innerHTML = tableRows;

    renderPagination(data); // Ensure this function is defined elsewhere if needed
    updateEntriesInfo(data); // Ensure this function is defined elsewhere if needed
}



// Fetch data from PHP and render it
document.addEventListener('DOMContentLoaded', function() {
    fetch('doctors.php') // Replace 'your_php_script.php' with the actual PHP file that provides the JSON data
        .then(response => response.json())
        .then(data => {
            renderTable(data);
        })
        .catch(error => console.error('Error fetching data:', error));
});


// Render pagination controls
function renderPagination(data) {
    const pageNumbers = document.getElementById("pageNumbers");
    pageNumbers.innerHTML = "";

    const totalPages = rowsPerPage === "all" ? 1 : Math.ceil(data.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const page = document.createElement("div");
        page.className = `page-number ${i === currentPage ? "active" : ""}`;
        page.textContent = i;
        page.onclick = () => goToPage(i);
        pageNumbers.appendChild(page);
    }
}

// Update "Showing X to Y of Z entries" text
function updateEntriesInfo(data) {
    const entriesInfo = document.getElementById("entriesInfo");
    const totalEntries = data.length;
    const start = rowsPerPage === "all" ? 1 : (currentPage - 1) * rowsPerPage + 1;
    const end = rowsPerPage === "all" ? totalEntries : Math.min(currentPage * rowsPerPage, totalEntries);

    entriesInfo.textContent = `Showing ${start} to ${end} of ${totalEntries} entries`;
}

// Go to a specific page
function goToPage(page) {
    currentPage = page;
    fetchData(); // Re-fetch data when page changes
}

// Pagination controls
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        fetchData();
    }
}

function nextPage() {
    const totalPages = rowsPerPage === "all" ? 1 : Math.ceil(tableData.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        fetchData();
    }
}

// Update rows per page
function updateRowsPerPage() {
    const dropdown = document.getElementById("rowsPerPage");
    rowsPerPage = dropdown.value === "all" ? "all" : parseInt(dropdown.value, 10);
    currentPage = 1;
    fetchData();
}

// Initial fetch and render
fetchData();

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


function previewImage() {
	const fileInput = document.getElementById('imageUpload');
	const previewImage = document.getElementById('uploadedImage');
	const noFileText = document.querySelector('.no-file-text');
  
	if (fileInput.files && fileInput.files[0]) {
	  const reader = new FileReader();
	  reader.onload = function (e) {
		previewImage.src = e.target.result;
		previewImage.style.display = 'block';
		noFileText.style.display = 'none'; // Hide "Upload Image" text
	  };
	  reader.readAsDataURL(fileInput.files[0]);
	} else {
	  previewImage.style.display = 'none';
	  noFileText.style.display = 'block'; // Show "Upload Image" text
	}
  }
  
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





