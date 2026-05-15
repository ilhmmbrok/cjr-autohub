<?php


$s           = $schedule ?? [];
$curSlot     = $s['slot_capacity'] ?? '';
$curOpen     = isset($s['open_time'])  ? substr($s['open_time'],  0, 5) : '';
$curClose    = isset($s['close_time']) ? substr($s['close_time'], 0, 5) : '';
$hasSchedule = !empty($s);

?>

<?php require __DIR__ . '/../layouts/sidebar-admin.php'; ?>
<title>Dashboard</title>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-6 animate-fadeIn">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Dashboard</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Selamat datang di panel admin AutoHub.</p>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <!-- Pending -->
            <div class="group rounded-2xl border border-zinc-200 bg-white px-5 py-4 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:border-zinc-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-zinc-800 uppercase tracking-wider">Pending</p>
                    <div class="w-8 h-8 rounded-lg bg-orange-50 border border-orange-100 flex items-center justify-center group-hover:bg-orange-100 transition-colors">
                        <svg class="w-5 h-5 text-orange-300 group-hover:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-zinc-950 tabular-nums"><?= $totalPending ?? 0 ?></p>
                <p class="text-xs text-zinc-500 mt-1.5">Menunggu konfirmasi</p>
            </div>

            <!-- In Progress -->
            <div class="group rounded-2xl border border-zinc-200 bg-white px-5 py-4 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:border-zinc-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-zinc-800 uppercase tracking-wider">In Progress</p>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-zinc-950 tabular-nums"><?= $totalInProgress ?? 0 ?></p>
                <p class="text-xs text-zinc-500 mt-1.5">Sedang dikerjakan</p>
            </div>

            <!-- Completed -->
            <div class="group rounded-2xl border border-zinc-200 bg-white px-5 py-4 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:border-zinc-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-zinc-800 uppercase tracking-wider">Completed</p>
                    <div class="w-8 h-8 rounded-lg bg-green-50 border border-green-100 flex items-center justify-center group-hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5 text-green-300 group-hover:text-green-500 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-zinc-950 tabular-nums"><?= $totalCompleted ?? 0 ?></p>
                <p class="text-xs text-zinc-500 mt-1.5">Selesai</p>
            </div>

        </div>
        <div>
            <?php if (empty($schedule)): ?>
                <div class="rounded-2xl border border-zinc-200 bg-white hover:-translate-y-0.5 transition-all duration-300 hover:border-zinc-300 hover:shadow-md">
                    <div class="text-center py-16 text-zinc-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium text-zinc-900 text-base">Jadwal belum diatur</p>
                        <p class="text-xs mt-1">Admin belum mengatur jam operasional bengkel.</p>
                    </div>
                </div>
            <?php else: ?>

                <?php
                $slot   = $slotInfo[0] ?? null;
                $isFull = $slot && $slot['available'] <= 0;
                $pct    = ($slot && $slot['max'] > 0) ? round(($slot['booked'] / $slot['max']) * 100) : 0;
                ?>

                <!-- Jam Operasional & Slot Besok -->
                <div class="bg-white border border-zinc-200 rounded-2xl p-5 w-full hover:-translate-y-0.5 transition-all duration-300 hover:border-zinc-300 hover:shadow-md">
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wide mb-4">Jam Operasional & Slot Besok</p>
                    <div class="flex items-center gap-5">

                        <!-- Jam Operasional -->
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-10 h-10 rounded-lg bg-zinc-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 mb-0.5">Buka – Tutup</p>
                                <p class="text-base font-semibold text-zinc-950">
                                    <?= substr($schedule['open_time'], 0, 5) ?> – <?= substr($schedule['close_time'], 0, 5) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-px bg-zinc-100 self-stretch"></div>

                        <!-- Slot Besok -->
                        <?php if ($slot): ?>
                            <?php
                            // Logic warna berdasarkan persentase
                            $statusColor = 'bg-green-600';
                            $textColor   = 'text-green-600';
                            $iconColor   = 'text-green-600';

                            if ($isFull || $pct >= 90) {
                                $statusColor = 'bg-red-600';
                                $textColor   = 'text-red-600';
                                $iconColor   = 'text-red-600';
                            } elseif ($pct >= 60) {
                                $statusColor = 'bg-yellow-500';
                                $textColor   = 'text-yellow-600';
                                $iconColor   = 'text-yellow-500';
                            }
                            ?>
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 rounded-lg bg-zinc-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 <?= $iconColor ?>" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-xs text-zinc-500">Slot besok</p>
                                        <p class="text-xs font-semibold <?= $textColor ?>">
                                            <?= $isFull ? 'Penuh' : "Sisa {$slot['available']}" ?>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-zinc-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-full transition-all duration-500 <?= $statusColor ?>"
                                                style="width: <?= min($pct, 100) ?>%"></div>
                                        </div>
                                        <p class="text-xs text-zinc-500 whitespace-nowrap"><?= $slot['booked'] ?>/<?= $slot['max'] ?> terisi</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            <?php endif; ?>
        </div>

        <!-- Chart -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-zinc-950">Booking per Bulan</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Total booking masuk sepanjang tahun ini.</p>
                </div>
            </div>
            <div class="relative w-full h-[200px]">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('chart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Booking',
                    data: <?= json_encode($chartData ?? array_fill(0, 12, 0)) ?>,
                    backgroundColor: '#2563eb',
                    borderColor: '#2563eb',
                    borderWidth: 0,
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                family: 'Instrument Sans'
                            },
                            color: '#71717a'
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 11,
                                family: 'Instrument Sans'
                            },
                            color: '#71717a'
                        },
                        grid: {
                            color: '#f4f4f5'
                        },
                        border: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#f4f4f5',
                        titleColor: '#000000',
                        bodyColor: '#000000',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: {
                            size: 11,
                            family: 'Instrument Sans'
                        },
                        bodyFont: {
                            size: 13,
                            family: 'Instrument Sans',
                            weight: '600'
                        },
                    }
                }
            }
        });
    }
</script>

</div>

</body>

</html>