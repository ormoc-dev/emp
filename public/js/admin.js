// Constants
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');
const switchMode = document.getElementById('switch-mode');
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

// Function to set the dark mode based on user preference
function setDarkModePreference(isDarkMode) {
    if (isDarkMode) {
        document.body.classList.add('dark');
        document.body.style.background = 'var(--grey)'; // Set background color
    } else {
        document.body.classList.remove('dark');
        document.body.style.background = ''; // Remove inline background color
    }
}

// Function to get the dark mode preference from local storage
function getDarkModePreference() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    setDarkModePreference(isDarkMode);
    if (switchMode) switchMode.checked = isDarkMode; // Update the switch state
}

// Function to save the dark mode preference to local storage
function saveDarkModePreference(isDarkMode) {
    localStorage.setItem('darkMode', isDarkMode);
}

// Apply dark mode styles on page load
function applyDarkModeStyles() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    setDarkModePreference(isDarkMode);
    if (switchMode) switchMode.checked = isDarkMode;
}

// Event listener for dark mode switch change
if (switchMode) {
    switchMode.addEventListener('change', function () {
        const isDarkMode = this.checked;
        setDarkModePreference(isDarkMode);
        saveDarkModePreference(isDarkMode);
    });
}

// Event listener for window resize
window.addEventListener('resize', function () {
    if (this.innerWidth > 576 && searchButtonIcon && searchForm) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});

// Event listener for page load
window.addEventListener('load', function () {
    applyDarkModeStyles();
});

// Function to handle sidebar state
function toggleSidebar() {
    if (sidebar) {
        const isHidden = sidebar.classList.contains('hide');
        if (isHidden) {
            sidebar.classList.remove('hide');
            localStorage.setItem('sidebarHidden', 'false');
        } else {
            sidebar.classList.add('hide');
            localStorage.setItem('sidebarHidden', 'true');
        }
    }
}

// Set initial sidebar state
function initializeSidebar() {
    if (sidebar) {
        const isHidden = localStorage.getItem('sidebarHidden') === 'true';
        if (isHidden) {
            sidebar.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
        }
    }
}

// Initialize sidebar state immediately when the script loads
initializeSidebar();

// Menu bar click handler
if (menuBar) {
    menuBar.addEventListener('click', function(e) {
        e.preventDefault();
        toggleSidebar();
    });
}

// Usage of collapsible functions
if (allSideMenu.length > 0) {
    allSideMenu.forEach(item => {
        const li = item.parentElement;
        item.addEventListener('click', function () {
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            });
            li.classList.add('active');
        });
    });
}

if (searchButton && searchButtonIcon && searchForm) {
    searchButton.addEventListener('click', function (e) {
        if (window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            if (searchForm.classList.contains('show')) {
                searchButtonIcon.classList.replace('bx-search', 'bx-x');
            } else {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
            }
        }
    });
}

// ⁡⁢⁣⁢Set active class based on local storage on DOMContentLoaded⁡⁡
document.addEventListener('DOMContentLoaded', () => {
    const setActiveClassFromStorage = () => {
        const activePath = localStorage.getItem('activePath');
        if (activePath) {
            document.querySelectorAll('#sidebar-menu li').forEach(item => {
                const link = item.querySelector('a');
                if (link && link.getAttribute('href') === activePath) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }
    };

    setActiveClassFromStorage();

    const sidebarMenu = document.getElementById('sidebar-menu');
    if (sidebarMenu) {
        sidebarMenu.addEventListener('click', event => {
            if (event.target.tagName === 'A' || event.target.closest('a')) {
                const clickedLink = event.target.tagName === 'A' ? event.target : event.target.closest('a');
                const clickedPath = clickedLink.getAttribute('href');
                localStorage.setItem('activePath', clickedPath);
                document.querySelectorAll('#sidebar-menu li').forEach(item => item.classList.remove('active'));
                clickedLink.parentElement.classList.add('active');
            }
        });
    }

// Function to handle link clicks with loading animation
function handleLinkClick(linkId) {
    document.getElementById(linkId).addEventListener('click', function(event) {
        event.preventDefault();
        const spinner = document.getElementById('loading-animation');
        spinner.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            window.location.href = this.href;
        }, 1000);
    });
}

// Apply the click handler to all navigation links
['dashboard', 'management', 'start_event', 'result', 'users'].forEach(id => {
    handleLinkClick(`${id}-link`);
});

// Hide spinner on page load
window.addEventListener('load', function() {
    const spinner = document.getElementById('loading-animation');
    spinner.style.display = 'none';
    document.body.style.overflow = '';
});
});
