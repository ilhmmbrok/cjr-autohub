<style>
    @media print {
        @page {
            size: A4;
            margin: 0;
        }

        img {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            margin: 1.6cm;
        }

        body * {
            visibility: hidden;
        }

        #print-receipt,
        #print-receipt * {
            page-break-inside: avoid;
            break-inside: avoid;
            visibility: visible;
        }

        #print-receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<!-- Print-Only Receipt Section -->
<div id="print-receipt" class="hidden print:block">
    <div class="max-w-2xl mx-auto p-10 rounded-2xl">
        <!-- Receipt Header -->
        <div class="flex justify-between items-start mb-10 pb-10 border-b border-zinc-100">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="/assets/autohub.webp" class="w-8 h-8 object-contain" alt="Logo">
                    <span class="text-xl font-bold text-zinc-950 tracking-tight">AutoHub</span>
                </div>
                <p class="text-sm text-zinc-500 max-w-[200px] leading-relaxed">
                    Politeknik Negeri Jember<br>
                    Jl. Mastrip, Sumbersari, Kabupaten Jember, Jawa Timur 68121<br>
                    +62 811-3221-1515
                </p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-zinc-950 tracking-tighter mb-1">Bukti Booking</h2>
                <p class="text-sm text-zinc-500">No. Ref: #<?= $booking['booking_id'] ?></p>
                <p id="print-date" class="text-xs text-zinc-400 mt-2"></p>
            </div>
        </div>

        <!-- Receipt Body -->
        <div class="grid grid-cols-2 gap-10 mb-10">
            <div>
                <h3 class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-3">Informasi Pelanggan</h3>
                <p class="text-sm font-semibold text-zinc-950 mb-1"><?= htmlspecialchars($booking['customer_name'] ?? 'Pelanggan') ?></p>
                <p class="text-sm text-zinc-500 mb-1"><?= htmlspecialchars($booking['phone']) ?></p>
                <p class="text-sm text-zinc-500 leading-relaxed"><?= htmlspecialchars($booking['address']) ?></p>
            </div>
            <div>
                <h3 class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-3">Waktu Servis</h3>
                <p class="text-sm font-semibold text-zinc-950 mb-1"><?= $formattedDate ?></p>
                <p class="text-sm text-zinc-500">Estimasi Check-in: <?= substr($booking['checkin_time'], 0, 5) ?></p>
            </div>
        </div>

        <div class="bg-zinc-50 rounded-xl p-6 mb-10 border border-zinc-100">
            <h3 class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-4">Detail Kendaraan & Keluhan</h3>
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs text-zinc-400 mb-1">Unit Kendaraan</p>
                    <p class="text-sm capitalize font-medium text-zinc-950"><?= htmlspecialchars($booking['model_year']) ?> (<?= htmlspecialchars($booking['vehicle_type']) ?>)</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-400 mb-1">Nomor Polisi</p>
                    <p class="text-sm font-mono font-medium text-zinc-950 uppercase"><?= htmlspecialchars($booking['plate_number']) ?></p>
                </div>
            </div>
            <div class="pt-4 border-t border-zinc-200/60">
                <p class="text-xs text-zinc-400 mb-2">Catatan Keluhan:</p>
                <p class="text-sm text-zinc-600 italic leading-relaxed">
                    "<?= nl2br(htmlspecialchars($booking['customer_complaint'])) ?>"
                </p>
            </div>
        </div>

        <!-- Receipt Footer -->
        <div class="text-center pt-10 border-t border-zinc-100">
            <p class="text-sm font-medium text-zinc-950 mb-1">Terima kasih telah mempercayakan kendaraan Anda pada AutoHub.</p>
            <p class="text-xs text-zinc-400">Harap datang 15 menit sebelum waktu check-in yang ditentukan.</p>

            <div class="mt-10 flex justify-center">
                <div class="w-24 h-24 opacity-10 grayscale">
                    <img src="/assets/autohub.webp" class="w-full h-full object-contain" alt="Logo">
                </div>
            </div>
        </div>
    </div>
</div>

<script id="7n6qqh">
    function setPrintDate() {
        const el = document.getElementById("print-date");
        const now = new Date();

        const formatted = now.toLocaleString("id-ID", {
            weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });

        el.innerText = formatted;
    }

    /* Trigger saat print */
    window.onbeforeprint = setPrintDate;
</script>