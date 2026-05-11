<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Detail Booking</title>

<div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-8 bg-white min-h-[calc(100vh-56px)]">
    <div class="mb-7">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/customer" class="hover:text-zinc-700 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="/customer/booking" class="hover:text-zinc-700 transition-colors">Riwayat Booking</a>
            <span>/</span>
            <span class="text-zinc-700 font-medium">Detail Booking</span>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-zinc-900 tracking-tight">Detail Booking</h2>
        <p class="text-sm text-zinc-500 mt-0.5">Informasi lengkap booking kendaraan Anda.</p>
    </div>

    <!-- Detail content goes here -->
</div>

<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>
