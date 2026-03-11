<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    public function bindAccount(Request $request)
    {
        $user = auth()->user();
        
        $token = Str::random(32);
        
        $user->update([
            'telegram_auth_token' => $token
        ]);

        $botName = env('TELEGRAM_BOT_NAME', 'ВАШ_БОТ_БЕЗ_СОБАЧКИ'); 

        return redirect("https://t.me/{$botName}?start={$token}");
    }

    public function webhook(Request $request)
    {
        $update = $request->all();

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

                    $this->sendMessage($chatId, "Привет, {$user->name}! Ваш аккаунт успешно привязан к системе «Атлас». Теперь вы будете получать уведомления о событиях.");
                } else {
                    $this->sendMessage($chatId, "Ошибка привязки: токен недействителен или устарел. Попробуйте привязать аккаунт заново через сайт.");
                }
            }
        }

        return response('OK', 200);
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