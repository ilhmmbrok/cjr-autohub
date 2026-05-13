<?php

use App\Core\Session;

$toastSuccess = Session::getMessage('success');
$toastError   = Session::getMessage('error');
?>

<?php if ($toastSuccess || $toastError): ?>
    <div id="toast-container" class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-2 pointer-events-none">

        <?php if ($toastSuccess): ?>
            <div class="toast-item pointer-events-auto opacity-0 -translate-y-4 transition-all duration-300 ease-out" data-type="success">
                <div class="flex items-start gap-2.5 p-3.5 bg-white border border-zinc-200 rounded-lg shadow-lg min-w-[320px] max-w-[420px]">
                    <div class="w-4.5 h-4.5 rounded-full bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-900 leading-tight m-0"><?= htmlspecialchars($toastSuccess) ?></p>
                    </div>
                    <button onclick="dismissToast(this)" class="shrink-0 p-0.5 text-zinc-400 hover:text-zinc-600 transition-colors" aria-label="Tutup">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($toastError): ?>
            <div class="toast-item pointer-events-auto opacity-0 -translate-y-4 transition-all duration-300 ease-out" data-type="error">
                <div class="flex items-start gap-2.5 p-3.5 bg-white border border-zinc-200 rounded-lg shadow-lg min-w-[320px] max-w-[420px]">
                    <div class="w-4.5 h-4.5 rounded-full bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" class="text-red-600">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-900 leading-tight m-0"><?= htmlspecialchars($toastError) ?></p>
                    </div>
                    <button onclick="dismissToast(this)" class="shrink-0 p-0.5 text-zinc-400 hover:text-zinc-600 transition-colors" aria-label="Tutup">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script>
        (function() {
            function dismissToast(btn) {
                var item = btn.closest('.toast-item');
                if (!item) return;
                item.classList.add('opacity-0', '-translate-y-4');
                setTimeout(function() {
                    item.remove();
                }, 300);
            }
            window.dismissToast = dismissToast;

            // Slide in
            var items = document.querySelectorAll('.toast-item');
            items.forEach(function(el, i) {
                setTimeout(function() {
                    el.classList.remove('opacity-0', '-translate-y-4');
                }, 80 * i);
            });

            // Auto dismiss after 4s
            items.forEach(function(el) {
                setTimeout(function() {
                    if (el.parentNode) {
                        el.classList.add('opacity-0', '-translate-y-4');
                        setTimeout(function() {
                            el.remove();
                        }, 300);
                    }
                }, 4000);
            });
        })();
    </script>
<?php endif; ?>