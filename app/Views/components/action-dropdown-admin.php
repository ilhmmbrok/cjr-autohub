<?php

/**
 * Component: Booking Action Dropdown
 *
 * Usage — require sekali di atas file view:
 *   <?php require __DIR__ . '/../components/booking-action-dropdown.php'; ?>
 *
 * Panggil di dalam baris tabel:
 *   <td class="px-5 py-3.5">
 *       <?php renderBookingActionDropdown($b['booking_id']); ?>
 *   </td>
 *
 * Panggil sekali sebelum </body> untuk inject style + script:
 *   <?php renderBookingActionDropdownAssets(); ?>
 *
 * Routes:
 *   - Detail : /admin/booking/{id}/detail
 *   - Edit   : /admin/booking/{id}/edit
 *   - Hapus  : /admin/booking/{id}/delete
 */
function renderBookingActionDropdown(int $bookingId): void
{
    $id = (int) $bookingId;
?>
    <div class="relative inline-block text-left">
        <button
            type="button"
            class="inline-flex items-center justify-center w-8 h-8 border border-zinc-200 rounded-md bg-white text-zinc-400 hover:text-zinc-950 hover:bg-zinc-50 transition-all active:scale-90 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500"
            onclick="toggleDropMenu(this, event)"
            aria-expanded="false"
            aria-label="Menu aksi booking #<?= $id ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="5" r="1" />
                <circle cx="12" cy="12" r="1" />
                <circle cx="12" cy="19" r="1" />
            </svg>
        </button>

        <div class="drop-menu-container fixed z-[9999] min-w-[160px] bg-white border border-zinc-200 rounded-lg shadow-lg p-1 opacity-0 invisible -translate-y-2 scale-95 transition-all duration-150 pointer-events-none" role="menu">

            <a href="/admin/detail-booking/<?= $id ?>" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 transition-colors active:scale-[0.98]" role="menuitem">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Detail
            </a>
            <div class="h-px bg-zinc-100 my-1" role="separator"></div>

            <button
                type="button"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left active:scale-[0.98]"
                role="menuitem"
                onclick="openDialog({
                    title:       'Hapus Booking',
                    description: 'Booking #<?= $id ?> akan dihapus permanen. Lanjutkan?',
                    action:      '/admin/daftar-booking/<?= $id ?>/delete',
                    confirmText: 'Hapus'
                })">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M9 6V4h6v2" />
                </svg>
                Hapus
            </button>

        </div>
    </div>
<?php
}

function renderBookingActionDropdownAssets(): void
{
    static $rendered = false;
    if ($rendered) return;
    $rendered = true;
?>
    <script>

        (function() {
            function toggleDropMenu(btn, event) {
                if (event) {
                    event.stopPropagation();
                    event.preventDefault();
                }

                let menu = btn._dropMenu;
                if (!menu) {
                    menu = btn.nextElementSibling;
                    if (!menu) return;
                    btn._dropMenu = menu;
                }

                const isOpen = menu.classList.contains('!opacity-100');
                
                closeAll();
                
                if (!isOpen) {
                    if (menu.parentNode !== document.body) {
                        document.body.appendChild(menu);
                    }
                    
                    const rect = btn.getBoundingClientRect();
                    const menuHeight = menu.offsetHeight || 120;
                    const viewportHeight = window.innerHeight;
                    
                    // Positioning Fixed
                    menu.style.position = 'fixed';
                    menu.style.left = (rect.right - 160) + 'px'; // 160 is min-width

                    // Smart Positioning: Cek apakah muat di bawah, jika tidak taruh di atas
                    if (rect.bottom + menuHeight > viewportHeight - 20) {
                        menu.style.top = (rect.top - menuHeight - 4) + 'px';
                        menu.classList.add('origin-bottom');
                        menu.classList.remove('origin-top');
                    } else {
                        menu.style.top = (rect.bottom + 4) + 'px';
                        menu.classList.add('origin-top');
                        menu.classList.remove('origin-bottom');
                    }
                    
                    menu.classList.remove('opacity-0', 'invisible', '-translate-y-2', 'scale-95', 'pointer-events-none');
                    menu.classList.add('!opacity-100', '!visible', '!translate-y-0', '!scale-100', '!pointer-events-auto');
                    btn.setAttribute('aria-expanded', 'true');
                    menu._triggerBtn = btn;
                }
            }

            function closeAll() {
                document.querySelectorAll('.drop-menu-container').forEach(function(m) {
                    if (!m.classList.contains('!opacity-100')) return;
                    
                    m.classList.add('opacity-0', 'invisible', '-translate-y-2', 'scale-95', 'pointer-events-none');
                    m.classList.remove('!opacity-100', '!visible', '!translate-y-0', '!scale-100', '!pointer-events-auto');
                    
                    if (m._triggerBtn) {
                        m._triggerBtn.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.drop-menu-container')) {
                    closeAll();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeAll();
            });

            window.addEventListener('scroll', closeAll, true);
            window.addEventListener('resize', closeAll);
            window.toggleDropMenu = toggleDropMenu;
        })();
    </script>
<?php
}

