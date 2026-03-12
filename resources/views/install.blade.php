<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Установить Atlas</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#18181b">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    @vite('resources/css/app.css')
</head>
<body class="bg-zinc-50 flex flex-col items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-zinc-200 max-w-sm w-full text-center">
        <img src="/icon-192.png" alt="Atlas Logo" class="w-24 h-24 mx-auto rounded-2xl shadow-md mb-6">
        
        <h1 class="text-2xl font-bold text-zinc-900 mb-2">Atlas</h1>
        <p class="text-zinc-500 text-sm mb-8">Умный сервис напоминаний всегда под рукой</p>

        <button id="install-btn" class="hidden w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all active:scale-[0.98]">
            Установить приложение
        </button>

        <div id="ios-hint" class="hidden bg-zinc-100 p-4 rounded-xl text-sm text-zinc-700 text-left">
            <p class="font-medium mb-2">Как установить на iPhone:</p>
            <ol class="list-decimal pl-4 space-y-2">
                <li>Нажмите иконку <b>«Поделиться»</b> (квадрат со стрелочкой) внизу экрана Safari.</li>
                <li>Прокрутите вниз и выберите <b>«На экран "Домой"»</b> ➕.</li>
            </ol>
        </div>
    </div>

    <script>
        const installBtn = document.getElementById('install-btn');
        const iosHint = document.getElementById('ios-hint');
        let deferredPrompt;

        const isIOS = () => {
            return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        };

        if (isIOS()) {
            iosHint.classList.remove('hidden');
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installBtn.classList.remove('hidden');
        });

        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('Пользователь установил Atlas');
                }
                deferredPrompt = null;
                installBtn.classList.add('hidden');
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>