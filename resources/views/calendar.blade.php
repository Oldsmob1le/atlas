@extends('layouts.app')

@section('title', 'Календарь')
@section('header_title', 'Календарь')
@section('header_right', \Carbon\Carbon::now()->locale('ru')->translatedFormat('l, d M'))

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <div class="bg-white rounded-[2rem] border border-zinc-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] p-6 sm:p-8 mb-12 relative z-10">
        
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-medium tracking-tight text-zinc-900 capitalize">
                {{ $currentDate->translatedFormat('F Y') }}
            </h2>
            
            <div class="flex items-center gap-1 bg-zinc-50 border border-zinc-200/60 rounded-full p-1 shadow-sm">
                <a href="{{ route('calendar', ['month' => $currentDate->copy()->subMonth()->month, 'year' => $currentDate->copy()->subMonth()->year]) }}" 
                   class="flex items-center justify-center w-8 h-8 rounded-full text-zinc-400 hover:text-zinc-900 hover:bg-white transition-all active:scale-95">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
                
                <a href="{{ route('calendar', ['month' => $currentDate->copy()->addMonth()->month, 'year' => $currentDate->copy()->addMonth()->year]) }}" 
                   class="flex items-center justify-center w-8 h-8 rounded-full text-zinc-400 hover:text-zinc-900 hover:bg-white transition-all active:scale-95">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-px bg-zinc-100 border border-zinc-100 rounded-2xl overflow-hidden">
            
            @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $weekday)
                <div class="bg-zinc-50/50 py-3 text-center text-xs font-medium text-zinc-400 uppercase tracking-widest">
                    {{ $weekday }}
                </div>
            @endforeach

            @foreach ($days as $day)
                @php
                    $isCurrentMonth = $day->month == $currentDate->month;
                    $isToday = $day->isToday();
                    $dateString = $day->format('Y-m-d');
                    $dayEvents = $eventsByDate->get($dateString, []);
                @endphp

                <div class="bg-white p-2 min-h-[5rem] sm:min-h-[6rem] flex flex-col items-center gap-1.5 transition-colors hover:bg-zinc-50/80 cursor-default group">
                    
                    <span class="w-7 h-7 flex items-center justify-center font-mono text-sm transition-all duration-200
                        {{ !$isCurrentMonth ? 'text-zinc-300' : 'text-zinc-700' }} 
                        {{ $isToday ? 'bg-zinc-900 !text-white rounded-full shadow-sm' : 'group-hover:text-zinc-900' }}">
                        {{ $day->day }}
                    </span>

                    @if (count($dayEvents) > 0)
                        <div class="flex gap-1 flex-wrap justify-center px-1">
                            @foreach (collect($dayEvents)->take(4) as $event)
                                <div class="w-1.5 h-1.5 rounded-full shadow-[inset_0_1px_1px_rgba(255,255,255,0.2)]" 
                                     style="background-color: var(--cat-{{ $event->category }})"></div>
                            @endforeach
                            @if(count($dayEvents) > 4)
                                <div class="w-1.5 h-1.5 rounded-full bg-zinc-200"></div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    @php
        $monthEvents = collect($eventsByDate)->flatten();
    @endphp

    <div>
        <h2 class="text-xl font-medium tracking-tight text-zinc-900 mb-6 flex items-center gap-3">
            Запланировано на месяц
            @if($monthEvents->count() > 0)
                <span class="px-2 py-0.5 rounded-full bg-zinc-100 text-zinc-500 text-xs font-mono">
                    {{ $monthEvents->count() }}
                </span>
            @endif
        </h2>

        <div class="flex flex-col gap-3">
            @forelse($monthEvents as $event)
                <div class="group relative flex items-center justify-between p-4 rounded-2xl bg-white border border-zinc-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.04)] hover:border-zinc-200 transition-all duration-300">

                    <div class="flex items-center gap-4">
                        <div class="w-1.5 h-10 rounded-full bg-zinc-800" style="background-color: var(--cat-{{ $event->category }});"></div>

                        <div class="flex flex-col">
                            <span class="text-base font-medium text-zinc-900 tracking-tight">{{ $event->title }}</span>
                            <span class="text-sm font-mono text-zinc-400">
                                {{ \Carbon\Carbon::parse($event->starts_at)->format('d M · H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <a href="{{ route('events.edit', $event) }}" 
                           class="p-2 text-zinc-400 hover:text-zinc-900 hover:bg-zinc-50 rounded-lg transition-colors active:scale-[0.95]">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                        </a>

                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="m-0"
                            onsubmit="return confirm('Точно удалить это событие?');">
                            @csrf
                            @method('DELETE') 
                            <button type="submit" 
                                    class="p-2 text-zinc-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors active:scale-[0.95]">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center p-12 rounded-3xl border border-dashed border-zinc-200 bg-zinc-50/50">
                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 text-zinc-400">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <p class="text-sm font-medium text-zinc-900 mb-1">Месяц свободен</p>
                    <p class="text-sm text-zinc-500 mb-0 text-center max-w-[35ch]">В этом месяце пока нет запланированных событий. Нажмите на + в нижнем меню, чтобы добавить задачу.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection