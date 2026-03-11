<!DOCTYPE html>
<html lang="ru" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Атлас')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .flatpickr-calendar {
            font-family: 'Outfit', sans-serif !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(16px) !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            box-shadow: 0 20px 60px -15px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.8) !important;
            border-radius: 1.5rem !important;
            padding: 8px !important;
            width: 320px !important;
        }

        .flatpickr-months .flatpickr-month {
            height: 40px !important;
        }

        .flatpickr-current-month {
            font-size: 1.1rem !important;
            font-weight: 500 !important;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            border-radius: 8px !important;
            outline: none !important;
        }

        .flatpickr-day {
            border-radius: 0.75rem !important;
            color: #3f3f46 !important;
            /* zinc-700 */
            transition: all 0.2s ease !important;
        }

        .flatpickr-day:hover {
            background: #f4f4f5 !important;
            color: #18181b !important;
            border-color: transparent !important;
        }

        .flatpickr-day.today {
            border-color: #e4e4e7 !important;
        }

        .flatpickr-day.selected {
            background: #18181b !important;
            color: #ffffff !important;
            border-color: #18181b !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .flatpickr-time {
            border-top: 1px solid #f4f4f5 !important;
            margin-top: 8px !important;
        }

        .flatpickr-time input:hover,
        .flatpickr-time .flatpickr-am-pm:hover,
        .flatpickr-time input:focus,
        .flatpickr-time .flatpickr-am-pm:focus {
            background: #f4f4f5 !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
        }

        :root {
            --cat-study: #6366f1;
            --cat-work: #f59e0b;
            --cat-personal: #10b981;
            --cat-birthday: #eab308;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="min-h-[100dvh] w-full flex flex-col bg-zinc-50 text-zinc-950 pb-28 selection:bg-zinc-200">

    <header class="w-full max-w-4xl mx-auto pt-12 pb-6 px-6 sm:px-8 flex items-end justify-between relative z-10">
        <div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tighter leading-none mb-1.5 text-zinc-900">
                @yield('header_title')
            </h1>
            <p class="text-sm font-mono text-zinc-400">
                @yield('header_right')
            </p>
        </div>

        <a href="{{ route('profile') }}" id="header-profile-btn"
            class="group relative w-11 h-11 rounded-full overflow-hidden border border-zinc-200 bg-zinc-900 text-white shadow-sm hover:bg-zinc-800 active:scale-[0.95] transition-all flex items-center justify-center">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </a>
    </header>

    <main class="flex-1 w-full max-w-4xl mx-auto relative z-10">
        @yield('content')
    </main>

    <div
        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 flex items-center p-1.5 gap-1 rounded-full bg-white/70 backdrop-blur-xl border border-white/20 shadow-[0_8px_30px_-8px_rgba(0,0,0,0.1),inset_0_1px_0_rgba(255,255,255,0.5)]">

        <a href="{{ route('home') }}"
            class="flex items-center justify-center w-12 h-12 rounded-full text-zinc-900 bg-white shadow-sm transition-transform active:scale-90">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </a>

        <a href=" {{ route('calendar') }}"
            class="flex items-center justify-center w-12 h-12 rounded-full text-zinc-400 hover:text-zinc-900 transition-colors active:scale-90">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </a>
        <a href="{{ route('profile') }}"
            class="flex items-center justify-center w-12 h-12 rounded-full text-zinc-400 hover:text-zinc-900 transition-colors active:scale-90">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </a>

        <div class="w-px h-6 bg-zinc-200/50 mx-1"></div>

        <button id="dock-create-btn"
            class="flex items-center justify-center w-12 h-12 rounded-full bg-zinc-900 text-white shadow-md hover:bg-zinc-800 transition-transform active:scale-90">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>

    </div>

    <div id="create-event-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div id="create-modal-backdrop"
            class="absolute inset-0 bg-zinc-950/20 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

        <div id="create-modal-panel"
            class="relative w-full max-w-md max-h-[90vh] overflow-y-auto no-scrollbar rounded-[2rem] bg-white/85 backdrop-blur-2xl border border-white/40 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1),inset_0_1px_0_rgba(255,255,255,0.8)] p-6 sm:p-8 scale-95 opacity-0 transition-all duration-300 ease-out">

            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-medium tracking-tighter text-zinc-900">Новое событие</h3>
                    <p class="text-sm text-zinc-500 mt-1">Добавьте задачу в свое расписание.</p>
                </div>
                <button id="close-create-btn" type="button"
                    class="p-2 -mr-2 -mt-2 text-zinc-400 hover:text-zinc-900 rounded-full hover:bg-zinc-100/50 transition-colors active:scale-90 shrink-0">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form action="{{ route('events.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="title" class="text-sm font-medium text-zinc-700">Название</label>
                    <input type="text" id="title" name="title" required
                        placeholder="Например: Сдача лабы по C++"
                        class="w-full px-4 py-3.5 rounded-xl border border-zinc-200 bg-white/50 focus:bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all shadow-sm">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-zinc-700 mb-1">Категория</label>
                    <div class="grid grid-cols-2 gap-3">

                        <label class="relative cursor-pointer group active:scale-[0.98] transition-transform">
                            <input type="radio" name="category" value="study" class="peer sr-only" required
                                checked>
                            <div
                                class="p-3.5 border border-zinc-200 rounded-xl bg-white/50 hover:bg-white peer-checked:border-zinc-900 peer-checked:bg-white peer-checked:shadow-sm transition-all flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" style="background-color: var(--cat-study)"></div>
                                <span
                                    class="text-sm font-medium text-zinc-500 peer-checked:text-zinc-900 transition-colors">Учеба</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group active:scale-[0.98] transition-transform">
                            <input type="radio" name="category" value="work" class="peer sr-only" required>
                            <div
                                class="p-3.5 border border-zinc-200 rounded-xl bg-white/50 hover:bg-white peer-checked:border-zinc-900 peer-checked:bg-white peer-checked:shadow-sm transition-all flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" style="background-color: var(--cat-work)"></div>
                                <span
                                    class="text-sm font-medium text-zinc-500 peer-checked:text-zinc-900 transition-colors">Работа</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group active:scale-[0.98] transition-transform">
                            <input type="radio" name="category" value="personal" class="peer sr-only" required>
                            <div
                                class="p-3.5 border border-zinc-200 rounded-xl bg-white/50 hover:bg-white peer-checked:border-zinc-900 peer-checked:bg-white peer-checked:shadow-sm transition-all flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" style="background-color: var(--cat-personal)"></div>
                                <span
                                    class="text-sm font-medium text-zinc-500 peer-checked:text-zinc-900 transition-colors">Личное</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group active:scale-[0.98] transition-transform">
                            <input type="radio" name="category" value="birthday" class="peer sr-only" required>
                            <div
                                class="p-3.5 border border-zinc-200 rounded-xl bg-white/50 hover:bg-white peer-checked:border-zinc-900 peer-checked:bg-white peer-checked:shadow-sm transition-all flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" style="background-color: var(--cat-birthday)"></div>
                                <span
                                    class="text-sm font-medium text-zinc-500 peer-checked:text-zinc-900 transition-colors">Праздник</span>
                            </div>
                        </label>

                    </div>
                </div>

                <div class="flex flex-col gap-2 relative">
                    <label for="starts_at" class="text-sm font-medium text-zinc-700">Дата и время</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-zinc-400">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                </rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <input type="text" id="starts_at" name="starts_at" required
                            placeholder="Выберите дату и время" class="w-full">
                    </div>
                </div>

                <button type="submit"
                    class="mt-4 w-full py-4 px-4 bg-zinc-900 text-white rounded-xl font-medium hover:bg-zinc-800 active:-translate-y-[1px] active:scale-[0.98] transition-all duration-200 shadow-md flex items-center justify-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Добавить в расписание
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('create-event-modal');
            const backdrop = document.getElementById('create-modal-backdrop');
            const panel = document.getElementById('create-modal-panel');

            const closeBtn = document.getElementById('close-create-btn');
            const openBtns = document.querySelectorAll('#dock-create-btn, [data-modal-trigger="create-event"]');

            const openModal = (e) => {
                if (e) e.preventDefault();
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                void modal.offsetWidth;

                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            };

            const closeModal = () => {
                backdrop.classList.add('opacity-0');
                panel.classList.remove('opacity-100', 'scale-100');
                panel.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            };

            // Вешаем обработчик на каждую найденную кнопку
            openBtns.forEach(btn => {
                btn.addEventListener('click', openModal);
            });

            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (backdrop) backdrop.addEventListener('click', closeModal);

            @if ($errors->any())
                openModal();
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>

<script>
        document.addEventListener('DOMContentLoaded', () => {
            flatpickr("#starts_at", {
                enableTime: true,
                time_24hr: true,
                locale: "ru",
                disableMobile: "true", 

                dateFormat: "Y-m-d\\TH:i",

                altInput: true,
                altFormat: "j F Y, H:i", 
                
                altInputClass: "w-full pl-12 pr-4 py-3.5 rounded-xl border border-zinc-200 bg-white/50 focus:bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all font-mono text-base text-zinc-900 shadow-sm cursor-pointer",
                placeholder: "Выберите дату и время",
                minDate: new Date(),
            });
        });
    </script>
</body>

</html>
