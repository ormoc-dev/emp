document.addEventListener("DOMContentLoaded", function () {
    const dropdownButton = document.getElementById("dropdown-menu");

    // Ensure the dropdown button exists before attaching an event listener
    if (dropdownButton) {
        dropdownButton.addEventListener("click", function () {
            const dropdownMenu = document.querySelector(".origin-top-right");
            dropdownMenu.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            const dropdownMenu = document.querySelector(".origin-top-right");
            if (
                !dropdownButton.contains(event.target) &&
                !dropdownMenu.contains(event.target)
            ) {
                dropdownMenu.classList.add("hidden");
            }
        });
    } else {
        console.error("Dropdown button with ID 'dropdown-menu' not found.");
    }
});

function toggleDropdown() {
    var dropdown = document.getElementById("dropdownMenu");
    if (dropdown) {
        dropdown.classList.toggle("hidden");
    } else {
        console.error("Dropdown menu with ID 'dropdownMenu' not found.");
    }
}

function logoutFunction() {
    // Add your logout logic here
    console.log("Logout clicked! Add your logout logic.");
}
