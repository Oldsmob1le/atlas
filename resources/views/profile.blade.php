@extends('layouts.app')

@section('title', 'Профиль')
@section('header_title', 'Мой Профиль')
@section('header_right', \Carbon\Carbon::now()->locale('ru')->translatedFormat('l, d M'))

@section('content')
    <div class="max-w-xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col gap-8">

        <div class="flex flex-col items-center text-center mt-4 mb-2">
            <div
                class="w-24 h-24 rounded-full bg-zinc-900 text-white flex items-center justify-center text-4xl font-medium shadow-md mb-5">
                {{ mb_substr(auth()->user()->name, 0, 1) }}
            </div>

            <h3 class="text-2xl font-medium tracking-tight text-zinc-900 mb-1">
                {{ auth()->user()->name }}
            </h3>
            <p class="text-sm font-mono text-zinc-500">
                {{ auth()->user()->phone }}
            </p>
        </div>

        @php
            $isLinked = !empty(auth()->user()->telegram_chat_id);
        @endphp

        <div>
            <div class="flex items-center justify-between mb-3 px-4">
                <h4 class="text-xs font-medium text-zinc-400 uppercase tracking-widest">Интеграции и Уведомления</h4>
                <span id="save-indicator" class="text-xs font-medium text-emerald-500 opacity-0 transition-opacity duration-300">Сохранено</span>
            </div>

            <div class="bg-white rounded-[2rem] border border-zinc-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.02)] overflow-hidden transition-all duration-300">

                <div class="p-4 sm:p-5 flex items-center justify-between gap-4 group">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m22 2-7 20-4-9-9-4Z"></path>
                                <path d="M22 2 11 13"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-medium text-zinc-900">Telegram</span>
                            <span class="text-sm text-zinc-500">Бот для управления уведомлениями</span>
                        </div>
                    </div>
                    @if ($isLinked)
                        <div
                            class="py-1.5 px-3 bg-emerald-50 border border-emerald-100/50 text-emerald-600 rounded-lg text-sm font-medium flex items-center gap-1.5 cursor-default">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Подключено
                        </div>
                    @else
                        <form action="{{ route('telegram.bind') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="py-2 px-4 bg-zinc-100 text-zinc-900 rounded-xl text-sm font-medium hover:bg-zinc-200 active:scale-95 transition-all">
                                Привязать
                            </button>
                        </form>
                    @endif
                </div>

                <div class="h-px bg-zinc-100 mx-5"></div>

                <div class="p-4 sm:p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full {{ $isLinked ? 'bg-amber-50 text-amber-500' : 'bg-zinc-50 text-zinc-400' }} flex items-center justify-center shrink-0 transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-medium text-zinc-900">Уведомления</span>
                            <span class="text-sm text-zinc-500">Отправлять пуши в Telegram</span>
                        </div>
                    </div>

                    <label class="relative inline-flex items-center {{ $isLinked ? 'cursor-pointer active:scale-95' : 'cursor-not-allowed opacity-50' }} transition-transform" title="{{ !$isLinked ? 'Сначала привяжите Telegram' : '' }}">
                        <input type="checkbox" id="notify-toggle" class="sr-only peer" 
                            {{ ($isLinked && auth()->user()->notify_enabled) ? 'checked' : '' }}
                            {{ !$isLinked ? 'disabled' : '' }}>
                        <div class="w-11 h-6 bg-zinc-200 rounded-full peer peer-focus:outline-none peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-zinc-900 shadow-inner">
                        </div>
                    </label>
                </div>

                <div id="extended-settings" class="grid grid-rows-[1fr] opacity-100 transition-all duration-300 ease-in-out">
                    <div class="overflow-hidden flex flex-col">
                        <div class="h-px bg-zinc-100 mx-5"></div>

                        <div class="p-4 sm:p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-base font-medium text-zinc-900">Время напоминания</span>
                                    <span class="text-sm text-zinc-500">До начала события</span>
                                </div>
                            </div>

                            <div class="relative group active:scale-95 transition-transform">
                                <select id="notify-time-select" class="appearance-none bg-zinc-100 text-zinc-900 text-sm font-medium py-2 pl-4 pr-9 rounded-xl outline-none focus:ring-2 focus:ring-zinc-900 cursor-pointer transition-colors hover:bg-zinc-200">
                                    <option value="24h" {{ auth()->user()->notify_time == '24h' ? 'selected' : '' }}>За сутки</option>
                                    <option value="12h" {{ auth()->user()->notify_time == '12h' ? 'selected' : '' }}>За 12 часов</option>
                                    <option value="2h" {{ auth()->user()->notify_time == '2h' ? 'selected' : '' }}>За 2 часа</option>
                                    <option value="0m" {{ auth()->user()->notify_time == '0m' ? 'selected' : '' }}>В момент старта</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-500 group-hover:text-zinc-900 transition-colors">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </div>
                        </div>

                        <div id="repeat-setting-wrapper" class="grid grid-rows-[1fr] opacity-100 transition-all duration-300 ease-in-out">
                            <div class="overflow-hidden flex flex-col">
                                <div class="h-px bg-zinc-100 mx-5"></div>

                                <div class="p-4 sm:p-5 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 2l4 4-4 4"></path><path d="M3 11v-1a4 4 0 0 1 4-4h14"></path><path d="M7 22l-4-4 4-4"></path><path d="M21 13v1a4 4 0 0 1-4 4H3"></path>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-base font-medium text-zinc-900">Контрольный повтор</span>
                                            <span class="text-sm text-zinc-500">Дополнительный пуш</span>
                                        </div>
                                    </div>

                                    <div class="relative group active:scale-95 transition-transform">
                                        <select id="notify-repeat-select" class="appearance-none bg-zinc-100 text-zinc-900 text-sm font-medium py-2 pl-4 pr-9 rounded-xl outline-none focus:ring-2 focus:ring-zinc-900 cursor-pointer transition-colors hover:bg-zinc-200">
                                            <option value="none" {{ auth()->user()->notify_repeat == 'none' ? 'selected' : '' }}>Не повторять</option>
                                            <option value="1h" {{ auth()->user()->notify_repeat == '1h' ? 'selected' : '' }}>За 1 час</option>
                                            <option value="30m" {{ auth()->user()->notify_repeat == '30m' ? 'selected' : '' }}>За 30 минут</option>
                                            <option value="15m" {{ auth()->user()->notify_repeat == '15m' ? 'selected' : '' }}>За 15 минут</option>
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-500 group-hover:text-zinc-900 transition-colors">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="mt-4">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit"
                    class="w-full py-4 px-4 bg-rose-50 text-rose-600 rounded-2xl font-medium hover:bg-rose-100 active:scale-[0.98] transition-all duration-200 shadow-sm flex items-center justify-center gap-2 border border-rose-100/50">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Выйти из системы
                </button>
            </form>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const notifyToggle = document.getElementById('notify-toggle');
            const extendedSettings = document.getElementById('extended-settings');
            const timeSelect = document.getElementById('notify-time-select');
            const repeatSelect = document.getElementById('notify-repeat-select');
            const repeatWrapper = document.getElementById('repeat-setting-wrapper');
            const saveIndicator = document.getElementById('save-indicator');
            let saveTimeout;

            const updateVisibility = () => {
                if (notifyToggle.checked) {
                    extendedSettings.classList.remove('grid-rows-[0fr]', 'opacity-0');
                    extendedSettings.classList.add('grid-rows-[1fr]', 'opacity-100');

                    if (timeSelect.value === '0m') {
                        repeatWrapper.classList.remove('grid-rows-[1fr]', 'opacity-100');
                        repeatWrapper.classList.add('grid-rows-[0fr]', 'opacity-0');
                    } else {
                        repeatWrapper.classList.remove('grid-rows-[0fr]', 'opacity-0');
                        repeatWrapper.classList.add('grid-rows-[1fr]', 'opacity-100');
                    }
                } else {
                    extendedSettings.classList.remove('grid-rows-[1fr]', 'opacity-100');
                    extendedSettings.classList.add('grid-rows-[0fr]', 'opacity-0');
                }
            };

            const saveSettings = async () => {
                const data = {
                    notify_enabled: notifyToggle.checked,
                    notify_time: timeSelect.value,
                    notify_repeat: repeatSelect.value
                };

                try {
                    const response = await fetch("{{ route('profile.settings.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        clearTimeout(saveTimeout);
                        saveIndicator.classList.remove('opacity-0');
                        saveTimeout = setTimeout(() => {
                            saveIndicator.classList.add('opacity-0');
                        }, 2000);
                    }
                } catch (error) {
                    console.error("Ошибка сохранения настроек:", error);
                }
            };

            if (notifyToggle && timeSelect && repeatSelect) {
                updateVisibility();

                notifyToggle.addEventListener('change', () => { updateVisibility(); saveSettings(); });
                timeSelect.addEventListener('change', () => { updateVisibility(); saveSettings(); });
                repeatSelect.addEventListener('change', saveSettings);
            }
        });
    </script>
@endsection