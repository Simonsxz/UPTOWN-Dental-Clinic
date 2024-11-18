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
const rowsPerPage = 4;
let currentPage = 1;

// Sample data for table rows
const tableData = [
    { id: 1, firstName: "Mark", lastName: "Otto", date: "November 18, 2024 | 8:25am" },
    { id: 2, firstName: "Jacob", lastName: "Thornton", date: "November 18, 2024 | 8:25am" },
    { id: 3, firstName: "Larry", lastName: "Bird", date: "November 18, 2024 | 8:25am" },
    { id: 4, firstName: "Tom", lastName: "Smith", date: "November 18, 2024 | 8:25am" },
    { id: 5, firstName: "Jane", lastName: "Doe", date: "November 18, 2024 | 8:25am" },
	{ id: 5, firstName: "Jane", lastName: "Doe", date: "November 18, 2024 | 8:25am" },
	{ id: 5, firstName: "Jane", lastName: "Doe", date: "November 18, 2024 | 8:25am" },
	{ id: 5, firstName: "Jane", lastName: "Doe", date: "November 18, 2024 | 8:25am" },
	{ id: 5, firstName: "Jane", lastName: "Doe", date: "November 18, 2024 | 8:25am" },
	{ id: 5, firstName: "Jane", lastName: "Doe", date: "November 18, 2024 | 8:25am" },
];

// Render table rows
function renderTable() {
    const tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = "";

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    const rows = tableData.slice(start, end);
    rows.forEach(row => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <th scope="row">${row.id}</th>
            <td>${row.firstName}</td>
            <td>${row.lastName}</td>
            <td>${row.date}</td>
            <td>
                <button class="view-button">
                    <i class="fas fa-eye"></i> View
                </button>
            </td>
        `;
        tableBody.appendChild(tr);
    });

    document.getElementById("currentPage").textContent = `Page ${currentPage}`;
}

// Pagination controls
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
}

function nextPage() {
    if (currentPage < Math.ceil(tableData.length / rowsPerPage)) {
        currentPage++;
        renderTable();
    }
}

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






// APEXCHART
var options = {
  series: [{
  name: 'series1',
  data: [31, 40, 28, 51, 42, 109, 100]
}, {
  name: 'series2',
  data: [11, 32, 45, 32, 34, 52, 41]
}],
  chart: {
  height: 350,
  type: 'area'
},
dataLabels: {
  enabled: false
},
stroke: {
  curve: 'smooth'
},
xaxis: {
  type: 'datetime',
  categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
},
tooltip: {
  x: {
    format: 'dd/MM/yy HH:mm'
  },
},
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();