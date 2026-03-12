<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendEventNotifications extends Command
{
    protected $signature = 'app:send-telegram-notifications';

    protected $description = 'Рассылка уведомлений о событиях в Telegram';

    public function handle()
    {
        $now = Carbon::now();

        $pastHolidays = Event::where('category', 'birthday')
            ->whereDate('starts_at', '<', $now->toDateString())
            ->get();

        foreach ($pastHolidays as $holiday) {
            $newDate = Carbon::parse($holiday->starts_at);

            while ($newDate->copy()->endOfDay()->isPast()) {
                $newDate->addYear();
            }

            $holiday->starts_at = $newDate;
            $holiday->is_notified = false;
            $holiday->is_repeat_notified = false;
            $holiday->save();
        }

        $events = Event::with('user')
            ->where('is_notified', false)
            ->orWhere('is_repeat_notified', false)
            ->get();

        foreach ($events as $event) {
            $user = $event->user;

            if (! $user || ! $user->notify_enabled || ! $user->telegram_chat_id) {
                continue;
            }

            $startsAt = Carbon::parse($event->starts_at);

            if (! $event->is_notified) {
                $timeSetting = $user->notify_time; // '24h', '12h', '2h', '0m'
                $shouldNotify = false;

                if ($timeSetting === '24h' && $startsAt->copy()->subHours(24)->lte($now)) {
                    $shouldNotify = true;
                } elseif ($timeSetting === '12h' && $startsAt->copy()->subHours(12)->lte($now)) {
                    $shouldNotify = true;
                } elseif ($timeSetting === '2h' && $startsAt->copy()->subHours(2)->lte($now)) {
                    $shouldNotify = true;
                } elseif ($timeSetting === '0m' && $startsAt->lte($now)) {
                    $shouldNotify = true;
                }

                if ($shouldNotify) {
                    $message = "🔔 <b>Напоминание:</b> {$event->title}\n⏰ <b>Время:</b> {$startsAt->locale('ru')->translatedFormat('d F, H:i')}";
                    $this->sendMessage($user->telegram_chat_id, $message);

                    $event->is_notified = true;
                    $event->save();
                }
            }

            if ($event->is_notified && ! $event->is_repeat_notified && $user->notify_repeat !== 'none') {
                $repeatSetting = $user->notify_repeat; // '1h', '30m', '15m'
                $shouldRepeat = false;

                if ($repeatSetting === '1h' && $startsAt->copy()->subHours(1)->lte($now)) {
                    $shouldRepeat = true;
                } elseif ($repeatSetting === '30m' && $startsAt->copy()->subMinutes(30)->lte($now)) {
                    $shouldRepeat = true;
                } elseif ($repeatSetting === '15m' && $startsAt->copy()->subMinutes(15)->lte($now)) {
                    $shouldRepeat = true;
                }

                if ($shouldRepeat) {
                    $message = "🔥 <b>Скоро начнется:</b> {$event->title}\nОсталось совсем немного времени!";
                    $this->sendMessage($user->telegram_chat_id, $message);

                    $event->is_repeat_notified = true;
                    $event->save();
                }
            }
        }
    }

    private function sendMessage($chatId, $text)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }
}
