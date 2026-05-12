<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<div class="w-full bg-white min-h-[calc(100vh-56px)] px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/dashboard" class="hover:text-zinc-700 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="/history-booking" class="hover:text-zinc-700 transition-colors">Riwayat</a>
            <span>/</span>
            <span class="text-zinc-700 font-medium">Detail Booking</span>
        </div>
        <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">Detail Booking</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Informasi lengkap booking kendaraan Anda.</p>
    </div>

    <!-- Detail content goes here -->
</div>

<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>
