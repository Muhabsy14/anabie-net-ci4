<script>
(function () {
  const sidebar = document.getElementById('app-sidebar');
  const backdrop = document.getElementById('sidebar-backdrop');
  const openBtn = document.getElementById('sidebar-open');
  const closeBtn = document.getElementById('sidebar-close');

  if (!sidebar || !backdrop) return;

  function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    backdrop.classList.remove('opacity-0', 'pointer-events-none');
    document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
  }

  function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    backdrop.classList.add('opacity-0', 'pointer-events-none');
    document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
  }

  openBtn?.addEventListener('click', openSidebar);
  closeBtn?.addEventListener('click', closeSidebar);
  backdrop.addEventListener('click', closeSidebar);

  sidebar.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      if (window.innerWidth < 1024) closeSidebar();
    });
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth >= 1024) closeSidebar();
  });
})();
</script>
