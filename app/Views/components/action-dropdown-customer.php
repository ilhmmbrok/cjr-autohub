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
    <div class="drop-wrap">
        <button
            type="button"
            class="drop-btn"
            onclick="toggleDropMenu(this)"
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

        <div class="drop-menu" role="menu">

            <a href="/detail-booking/<?= $id ?>" class="drop-item" role="menuitem">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Detail
            </a>

            <a href="/edit-booking/<?= $id ?>" class="drop-item" role="menuitem">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Edit
            </a>

            <div class="drop-separator" role="separator"></div>

            <button
                type="button"
                class="drop-item danger"
                role="menuitem"
                onclick="openDialog({
                    title:       'Hapus Booking',
                    description: 'Anda yakin ingin membatalkan booking #<?= $id ?> ?',
                    action:      '/history-booking/<?= $id ?>/cancel',
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
                Cancel
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
    <style>
        .drop-wrap {
            position: relative;
            display: inline-block;
        }

        .drop-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 1px solid #e4e4e7;
            border-radius: 6px;
            background: #fff;
            cursor: pointer;
            color: #71717a;
            transition: all 120ms;
        }

        .drop-btn:active {
            transform: scale(0.9);
        }

        .drop-btn:hover {
            background: #f4f4f5;
        }

        .drop-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.06);
        }

        .drop-menu {
            position: fixed;
            z-index: 9999;
            min-width: 148px;
            background: #fff;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 4px;
            
            /* Smooth interaction */
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(0.95);
            transition: opacity 0.15s ease, transform 0.15s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.15s;
            pointer-events: none;
        }

        .drop-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .drop-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 6px;
            font-size: 13px;
            color: #18181b;
            cursor: pointer;
            transition: all 120ms;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .drop-item:active {
            transform: scale(0.97);
        }

        .drop-item:hover {
            background: #f4f4f5;
        }

        .drop-item.danger {
            color: #dc2626;
        }

        .drop-item.danger:hover {
            background: #fef2f2;
        }

        .drop-separator {
            height: 1px;
            background: #f4f4f5;
            margin: 4px 0;
        }
    </style>

    <script>
        (function() {
            function toggleDropMenu(btn) {
                const menu = btn.nextElementSibling;
                const isOpen = menu.classList.contains('open');
                closeAll();
                if (!isOpen) {
                    const rect = btn.getBoundingClientRect();
                    menu.style.top = (rect.bottom + 4) + 'px';
                    
                    /* Hitung posisi left agar rata kanan dengan tombol */
                    const menuWidth = menu.offsetWidth || 148;
                    menu.style.left = (rect.right - menuWidth) + 'px';
                    
                    menu.classList.add('open');
                    btn.setAttribute('aria-expanded', 'true');
                }
            }

            function closeAll() {
                document.querySelectorAll('.drop-menu.open').forEach(function(m) {
                    m.classList.remove('open');
                    const btn = m.previousElementSibling;
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.drop-wrap')) {
                    closeAll();
                } else if (e.target.closest('.drop-item')) {
                    /* Close dropdown when an item is clicked */
                    setTimeout(closeAll, 50);
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeAll();
            });

            window.toggleDropMenu = toggleDropMenu;
        })();
    </script>
<?php
}
