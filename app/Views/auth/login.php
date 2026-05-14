<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/autohub.webp" type="image/x-icon" />
    <link rel="stylesheet" href="/css/app.css">
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }

        .login-bg {
            background-image: url('/assets/background.webp');
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Sign In - AutoHub</title>
</head>

<body class="bg-white">
    <div class="flex min-h-screen">
        <!-- Left Side: Background Image -->
        <div class="hidden lg:block lg:w-1/2 login-bg relative">
            <!-- Optional overlay to match theme -->
            <div class="absolute inset-0 bg-zinc-950/10"></div>
        </div>

        <!-- Right Side: Original Form Style -->
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 sm:p-12 bg-white">
            <div class="max-w-md w-full">
                <!-- Original Card Style -->
                <div class="p-6 rounded-2xl bg-white md:p-8">
                    <div class="flex flex-col items-center justify-center mb-8">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center shrink-0 mb-4">
                            <img src="/assets/autohub.webp" alt="AutoHub Logo" class="w-full h-full object-contain" />
                        </div>
                        <div>
                            <h1 class="text-zinc-950 text-center text-2xl font-semibold tracking-tight mb-1">Login</h1>
                            <p class="text-zinc-400 text-center text-sm">Masuk ke akun Anda</p>
                        </div>
                    </div>

                    <form class="space-y-4" method="POST" action="/login">
                        <?= csrf_field() ?>
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
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        </div>
                        <button type="submit"
                            class="h-9 w-full py-2 px-4 text-sm rounded-md font-medium cursor-pointer text-white bg-zinc-950 hover:bg-zinc-900 transition-all active:scale-95">
                            Login</button>

                        <div class="text-zinc-400 text-sm text-center">Belum punya akun? <a href="/register"
                                class="text-zinc-950 hover:underline font-medium">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/../components/toast.php'; ?>
</body>

</html>