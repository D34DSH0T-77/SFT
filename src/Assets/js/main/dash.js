document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }

    // Optional: Auto-collapse on small screens
    const checkScreenSize = () => {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    };

    // Initial check
    checkScreenSize();

    // Check on resize
    window.addEventListener('resize', checkScreenSize);
});
