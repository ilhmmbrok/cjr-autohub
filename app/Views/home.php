<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
    <title>AutoHub</title>
</head>

<body>
    <div class="bg-white min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white border-b border-zinc-200 sticky top-0 z-50">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center overflow-hidden">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo" class="w-full h-full object-contain"/>' ?>
                    </div>
                    <span class="text-lg font-bold text-zinc-950 tracking-tight">AutoHub</span>
                </div>
                <div class="flex gap-3">
                    <a href="/login"
                        class="px-4 py-2 text-sm font-medium text-zinc-700 rounded-md border border-zinc-200 hover:bg-zinc-50 active:scale-95 transition-all duration-200">
                        Sign In
                    </a>
                    <a href="/register"
                        class="px-4 py-2 text-sm font-medium text-white bg-zinc-950 rounded-md hover:bg-zinc-900 active:scale-95 transition-all duration-200">
                        Sign Up
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <div class="max-w-5xl mx-auto px-4 py-28 text-center">
            <h2 class="text-5xl md:text-6xl font-extrabold text-zinc-950 leading-[1.1] tracking-tighter">
                Booking Bengkel<br><span class="text-blue-600">Jadi Lebih Mudah</span>
            </h2>
            <p class="mt-6 text-lg text-zinc-500 max-w-xl mx-auto leading-relaxed">
                Platform booking bengkel online tercanggih. Pesan jadwal servis kendaraan kamu kapan saja, di mana saja dengan mudah.
            </p>
            <div class="mt-10 flex gap-4 justify-center">
                <a href="/register"
                    class="px-8 py-3 text-sm font-medium text-white bg-zinc-950 rounded-md hover:bg-zinc-900 active:scale-95 transition-all duration-200 shadow-[0px_4px_12px_rgba(0,0,0,0.1)]">
                    Daftar Sekarang
                </a>
                <a href="/login"
                    class="px-8 py-3 text-sm font-medium text-zinc-700 border border-zinc-200 rounded-md hover:bg-zinc-50 active:scale-95 transition-all duration-200">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</body>

</html>