<?php
require __DIR__ . '/../layouts/navbar-customer.php';


use App\Core\Auth;

$user = Auth::user('customer');
$day = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$date = $booking['booking_date'];
$dayOfWeek = date('l', strtotime($date));
$formattedDate = $day[$dayOfWeek] . ', ' . date('d F Y', strtotime($date));

$statusMap = [
    'Pending'        => ['badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'label' => 'Pending'],
    'Admin Approved' => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Approved'],
    'In Progress'    => ['badge' => 'bg-orange-50 text-orange-700 border-orange-200', 'label' => 'In Progress'],
    'Completed'     => ['badge' => 'bg-green-50 text-green-700 border-green-200', 'label' => 'Completed'],
    'Cancelled'     => ['badge' => 'bg-red-50 text-red-700 border-red-200', 'label' => 'Cancelled'],
];

$cfg = $statusMap[$booking['progress_status']] ?? ['badge' => 'bg-zinc-50 text-zinc-700 border-zinc-200', 'label' => $booking['progress_status']];
?>
<title>Detail Booking</title>
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
<div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-8 print:p-0 animate-fadeInUp">
    <!-- Web View Content (Hidden when printing) -->
    <div class="print:hidden">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
                <a href="/dashboard" class="hover:text-zinc-700 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="/history-booking" class="hover:text-zinc-700 transition-colors">Riwayat</a>
                <span>/</span>
                <span class="text-zinc-700 font-medium">Detail Booking</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-950 tracking-tight">Detail Booking #<?= htmlspecialchars($booking['booking_id']) ?></h1>
                    <p class="text-sm text-zinc-500 mt-0.5">Dibuat pada <?= htmlspecialchars(date('d M Y, H:i', strtotime($booking['created_at']))) ?></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Kendaraan & Layanan -->
                <div class="rounded-2xl border border-zinc-200 bg-white overflow-hidden transition-all duration-300 hover:-translate-y-0.5 shadow-xs hover:shadow-md">
                    <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50 flex justify-between items-center">
                        <h2 class="text-sm font-semibold text-zinc-950">Informasi Booking</h2>
                        <div class="flex items-center gap-4">
                            <span class="inline-flex items-center px-2.5 rounded-full text-xs font-medium border <?= $cfg['badge'] ?>">
                                <?= $cfg['label'] ?>
                            </span>
                            <button onclick="window.print()" class="p-2 text-zinc-500 hover:text-zinc-950 hover:bg-zinc-50 border border-zinc-200 rounded-lg transition-all active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9" />
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                    <rect x="6" y="14" width="12" height="8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-y-4 gap-x-4">
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Model & Tahun</label>
                                <p class="text-sm font-medium text-zinc-950 mt-1"><?= htmlspecialchars($booking['model_year']) ?></p>
                            </div>
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Nomor Plat</label>
                                <p class="text-sm font-mono font-medium text-zinc-950 mt-1 uppercase"><?= htmlspecialchars($booking['plate_number']) ?></p>
                            </div>
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Jenis Kendaraan</label>
                                <p class="text-sm font-medium capitalize text-zinc-950 mt-1"><?= htmlspecialchars($booking['vehicle_type']) ?></p>
                            </div>
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Waktu Check-in</label>
                                <p class="text-sm font-medium text-zinc-950 mt-1">
                                    <?= htmlspecialchars(date('d M Y', strtotime($booking['booking_date']))) ?> • <?= htmlspecialchars(substr($booking['checkin_time'], 0, 5)) ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-2 pt-6 border-t border-zinc-100">
                            <label class="text-xs font-medium text-zinc-700 uppercase tracking-wider">Keluhan / Catatan</label>
                            <div class=" p-4">
                                <p class="text-sm text-zinc-950 leading-relaxed">
                                    <?= nl2br(htmlspecialchars($booking['customer_complaint'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="rounded-2xl border border-zinc-200 bg-white overflow-hidden transition-all duration-300 hover:-translate-y-0.5 shadow-xs hover:shadow-md">
                    <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
                        <h2 class="text-sm font-semibold text-zinc-950">Informasi Kontak</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-zinc-400 uppercase font-medium tracking-wider">Telepon</p>
                                    <p class="text-sm font-medium text-zinc-950"><?= htmlspecialchars($booking['phone']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-zinc-400 uppercase font-medium tracking-wider">Alamat</p>
                                    <p class="text-sm font-medium text-zinc-950 truncate max-w-[200px]"><?= htmlspecialchars($booking['address']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-4">
                <div class="rounded-2xl border border-zinc-200 p-6 transition-all duration-300 hover:-translate-y-0.5 shadow-xs hover:shadow-md">
                    <div class="space-y-2">
                        <a
                            href="https://wa.me/6281132211515"
                            target="_blank"
                            aria-label="Hubungi Admin via WhatsApp"
                            class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-zinc-800 bg-white border border-zinc-200 rounded-xl hover:text-white hover:bg-green-500 hover:border-green-500 transition-all active:scale-95 shadow-sm group active:bg-green-500 active:border-green-500">
                            <svg
                                class="w-4 h-4 mr-2 text-green-500 group-hover:text-white transition-colors"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 16 16"
                                fill="currentColor">
                                <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                            </svg>
                            Hubungi Admin
                        </a>
                        <?php if ($booking['progress_status'] === 'Pending'): ?>
                            <a href="/edit-booking/<?= $booking['booking_id'] ?>"
                                class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-zinc-800 bg-white border border-zinc-200 rounded-xl hover:text-white hover:bg-black hover:border-zinc-300 transition-all active:scale-95 shadow-sm active:bg-black active:border-zinc-300">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-line-icon lucide-pen-line">
                                    <path d="M13 21h8" />
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                </svg>
                                Edit Booking
                            </a>
                            <button
                                onclick="openDialog({
                                    title: 'Batalkan Booking',
                                    description: 'Apakah Anda yakin ingin membatalkan reservasi ini?',
                                    action: '/history-booking/<?= $booking['booking_id'] ?>/cancel',
                                    confirmText: 'Ya, Batalkan'
                                })"
                                class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-red-500 bg-white border border-red-100 rounded-xl hover:text-white hover:bg-red-500 hover:border-zinc-200 transition-all active:scale-95 shadow-sm active:bg-red-500 active:border-zinc-200">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                                Batalkan Booking
                            </button>
                        <?php else: ?>
                            <p class="text-xs text-zinc-500 text-center leading-relaxed italic">
                                Booking dalam status <strong><?= htmlspecialchars($booking['progress_status']) ?></strong> tidak dapat diubah atau dibatalkan secara mandiri.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Bantuan Box -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 transition-all duration-300 hover:-translate-y-0.5 shadow-xs hover:shadow-md">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-zinc-950">Butuh Bantuan?</h3>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed mb-4">
                        Hubungi admin kami jika terdapat kendala atau pertanyaan mengenai status booking Anda.
                    </p>
                    <a href="https://wa.me/6281132211515" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        Hubungi via WhatsApp
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Component -->
    <?php require __DIR__ . '/../components/BookingPdf.php'; ?>
</div>

<?php require __DIR__ . '/../components/dialog.php'; ?>
<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>