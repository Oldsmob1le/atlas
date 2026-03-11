<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_chat_id')->nullable()->unique();
            $table->string('telegram_auth_token')->nullable()->unique();
            $table->boolean('notify_enabled')->default(true);
            $table->string('notify_time')->default('24h');
            $table->string('notify_repeat')->default('1h');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telegram_chat_id', 
                'telegram_auth_token', 
                'notify_enabled', 
                'notify_time', 
                'notify_repeat'
            ]);
        });
    }
};