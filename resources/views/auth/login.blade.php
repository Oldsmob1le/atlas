<!DOCTYPE html>
<html lang="ru" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Атлас</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="min-h-[100dvh] w-full flex bg-zinc-50 text-zinc-950">

    <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 sm:px-12 md:px-20 xl:px-32 relative z-10">
        <div class="w-full max-w-md mx-auto">
            <div class="mb-10">
                <h1 class="text-4xl md:text-5xl tracking-tighter leading-none font-medium mb-3">Атлас</h1>
                <p class="text-base text-zinc-500 leading-relaxed max-w-[65ch]">С возвращением. Пожалуйста, войдите в
                    свой аккаунт.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-zinc-700">Телефон</label>
                    <input type="text" name="phone" id="phone" required placeholder="+7 (912) 847-1928"
                        class="w-full px-4 py-3 rounded-xl border border-zinc-200 bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all">
                </div>


                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-zinc-700">Пароль</label>
                        <a href="https://t.me/Oldsmob1le"
                            class="text-xs text-zinc-500 hover:text-zinc-900 transition-colors">Забыли пароль?</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl border border-zinc-200 bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all">
                </div>

                <button type="submit"
                    class="mt-2 w-full py-3 px-4 bg-zinc-900 text-white rounded-xl font-medium hover:bg-zinc-800 active:-translate-y-[1px] active:scale-[0.98] transition-all duration-200 shadow-sm">
                    Войти
                </button>
            </form>

            <div class="mt-8 text-center lg:text-left">
                <a href="{{ route('register') }}" class="text-sm text-zinc-500 hover:text-zinc-900 transition-colors">
                    Нет аккаунта? Зарегистрироваться
                </a>
            </div>
        </div>
    </div>

    <div class="hidden lg:flex w-1/2 bg-zinc-950 relative overflow-hidden p-8 flex-col justify-between">
        <img src="https://picsum.photos/seed/atlas-login/1200/1600" alt=""
            class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-luminosity pointer-events-none">

        <div
            class="absolute inset-8 rounded-[2.5rem] border border-white/10 shadow-[inset_0_1px_0_rgba(255,255,255,0.1)] bg-white/5 backdrop-blur-md pointer-events-none">
        </div>

        <div class="relative z-10 pt-8 pl-8 text-white/40 font-mono text-sm">
            SYS.ATLAS // v1.0.7-beta
        </div>

        <div class="relative z-10 pb-12 pl-8 pr-12 max-w-lg">
            <h2 class="text-4xl md:text-5xl tracking-tighter text-white leading-none mb-6">Продолжите<br>свою работу.
            </h2>
            <p class="text-zinc-400 text-base leading-relaxed max-w-[65ch]">Управляйте своими задачами и расписанием в
                едином, сфокусированном пространстве.</p>
        </div>
    </div>

    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').slice(0, 11);
            if (!x) return e.target.value = '';
            if (x[0] === '8') x = '7' + x.slice(1);
            if (!x.startsWith('7')) x = '7' + x;
            e.target.value = '+7' + (x.length > 1 ? ' (' + x.slice(1, 4) : '') +
                (x.length >= 4 ? ') ' + x.slice(4, 7) : '') +
                (x.length >= 7 ? '-' + x.slice(7, 9) : '') +
                (x.length >= 9 ? '-' + x.slice(9, 11) : '');
        });
    </script>

</body>

</html>
