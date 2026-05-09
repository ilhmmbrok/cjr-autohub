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
    <title>Sign In - AutoHub</title>
</head>

<body>
    <div class="bg-zinc-50 px-4 md:px-8">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="max-w-md w-full">
                <div class="p-6 rounded-4xl bg-white border border-zinc-200 shadow-sm md:p-8">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-15 h-15 rounded-lg  flex items-center justify-center shrink-0">
                            <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                        </div>
                        <div>
                            <h1 class="text-zinc-900 text-center text-2xl font-semibold mb-1">Login</h1>
                            <p class="text-zinc-500 text-center text-sm mb-6">Masuk ke akun Anda</p>
                        </div>
                    </div>

                    <form class="space-y-4" method="POST" action="/login">
                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="email">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" required
                                class="w-full px-3 py-2 rounded-full text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all placeholder:text-zinc-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="password">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="w-full px-3 py-2 rounded-full text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all placeholder:text-zinc-400">
                        </div>
                        <button type="submit"
                            class="w-full py-2 px-4 text-sm rounded-full font-medium cursor-pointer text-white bg-zinc-900 hover:bg-zinc-800 transition-all focus:outline-none focus:ring-2 focus:ring-zinc-950/20 focus:ring-offset-1">
                            Login</button>

                        <div class="text-zinc-600 text-sm text-center">Belum punya akun? <a href="/register"
                                class="text-zinc-900 hover:underline font-medium">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require __DIR__ . '/../components/toast.php'; ?>
</body>

</html>