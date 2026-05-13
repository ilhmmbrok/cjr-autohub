
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

            <form id="dialog-form" method="POST" action="">
                <button id="dialog-confirm"
                    type="button"
                    onclick="submitDialogForm()"
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
    const dialogOverlay = document.getElementById('dialog-overlay');
    const dialogCard = document.getElementById('dialog-card');
    const dialogTitle = document.getElementById('dialog-title');
    const dialogDesc = document.getElementById('dialog-description');
    const dialogForm = document.getElementById('dialog-form');
    const dialogConfirmBtn = document.getElementById('dialog-confirm');
    const dialogConfirmText = document.getElementById('confirm-text');
    const dialogConfirmSpinner = document.getElementById('confirm-spinner');
    const dialogCancelBtn = document.getElementById('dialog-cancel');

    window.openDialog = function(opts = {}) {
        dialogTitle.textContent = opts.title || 'Konfirmasi';
        dialogDesc.textContent = opts.description || 'Apakah Anda yakin?';
        dialogForm.action = opts.action || '';
        dialogConfirmText.textContent = opts.confirmText || 'Lanjutkan';
        dialogCancelBtn.textContent = opts.cancelText || 'Batal';

        // Reset loading state
        dialogConfirmBtn.disabled = false;
        dialogConfirmBtn.classList.remove('opacity-80', 'cursor-not-allowed');
        dialogConfirmText.classList.remove('hidden');
        dialogConfirmSpinner.classList.add('hidden');

        dialogOverlay.classList.remove('invisible', 'opacity-0');
        dialogOverlay.classList.add('opacity-100');
        
        dialogCard.classList.remove('invisible', 'opacity-0', 'scale-90', 'pointer-events-none');
        dialogCard.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
    };

    window.closeDialog = function() {
        dialogOverlay.classList.remove('opacity-100');
        dialogOverlay.classList.add('opacity-0', 'invisible');
        
        dialogCard.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
        dialogCard.classList.add('opacity-0', 'invisible', 'scale-90', 'pointer-events-none');
    };

    window.submitDialogForm = function() {
        dialogConfirmBtn.disabled = true;
        dialogConfirmBtn.classList.add('opacity-80', 'cursor-not-allowed');
        dialogConfirmText.classList.add('hidden');
        dialogConfirmSpinner.classList.remove('hidden');
        
        // Kirim form secara manual
        dialogForm.submit();
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDialog();
    });
</script>