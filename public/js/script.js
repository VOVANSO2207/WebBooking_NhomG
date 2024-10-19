// Model User
function setupDropdown() {
    const userIcon = document.getElementById('userIcon');
    const dropdown = document.getElementById('userDropdown');

    userIcon.addEventListener('click', function () {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Đóng dropdown nếu click ra ngoài
    window.addEventListener('click', function (event) {
        if (!event.target.closest('#userIcon')) {
            dropdown.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', setupDropdown);
