<?php

/**
 * Shadcn AlertDialog Component
 * 
 * Reusable confirmation dialog mirip shadcn AlertDialog.
 * Include sebelum </body> di view yang butuh konfirmasi hapus.
 *
 * Penggunaan JS:
 *   openDialog({
 *       title: 'Hapus Booking',
 *       description: 'Data akan dihapus permanen.',
 *       action: '/admin/booking/5/delete',
 *       confirmText: 'Hapus',        // opsional, default 'Lanjutkan'
 *       cancelText: 'Batal'           // opsional, default 'Batal'
 *   });
 */
?>
<!-- CSS asisten: dipindahkan ke tag style biasa tanpa <head> -->
<style>
    #dialog-card {
        position: fixed;
        z-index: 9999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.95);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.2s;
        visibility: hidden;
    }

    #dialog-card.open {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
        pointer-events: auto;
        visibility: visible;
    }

    #dialog-overlay {
        position: fixed;
        inset: 0;
        z-index: 9998;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s;
    }

    #dialog-overlay.open {
        opacity: 1;
        visibility: visible;
    }
</style>

<!-- Overlay -->
<div id="dialog-overlay" onclick="closeDialog()"></div>

<!-- Dialog -->
<div id="dialog-card" class="font-sans">

    <div class="bg-white border border-zinc-200 rounded-lg shadow-xl w-[400px] max-w-[calc(100vw-32px)] p-6">

        <!-- Header -->
        <h3 id="dialog-title" class="text-sm font-semibold text-zinc-900 mb-1"></h3>
        <p id="dialog-description" class="text-sm text-zinc-500 mb-5"></p>

        <!-- Footer -->
        <div class="flex justify-end gap-2">
            <button id="dialog-cancel"
                onclick="closeDialog()"
                class="px-4 py-2 text-xs font-medium text-zinc-700 bg-white border border-zinc-200 rounded-md hover:bg-zinc-100 transition">
                Batal
            </button>

            <form id="dialog-form" method="POST">
                <button id="dialog-confirm"
                    type="submit"
                    class="px-4 py-2 text-xs font-medium text-white bg-red-600 border border-red-600 rounded-md hover:bg-red-700 transition">
                    Lanjutkan
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    (function() {
        const overlay = document.getElementById('dialog-overlay');
        const card = document.getElementById('dialog-card');
        const title = document.getElementById('dialog-title');
        const desc = document.getElementById('dialog-description');
        const form = document.getElementById('dialog-form');
        const confirmBtn = document.getElementById('dialog-confirm');
        const cancelBtn = document.getElementById('dialog-cancel');

        window.openDialog = function(opts = {}) {
            title.textContent = opts.title || 'Konfirmasi';
            desc.textContent = opts.description || 'Apakah Anda yakin?';
            form.action = opts.action || '';
            confirmBtn.textContent = opts.confirmText || 'Lanjutkan';
            cancelBtn.textContent = opts.cancelText || 'Batal';

            overlay.classList.add('open');
            card.classList.add('open');
        };

        window.closeDialog = function() {
            overlay.classList.remove('open');
            card.classList.remove('open');
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDialog();
        });
    })();
</script>