@extends('layouts.app')

@section('title', 'Главная')
@section('header_title', 'Привет,  ' . auth()->user()->name)
@section('header_right', \Carbon\Carbon::now()->locale('ru')->translatedFormat('l, d M'))

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="mb-12">
            <h2 class="text-xl font-medium tracking-tight text-zinc-900 mb-6 flex items-center gap-3">
                Сегодня
                @if ($todayEvents->count() > 0)
                    <span class="px-2 py-0.5 rounded-full bg-zinc-100 text-zinc-500 text-xs font-mono">
                        {{ $todayEvents->count() }}
                    </span>
                @endif
            </h2>

            <div class="flex flex-col gap-3">
                @forelse($todayEvents as $event)
                    <div
                        class="group relative flex items-center justify-between p-4 rounded-2xl bg-white border border-zinc-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.04)] hover:border-zinc-200 transition-all duration-300">

                        <div class="flex items-center gap-4">
                            <div class="w-1.5 h-10 rounded-full shadow-sm"
                                style="background-color: var(--cat-{{ $event->category }});"></div>

                            <div class="flex flex-col">
                                <span class="text-base font-medium text-zinc-900 tracking-tight">{{ $event->title }}</span>
                                <span class="text-sm font-mono text-zinc-400">
                                    {{ \Carbon\Carbon::parse($event->starts_at)->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <a href="{{ route('events.edit', $event) }}"
                                class="p-2 text-zinc-400 hover:text-zinc-900 hover:bg-zinc-50 rounded-lg transition-colors active:scale-[0.95]">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="m-0"
                                onsubmit="return confirm('Точно удалить это событие?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-zinc-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors active:scale-[0.95]">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 6h18"></path>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div
                        class="flex flex-col items-center justify-center p-12 rounded-3xl border border-dashed border-zinc-200 bg-zinc-50/50">
                        <div
                            class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 text-zinc-400">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20"></path>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-zinc-900 mb-1">День абсолютно свободен</p>
                        <p class="text-sm text-zinc-500 mb-5 text-center max-w-[35ch]">Расписание на сегодня чистое.
                            Идеальное время для работы над собственными проектами или тренировки.</p>
                        <button type="button" data-modal-trigger="create-event"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-zinc-900 rounded-xl hover:bg-zinc-800 transition-colors active:-translate-y-[1px] active:scale-[0.98]">
                            Добавить событие
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-xl font-medium tracking-tight text-zinc-900 mb-6 flex items-center gap-3">
                Скоро
            </h2>

            <div class="flex flex-col gap-3">
                @forelse($upcomingEvents as $event)
                    <div
                        class="group relative flex items-center justify-between p-4 rounded-2xl bg-white border border-zinc-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.04)] hover:border-zinc-200 transition-all duration-300">

                        <div class="flex items-center gap-4">
                            <div class="w-1.5 h-10 rounded-full opacity-60"
                                style="background-color: var(--cat-{{ $event->category }});"></div>

                            <div class="flex flex-col">
                                <span class="text-base font-medium text-zinc-900 tracking-tight">{{ $event->title }}</span>
                                <span class="text-sm font-mono text-zinc-400">
                                    {{ \Carbon\Carbon::parse($event->starts_at)->locale('ru')->translatedFormat('d F H:i') }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <a href="{{ route('events.edit', $event) }}"
                                class="p-2 text-zinc-400 hover:text-zinc-900 hover:bg-zinc-50 rounded-lg transition-colors active:scale-[0.95]">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="m-0"
                                onsubmit="return confirm('Точно удалить это событие?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-zinc-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors active:scale-[0.95]">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 6h18"></path>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-6 rounded-2xl border border-zinc-100 bg-white/50 text-center">
                        <p class="text-sm text-zinc-500">В ближайшее время ничего не запланировано.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
