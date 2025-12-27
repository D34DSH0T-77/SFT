document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');

    function applySidebarState() {
        if (!sidebar) return;

        sidebar.classList.add('no-transition');

        const savedState = localStorage.getItem('sidebarState');

        const isPreCollapsed = document.documentElement.classList.contains('sidebar-is-collapsed');

        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
        } else {
            if (savedState === 'collapsed' || isPreCollapsed) {
                sidebar.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
            }
        }

        void sidebar.offsetWidth;

        document.documentElement.classList.remove('sidebar-is-collapsed');

        setTimeout(() => {
            sidebar.classList.remove('no-transition');
        }, 100);
    }

    applySidebarState();

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        });
    }

    window.addEventListener('resize', applySidebarState);
});
