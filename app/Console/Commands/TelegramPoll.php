<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class TelegramPoll extends Command
{
    // Название команды для запуска в терминале
    protected $signature = 'telegram:poll';
    protected $description = 'Слушать сообщения из Telegram (Long Polling)';

    public function handle()
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $offset = 0;

        $this->info("🎧 Бот запущен в режиме Long Polling. Для остановки нажмите Ctrl+C");

        while (true) {
            try {
                $response = Http::timeout(30)->get("https://api.telegram.org/bot{$botToken}/getUpdates", [
                    'offset' => $offset,
                    'timeout' => 20 
                ]);

                if ($response->successful()) {
                    $updates = $response->json('result');

                    foreach ($updates as $update) {
                        $offset = $update['update_id'] + 1;

                        if (isset($update['message']['text'])) {
                            $chatId = $update['message']['chat']['id'];
                            $text = $update['message']['text'];


                            if (str_starts_with($text, '/start ')) {
                                $token = str_replace('/start ', '', $text);
                                $user = User::where('telegram_auth_token', $token)->first();

                                if ($user) {
                                    $user->update([
                                        'telegram_chat_id' => $chatId,
                                        'telegram_auth_token' => null
                                    ]);

                                    $this->sendMessage($chatId, "✅ Привет, {$user->name}! Ваш аккаунт успешно привязан к системе «Атлас».");
                                    $this->info("Успешная привязка для пользователя: {$user->name}");
                                } else {
                                    $this->sendMessage($chatId, "❌ Ошибка привязки: токен недействителен.");
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("Ошибка соединения: " . $e->getMessage());
                sleep(5); 
            }
            usleep(500000); 
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