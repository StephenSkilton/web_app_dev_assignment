<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the FK constraint before renaming, then re-add it after
            $table->dropForeign(['users_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('users_id', 'user_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('user_id', 'users_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('users_id')->references('id')->on('users');
        });
    }
};