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

<head>
    <link rel="stylesheet" href="/css/app.css">
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>

<!-- Overlay -->
<div id="dialog-overlay"
    class="hidden fixed inset-0 z-[9998] bg-black/50 opacity-0 transition-opacity duration-200"
    onclick="closeDialog()"></div>

<!-- Dialog -->
<div id="dialog-card"
    class="hidden fixed z-[9999] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 scale-95 opacity-0 transition-all duration-200 ease-[cubic-bezier(0.16,1,0.3,1)] font-sans">

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

            overlay.classList.remove('hidden');
            card.classList.remove('hidden');

            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');

                card.classList.remove('opacity-0', 'scale-95');
                card.classList.add('opacity-100', 'scale-100');
            });
        };

        window.closeDialog = function() {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');

            card.classList.remove('opacity-100', 'scale-100');
            card.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                overlay.classList.add('hidden');
                card.classList.add('hidden');
            }, 200);
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDialog();
        });
    })();
</script>