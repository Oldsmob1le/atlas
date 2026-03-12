<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayEvents = Event::where('user_id', auth()->id())
            ->whereDate('starts_at', Carbon::today())
            ->orderBy('starts_at')
            ->get();

        $upcomingEvents = Event::where('user_id', auth()->id())
            ->whereDate('starts_at', '>', Carbon::today())
            ->orderBy('starts_at')
            ->get();

        return view('dashboard', [
            'todayEvents' => $todayEvents,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:study,work,personal,birthday',
            'starts_at' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('home')->with('success', 'Событие успешно добавлено!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403, 'У вас нет доступа к этому событию.');
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:study,work,personal,birthday',
            'starts_at' => 'required|date',
        ]);

        $event->update($validated);

        return redirect()->route('home')->with('success', 'Событие успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->delete();

        return back()->with('success', 'Событие удалено!');
    }

    public function calendar(Request $request)
    {
        $month = (int) $request->input('month', Carbon::now()->month);
        $year = (int) $request->input('year', Carbon::now()->year);

        $currentDate = Carbon::createFromDate($year, $month, 1);

        $startOfCalendar = $currentDate->copy()->startOfMonth()->startOfWeek();
        $endOfCalendar = $currentDate->copy()->endOfMonth()->endOfWeek();

        $regularEvents = Event::where('user_id', auth()->id())
            ->where('category', '!=', 'birthday')
            ->whereBetween('starts_at', [$startOfCalendar, $endOfCalendar])
            ->get();

        $birthdays = Event::where('user_id', auth()->id())
            ->where('category', 'birthday')
            ->get();

        $mappedBirthdays = collect();

        foreach ($birthdays as $birthday) {
            $date = Carbon::parse($birthday->starts_at);

            $dateThisYear = $date->copy()->year($year);
            if ($dateThisYear->between($startOfCalendar, $endOfCalendar)) {
                $cloned = clone $birthday;
                $cloned->starts_at = $dateThisYear->format('Y-m-d H:i:s');
                $mappedBirthdays->push($cloned);
            }

            $dateNextYear = $date->copy()->year($year + 1);
            if ($dateNextYear->between($startOfCalendar, $endOfCalendar)) {
                $cloned = clone $birthday;
                $cloned->starts_at = $dateNextYear->format('Y-m-d H:i:s');
                $mappedBirthdays->push($cloned);
            }

            $datePrevYear = $date->copy()->year($year - 1);
            if ($datePrevYear->between($startOfCalendar, $endOfCalendar)) {
                $cloned = clone $birthday;
                $cloned->starts_at = $datePrevYear->format('Y-m-d H:i:s');
                $mappedBirthdays->push($cloned);
            }
        }

        $events = $regularEvents->merge($mappedBirthdays);

        $eventsByDate = $events->groupBy(function ($event) {
            return Carbon::parse($event->starts_at)->format('Y-m-d');
        });

        $days = [];
        $dayWalker = $startOfCalendar->copy();

        while ($dayWalker <= $endOfCalendar) {
            $days[] = $dayWalker->copy();
            $dayWalker->addDay();
        }

        return view('calendar', [
            'days' => $days,
            'eventsByDate' => $eventsByDate,
            'currentDate' => $currentDate,
        ]);
    }
}
