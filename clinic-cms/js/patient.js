// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');

allDropdown.forEach(item=> {
	const a = item.parentElement.querySelector('a:first-child');
	a.addEventListener('click', function (e) {
		e.preventDefault();

		if(!this.classList.contains('active')) {
			allDropdown.forEach(i=> {
				const aLink = i.parentElement.querySelector('a:first-child');

				aLink.classList.remove('active');
				i.classList.remove('show');
			})
		}

		this.classList.toggle('active');
		item.classList.toggle('show');
	})
})

// Doctors List
let rowsPerPage = 3; // Default rows per page
let currentPage = 1;

// Sample data for table rows
const tableData = [
    { id: 1, firstName: "Mark", lastName: "Otto", role: "Admin", created: "November 18, 2024 | 8:25am" },
    { id: 2, firstName: "Jacob", lastName: "Thornton",  role: "User",  created: "November 18, 2024 | 8:25am" },
    { id: 3, firstName: "Larry", lastName: "Bird",  role: "User",  created: "November 18, 2024 | 8:25am" },
    { id: 4, firstName: "Tom", lastName: "Smith",  role: "User",  created: "November 18, 2024 | 8:25am" },
    { id: 5, firstName: "Jane", lastName: "Doe",  role: "User",  created: "November 18, 2024 | 8:25am" },
    { id: 6, firstName: "Mike", lastName: "Johnson",  role: "User",  created: "November 18, 2024 | 8:25am" },
    { id: 7, firstName: "Emily", lastName: "Clark",  role: "uUser",  created: "November 18, 2024 | 8:25am" },
];

// Render table rows
function renderTable() {
    const tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = "";

    let data = tableData;
    if (rowsPerPage !== "all") {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        data = tableData.slice(start, end);
    }

    data.forEach(row => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <th scope="row">${row.id}</th>
            <td>${row.firstName}</td>
            <td>${row.lastName}</td>
            <td>${row.created}</td>
            <td>
				<!-- View Button with Tooltip -->
				<button class="action-button view-button1" title="View Details">
					<i class="fas fa-eye"></i> 
				</button>

				<!-- Edit Button with Tooltip -->
				<button class="action-button edit-button" title="Edit Details">
					<i class="fas fa-edit"></i> 
				</button>

				<!-- Delete Button with Tooltip -->
				<button class="action-button delete-button" title="Delete Record">
					<i class="fas fa-trash-alt"></i>
				</button>
			</td>


        `;
        tableBody.appendChild(tr);
    });

    renderPagination();
    updateEntriesInfo();
}

// Render pagination controls
function renderPagination() {
    const pageNumbers = document.getElementById("pageNumbers");
    pageNumbers.innerHTML = "";

    const totalPages = rowsPerPage === "all" ? 1 : Math.ceil(tableData.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const page = document.createElement("div");
        page.className = `page-number ${i === currentPage ? "active" : ""}`;
        page.textContent = i;
        page.onclick = () => goToPage(i);
        pageNumbers.appendChild(page);
    }
}

// Update "Showing X to Y of Z entries" text
function updateEntriesInfo() {
    const entriesInfo = document.getElementById("entriesInfo");

    const totalEntries = tableData.length;
    const start = rowsPerPage === "all" ? 1 : (currentPage - 1) * rowsPerPage + 1;
    const end = rowsPerPage === "all" ? totalEntries : Math.min(currentPage * rowsPerPage, totalEntries);

    entriesInfo.textContent = `Showing ${start} to ${end} of ${totalEntries} entries`;
}

// Go to a specific page
function goToPage(page) {
    currentPage = page;
    renderTable();
}

// Pagination controls
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
}

function nextPage() {
    const totalPages = rowsPerPage === "all" ? 1 : Math.ceil(tableData.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
    }
}

// Update rows per page
function updateRowsPerPage() {
    const dropdown = document.getElementById("rowsPerPage");
    rowsPerPage = dropdown.value === "all" ? "all" : parseInt(dropdown.value, 10);
    currentPage = 1;
    renderTable();
}

// Initialize table
renderTable();


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
    renderTable();
});

// Initialize table
renderTable();





// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if(sidebar.classList.contains('hide')) {
	allSideDivider.forEach(item=> {
		item.textContent = '-'
	})
	allDropdown.forEach(item=> {
		const a = item.parentElement.querySelector('a:first-child');
		a.classList.remove('active');
		item.classList.remove('show');
	})
} else {
	allSideDivider.forEach(item=> {
		item.textContent = item.dataset.text;
	})
}

toggleSidebar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');

	if(sidebar.classList.contains('hide')) {
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})

		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
	} else {
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




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






