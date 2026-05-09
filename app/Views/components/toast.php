<?php

use App\Core\Session;

$toastSuccess = Session::getMessage('success');
$toastError   = Session::getMessage('error');
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

<?php if ($toastSuccess || $toastError): ?>


    <div id="toast-container" style="position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:9999;display:flex;flex-direction:column;gap:8px;pointer-events:none;">

        <?php if ($toastSuccess): ?>
            <div class="toast-item" data-type="success" style="pointer-events:auto;opacity:0;transform:translateY(-16px);transition:all 300ms cubic-bezier(0.16,1,0.3,1);">
                <div style="display:flex;align-items:start;gap:10px;padding:14px 16px;background:#fff;border:1px solid #e4e4e7;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.08),0 1px 3px rgba(0,0,0,.04);min-width:320px;max-width:420px;font-family:'Inter',sans-serif;">
                    <div style="width:18px;height:18px;border-radius:50%;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;font-weight:500;color:#18181b;margin:0;line-height:1.4;"><?= htmlspecialchars($toastSuccess) ?></p>
                    </div>
                    <button onclick="dismissToast(this)" style="flex-shrink:0;background:none;border:none;cursor:pointer;padding:2px;color:#a1a1aa;display:flex;" aria-label="Tutup">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($toastError): ?>
            <div class="toast-item" data-type="error" style="pointer-events:auto;opacity:0;transform:translateY(-16px);transition:all 300ms cubic-bezier(0.16,1,0.3,1);">
                <div style="display:flex;align-items:start;gap:10px;padding:14px 16px;background:#fff;border:1px solid #e4e4e7;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.08),0 1px 3px rgba(0,0,0,.04);min-width:320px;max-width:420px;font-family:'Inter',sans-serif;">
                    <div style="width:18px;height:18px;border-radius:50%;background:#fef2f2;border:1px solid #fecaca;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="3" stroke-linecap="round">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;font-weight:500;color:#18181b;margin:0;line-height:1.4;"><?= htmlspecialchars($toastError) ?></p>
                    </div>
                    <button onclick="dismissToast(this)" style="flex-shrink:0;background:none;border:none;cursor:pointer;padding:2px;color:#a1a1aa;display:flex;" aria-label="Tutup">
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
                item.style.opacity = '0';
                item.style.transform = 'translateY(-16px)';
                setTimeout(function() {
                    item.remove();
                }, 300);
            }
            window.dismissToast = dismissToast;

            // Slide in
            var items = document.querySelectorAll('.toast-item');
            items.forEach(function(el, i) {
                setTimeout(function() {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 80 * i);
            });

            // Auto dismiss after 4s
            items.forEach(function(el) {
                setTimeout(function() {
                    if (el.parentNode) {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-16px)';
                        setTimeout(function() {
                            el.remove();
                        }, 300);
                    }
                }, 4000);
            });
        })();
    </script>
<?php endif; ?>