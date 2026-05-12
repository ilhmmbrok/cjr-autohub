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
    <div class="bg-zinc-50 min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white border-b border-zinc-200">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg  flex items-center justify-center">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                    </div>
                    <span class="text-base font-bold text-zinc-900 tracking-tight">AutoHub</span>
                </div>
                <div class="flex gap-3">
                    <a href="/login"
                        class="px-4 py-2 text-sm font-medium text-zinc-700 rounded-md border border-zinc-200 hover:bg-zinc-100 active:scale-95 transition-all duration-200">
                        Sign In
                    </a>
                    <a href="/register"
                        class="px-4 py-2 text-sm font-medium text-white bg-zinc-900 rounded-md hover:bg-zinc-800 active:scale-95 transition-all duration-200">
                        Sign Up
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <div class="max-w-5xl mx-auto px-4 py-20 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-zinc-900 leading-tight">
                Booking Bengkel<br>Jadi Lebih Mudah
            </h2>
            <p class="mt-4 text-lg text-zinc-500 max-w-xl mx-auto">
                Platform booking bengkel online. Pesan jadwal servis kendaraan kamu kapan saja, di mana saja.
            </p>
            <div class="mt-8 flex gap-3 justify-center">
                <a href="/register"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-zinc-900 rounded-md hover:bg-zinc-800 active:scale-95 transition-all duration-200">
                    Daftar Sekarang
                </a>
                <a href="/login"
                    class="px-6 py-2.5 text-sm font-medium text-zinc-700 border border-zinc-200 rounded-md hover:bg-zinc-100 active:scale-95 transition-all duration-200">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</body>

</html>