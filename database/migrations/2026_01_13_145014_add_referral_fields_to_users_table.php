<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agar ustunlar bo'lmasa, ularni qo'shish
            if (!Schema::hasColumn('users', 'referral_code')) {
                $table->string('referral_code')->unique()->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'referrer_id')) {
                $table->unsignedBigInteger('referrer_id')->nullable()->after('referral_code');
                $table->foreign('referrer_id')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'balance')) {
                $table->decimal('balance', 15, 2)->default(0)->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ustunlarni o'chirish logikasi (ixtiyoriy)
            $table->dropForeign(['referrer_id']);
            $table->dropColumn(['referral_code', 'referrer_id', 'balance']);
        });
    }
};