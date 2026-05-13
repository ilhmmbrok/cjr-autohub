
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
<!-- Overlay -->
<div id="dialog-overlay" 
    onclick="closeDialog()"
    class="fixed inset-0 z-[9998] bg-black/50 backdrop-blur-sm opacity-0 invisible transition-all duration-300">
</div>


<!-- Dialog -->
<div id="dialog-card" 
    class="fixed z-[9999] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[400px] px-4 opacity-0 invisible scale-90 transition-all duration-300 pointer-events-none ease-out">
    
    <div class="bg-white border border-zinc-200 rounded-2xl shadow-2xl p-6">
        <!-- Header -->
        <h3 id="dialog-title" class="text-base font-semibold text-zinc-950 mb-1 tracking-tight"></h3>
        <p id="dialog-description" class="text-sm text-zinc-500 mb-6 leading-relaxed"></p>

        <!-- Footer -->
        <div class="flex justify-end gap-2.5">
            <button id="dialog-cancel"
                onclick="closeDialog()"
                class="h-9 px-4 text-sm font-medium text-zinc-700 bg-white border border-zinc-200 rounded-lg hover:bg-zinc-50 hover:border-zinc-300 hover:scale-105 transition-all duration-200 active:scale-95 active:bg-zinc-100 cursor-pointer">
                Batal
            </button>

            <form id="dialog-form" method="POST" onsubmit="return handleConfirm(this)">
                <button id="dialog-confirm"
                    type="submit"
                    class="relative h-9 px-4 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-700 hover:border-red-700 hover:scale-105 hover:shadow-lg hover:shadow-red-200/50 transition-all duration-200 active:scale-95 shadow-sm shadow-red-200/50 flex items-center justify-center gap-2 overflow-hidden cursor-pointer">
                    <span id="confirm-text">Lanjutkan</span>
                    <svg id="confirm-spinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
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
        const confirmText = document.getElementById('confirm-text');
        const confirmSpinner = document.getElementById('confirm-spinner');
        const cancelBtn = document.getElementById('dialog-cancel');

        window.openDialog = function(opts = {}) {
            title.textContent = opts.title || 'Konfirmasi';
            desc.textContent = opts.description || 'Apakah Anda yakin?';
            form.action = opts.action || '';
            confirmText.textContent = opts.confirmText || 'Lanjutkan';
            cancelBtn.textContent = opts.cancelText || 'Batal';

            // Reset loading state
            confirmBtn.disabled = false;
            confirmBtn.classList.remove('opacity-80', 'cursor-not-allowed');
            confirmText.classList.remove('hidden');
            confirmSpinner.classList.add('hidden');

            overlay.classList.remove('invisible', 'opacity-0');
            overlay.classList.add('opacity-100');
            
            card.classList.remove('invisible', 'opacity-0', 'scale-90');
            card.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
        };

        window.closeDialog = function() {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'invisible');
            
            card.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
            card.classList.add('opacity-0', 'invisible', 'scale-90');
        };

        window.handleConfirm = function(f) {
            confirmBtn.disabled = true;
            confirmBtn.classList.add('opacity-80', 'cursor-not-allowed');
            confirmText.classList.add('hidden');
            confirmSpinner.classList.remove('hidden');
            return true;
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDialog();
        });
    })();
</script>