@extends('layouts.app')

@section('title', 'Редактировать событие')
@section('header_title', 'Редактирование')
@section('header_right', 'Настройка задачи')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
    
    <div class="bg-white rounded-[2.5rem] border border-zinc-100 shadow-[0_8px_30px_-4px_rgba(0,0,0,0.04)] p-6 sm:p-10">
        
        <div class="mb-8">
            <h2 class="text-2xl font-medium tracking-tight text-zinc-900">Детали события</h2>
            <p class="text-sm text-zinc-500 mt-1">Внесите изменения в запланированную задачу.</p>
        </div>

        <form action="{{ route('events.update', $event) }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT') 
            
            <div class="flex flex-col gap-2">
                <label for="title" class="text-sm font-medium text-zinc-700">Название события</label>
                <input type="text" id="title" name="title" value="{{ $event->title }}" required 
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 bg-zinc-50 focus:bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all text-zinc-900">
            </div>
            
            <div class="flex flex-col gap-2">
                <label for="category" class="text-sm font-medium text-zinc-700">Категория</label>
                <select id="category" name="category" required 
                        class="w-full px-4 py-3 rounded-xl border border-zinc-200 bg-zinc-50 focus:bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all text-zinc-900 appearance-none">
                    <option value="study" {{ $event->category == 'study' ? 'selected' : '' }}>Учеба</option>
                    <option value="work" {{ $event->category == 'work' ? 'selected' : '' }}>Работа</option>
                    <option value="personal" {{ $event->category == 'personal' ? 'selected' : '' }}>Личное / Тренировка</option>
                    <option value="birthday" {{ $event->category == 'birthday' ? 'selected' : '' }}>День рождения</option>
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="starts_at" class="text-sm font-medium text-zinc-700">Дата и время начала</label>
                <input type="datetime-local" id="starts_at" name="starts_at" 
                       value="{{ \Carbon\Carbon::parse($event->starts_at)->format('Y-m-d\TH:i') }}" required 
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 bg-zinc-50 focus:bg-white focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-all font-mono text-sm text-zinc-700">
            </div>
            
            <div class="flex items-center gap-3 pt-4 border-t border-zinc-100 mt-2">
                <a href="{{ url()->previous() }}" 
                   class="flex-1 py-3.5 px-4 bg-white text-zinc-700 border border-zinc-200 rounded-xl font-medium hover:bg-zinc-50 active:scale-[0.98] transition-all duration-200 text-center text-sm shadow-sm">
                    Отмена
                </a>
                
                <button type="submit" 
                        class="flex-1 py-3.5 px-4 bg-zinc-900 text-white rounded-xl font-medium hover:bg-zinc-800 active:-translate-y-[1px] active:scale-[0.98] transition-all duration-200 text-center text-sm shadow-sm flex items-center justify-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</div>
@endsection