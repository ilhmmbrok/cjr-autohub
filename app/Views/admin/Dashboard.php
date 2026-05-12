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
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 2px 10px;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.6;
        border: 1px solid;
    }

    .badge-pending {
        background: #fefce8;
        color: #854d0e;
        border-color: #fde047;
    }

    .badge-approved {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .badge-progress {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fed7aa;
    }

    .badge-completed {
        background: #f0fdf4;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .badge-cancelled {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .badge-default {
        background: #f4f4f5;
        color: #52525b;
        border-color: #e4e4e7;
    }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
    }

    .booking-row td {
        transition: all 0.2s ease;
    }

    .booking-row:hover td {
        background: #fafafa;
    }
</style>

<div class="flex-1 w-full bg-white min-h-screen px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">Dashboard</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Selamat datang di panel admin AutoHub.</p>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <!-- Pending -->
            <div class="stat-card rounded-lg border border-zinc-200 bg-white px-5 py-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Pending</p>
                    <div class="w-8 h-8 rounded-md bg-yellow-50 border border-yellow-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-zinc-900 tabular-nums"><?= $totalPending ?? 0 ?></p>
                <p class="text-xs text-zinc-400 mt-1.5">Menunggu konfirmasi</p>
            </div>

            <!-- In Progress -->
            <div class="stat-card rounded-lg border border-zinc-200 bg-white px-5 py-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">In Progress</p>
                    <div class="w-8 h-8 rounded-md bg-blue-50 border border-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                            <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-zinc-900 tabular-nums"><?= $totalInProgress ?? 0 ?></p>
                <p class="text-xs text-zinc-400 mt-1.5">Sedang dikerjakan</p>
            </div>

            <!-- Completed -->
            <div class="stat-card rounded-lg border border-zinc-200 bg-white px-5 py-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Completed</p>
                    <div class="w-8 h-8 rounded-md bg-green-50 border border-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-zinc-900 tabular-nums"><?= $totalCompleted ?? 0 ?></p>
                <p class="text-xs text-zinc-400 mt-1.5">Selesai</p>
            </div>

        </div>
        <div>
            <?php if (empty($schedule)): ?>
                <div class="rounded-lg border border-zinc-200 bg-white">
                    <div class="text-center py-16 text-zinc-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium text-zinc-500 text-base">Jadwal belum diatur</p>
                        <p class="text-xs mt-1">Admin belum mengatur jam operasional bengkel.</p>
                    </div>
                </div>
            <?php else: ?>

                <?php
                $slot   = $slotInfo[0] ?? null;
                $isFull = $slot && $slot['available'] <= 0;
                $pct    = ($slot && $slot['max'] > 0) ? round(($slot['booked'] / $slot['max']) * 100) : 0;
                ?>

                <!-- Jam Operasional & Slot Hari Ini (digabung) -->
                <div class="bg-white border border-zinc-200 rounded-xl p-5 w-full">
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wide mb-4">Jam Operasional & Slot Hari Ini</p>
                    <div class="flex items-center gap-5">

                        <!-- Jam Operasional -->
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-400 mb-0.5">Buka – Tutup</p>
                                <p class="text-base font-semibold text-zinc-800">
                                    <?= substr($schedule['open_time'], 0, 5) ?> – <?= substr($schedule['close_time'], 0, 5) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-px bg-zinc-200 self-stretch"></div>

                        <!-- Slot Hari Ini -->
                        <?php if ($slot): ?>
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 rounded-lg <?= $isFull ? 'bg-red-50' : 'bg-green-50' ?> flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 <?= $isFull ? 'text-red-500' : 'text-green-500' ?>" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-icon lucide-clipboard">
                                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-xs text-zinc-400">Slot hari ini</p>
                                        <p class="text-xs font-semibold <?= $isFull ? 'text-red-600' : 'text-green-600' ?>">
                                            <?= $isFull ? 'Penuh' : "Sisa {$slot['available']}" ?>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-zinc-200 rounded-full h-1.5">
                                            <div class="h-1.5 rounded-full transition-all <?= $isFull ? 'bg-red-500' : ($pct >= 75 ? 'bg-orange-500' : 'bg-blue-500') ?>"
                                                style="width: <?= min($pct, 100) ?>%"></div>
                                        </div>
                                        <p class="text-xs text-zinc-400 whitespace-nowrap"><?= $slot['booked'] ?>/<?= $slot['max'] ?> terisi</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            <?php endif; ?>
        </div>

        <!-- Chart -->
        <div class="rounded-lg border border-zinc-200 bg-white p-6 mb-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900">Booking per Bulan</h2>
                    <p class="text-xs text-zinc-400 mt-0.5">Total booking masuk sepanjang tahun ini.</p>
                </div>
            </div>
            <canvas id="chart" height="72"></canvas>
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
                    backgroundColor: '#2b7fff',
                    borderColor: '#155dfc',
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
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
                            color: '#a1a1aa'
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
                            color: '#a1a1aa'
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
                        backgroundColor: '#18181b',
                        titleColor: '#a1a1aa',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 6,
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