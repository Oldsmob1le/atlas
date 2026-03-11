@extends('layouts.app')

@section('title', 'Профиль')
@section('header_title', 'Мой Профиль')
@section('header_right', \Carbon\Carbon::now()->locale('ru')->translatedFormat('l, d M'))

@section('content')
<div class="max-w-xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col gap-8">

    <div class="flex flex-col items-center text-center mt-4 mb-2">
        <div class="w-24 h-24 rounded-full bg-zinc-900 text-white flex items-center justify-center text-4xl font-medium shadow-md mb-5">
            {{ mb_substr(auth()->user()->name, 0, 1) }}
        </div>
        
        <h3 class="text-2xl font-medium tracking-tight text-zinc-900 mb-1">
            {{ auth()->user()->name }}
        </h3>
        <p class="text-sm font-mono text-zinc-500">
            {{ auth()->user()->phone }}
        </p>
    </div>

    <div>
        <h4 class="text-xs font-medium text-zinc-400 uppercase tracking-widest mb-3 px-4">Интеграции</h4>
        
        <div class="bg-white rounded-[2rem] border border-zinc-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.02)] overflow-hidden">
            
            <div class="p-4 sm:p-5 flex items-center justify-between gap-4 group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-base font-medium text-zinc-900">Telegram</span>
                        <span class="text-sm text-zinc-500">Бот для управления задачами</span>
                    </div>
                </div>
                <button type="button" class="py-2 px-4 bg-zinc-100 text-zinc-900 rounded-xl text-sm font-medium hover:bg-zinc-200 active:scale-95 transition-all">
                    Привязать
                </button>
            </div>

            <div class="h-px bg-zinc-100 mx-5"></div>

            <div class="p-4 sm:p-5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-zinc-50 text-zinc-400 flex items-center justify-center shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-base font-medium text-zinc-900">Уведомления</span>
                        <span class="text-sm text-zinc-500">Напоминания о событиях</span>
                    </div>
                </div>
                
                <label class="relative inline-flex items-center cursor-pointer active:scale-95 transition-transform">
                    <input type="checkbox" value="" class="sr-only peer">
                    <div class="w-11 h-6 bg-zinc-200 rounded-full peer peer-focus:outline-none peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-zinc-900 shadow-inner"></div>
                </label>
            </div>

        </div>
    </div>

    <div class="mt-4">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" 
                    class="w-full py-4 px-4 bg-rose-50 text-rose-600 rounded-2xl font-medium hover:bg-rose-100 active:scale-[0.98] transition-all duration-200 shadow-sm flex items-center justify-center gap-2 border border-rose-100/50">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Выйти из системы
            </button>
        </form>
    </div>

</div>
@endsection