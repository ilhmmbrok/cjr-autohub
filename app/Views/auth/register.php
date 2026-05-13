<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>
    <link rel="stylesheet" href="/css/app.css">
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
    <title>Sign Up - AutoHub</title>
</head>

<body>
    <div class="bg-white px-4 md:px-8">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="max-w-md w-full">
                <div class="p-6 rounded-2xl bg-white border border-zinc-200 shadow-[0px_4px_12px_rgba(0,0,0,0.08)] md:p-8">
                    <div class="flex flex-col items-center justify-center mb-8">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center shrink-0 mb-4">
                            <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo" class="w-full h-full object-contain"/>' ?>
                        </div>
                        <div>
                            <h1 class="text-zinc-950 text-center text-2xl font-semibold tracking-tight mb-1">Register</h1>
                            <p class="text-zinc-400 text-center text-sm">Buat akun baru</p>
                        </div>
                    </div>

                    <form class="space-y-4" method="POST" action="/register">
                        <div>
                            <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="fullname">
                                Nama Lengkap <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="fullname" name="fullname" placeholder="Nama lengkap" required
                                class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="email">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" required
                                class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="password">
                                Password <span class="text-red-600">*</span>
                            </label>
                            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required
                                class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        </div>
                        <button type="submit"
                            class="h-9 w-full py-2 px-4 text-sm rounded-md font-medium cursor-pointer text-white bg-zinc-950 hover:bg-zinc-900 transition-all active:scale-95">
                            Buat Akun</button>

                        <div class="text-zinc-400 text-sm text-center">Sudah punya akun? <a href="/login"
                                class="text-zinc-950 hover:underline font-medium">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require __DIR__ . '/../components/toast.php'; ?>
</body>

</html>