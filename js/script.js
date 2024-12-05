// Disable Form Resubmition
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
const spans = document.querySelectorAll('.progress-bar span');

spans.forEach((span) => {
  span.style.width = span.dataset.width;
  span.innerHTML = span.dataset.width;
});

// JavaScript for Sidebar Collapse
const sidebar = document.getElementById('sidebar');
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');

// Function to handle sidebar state based on screen size
function handleSidebarState() {
  if (window.innerWidth <= 768) { // Adjust the breakpoint as needed
    sidebar.classList.add('hide');
    allSideDivider.forEach(item => {
      item.textContent = '-';
    });
    allDropdown.forEach(item => {
      const a = item.parentElement.querySelector('a:first-child');
      a.classList.remove('active');
      item.classList.remove('show');
    });
  } else {
    sidebar.classList.remove('hide');
    allSideDivider.forEach(item => {
      item.textContent = item.dataset.text;
    });
  }
}

// Initial setup to ensure sidebar is initially collapsed
handleSidebarState();

// Event listener for window resize
window.addEventListener('resize', handleSidebarState);

// Event listener for toggling sidebar
toggleSidebar.addEventListener('click', function () {
  sidebar.classList.toggle('hide');

  if (sidebar.classList.contains('hide')) {
    allSideDivider.forEach(item => {
      item.textContent = '-';
    });
    allDropdown.forEach(item => {
      const a = item.parentElement.querySelector('a:first-child');
      a.classList.remove('active');
      item.classList.remove('show');
    });
  } else {
    allSideDivider.forEach(item => {
      item.textContent = item.dataset.text;
    });
  }
});

sidebar.addEventListener('mouseleave', function () {
  if (sidebar.classList.contains('hide')) {
    allDropdown.forEach(item => {
      const a = item.parentElement.querySelector('a:first-child');
      a.classList.remove('active');
      item.classList.remove('show');
    });
    allSideDivider.forEach(item => {
      item.textContent = '-';
    });
  }
});

sidebar.addEventListener('mouseenter', function () {
  if (sidebar.classList.contains('hide')) {
    allDropdown.forEach(item => {
      const a = item.parentElement.querySelector('a:first-child');
      a.classList.remove('active');
      item.classList.remove('show');
    });
    allSideDivider.forEach(item => {
      item.textContent = item.dataset.text;
    });
  }
});


// Profile Dropdown
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');

imgProfile.addEventListener('click', function () {
	dropdownProfile.classList.toggle('show');
})

// Menu
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
});
	 
//Animals Tabbed Interface
function showTab(tabId) {
	// Hide all tab contents
	var tabContents = document.querySelectorAll('.tab-content');
	tabContents.forEach(function(tabContent) {
		tabContent.style.display = 'none';
	});

	// Show the selected tab content
	var selectedTab = document.getElementById(tabId);
	if (selectedTab) {
		selectedTab.style.display = 'block';
	}

	var tabs = document.querySelectorAll('.t-tab');
    tabs.forEach(function(tab) {
        tab.classList.remove('green-border');
    });

    // Add the green border to the clicked li element
    var selectedTab = document.querySelector('[onclick="showTab(\'' + tabId + '\')"]');
    selectedTab.classList.add('green-border');

    // Add your logic to show the corresponding tab content here
};

window.onload = function() {
    showTab('fa-tab');
};

const changeEmailBtn = document.getElementById("changeEmailBtn");
const editEmailForm = document.getElementById("editEmailForm");

changeEmailBtn.addEventListener("click", function() {
    if (editEmailForm.style.display === "none" || editEmailForm.style.display === "") {
        editEmailForm.style.display = "block";
    } else {
        editEmailForm.style.display = "none";
    }
});

const changeContactBtn = document.getElementById("changeContactBtn");
const editContactForm = document.getElementById("editContactForm");

changeContactBtn.addEventListener("click", function() {
    if (editContactForm.style.display === "none" || editContactForm.style.display === "") {
        editContactForm.style.display = "block";
    } else {
        editContactForm.style.display = "none";
    }
});

const addAddressButton = document.getElementById("addAddressButton");
const addAddressForm = document.getElementById("addAddressForm");


addAddressButton.addEventListener("click", function() {
    if (addAddressForm.style.display === "none" || addAddressForm.style.display === "") {
        addAddressForm.style.display = "block";
    } else {
        addAddressForm.style.display = "none";
    }
});

$(document).ready(function(){
    $('#imageModal').on('show.bs.modal', function (e) {
        // Add your desired effects when the modal is about to be shown
        console.log('Modal is about to be shown');
    });

    $('#imageModal').on('shown.bs.modal', function (e) {
        // Add your desired effects when the modal is fully shown
        console.log('Modal is fully shown');
    });

    $('#imageModal').on('hide.bs.modal', function (e) {
        // Add your desired effects when the modal is about to be hidden
        console.log('Modal is about to be hidden');
    });

    $('#imageModal').on('hidden.bs.modal', function (e) {
        // Add your desired effects when the modal is fully hidden
        console.log('Modal is fully hidden');
    });
});
