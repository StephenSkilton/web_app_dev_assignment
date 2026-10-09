<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['orders_id']);
            $table->dropForeign(['products_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('orders_id', 'order_id');
            $table->renameColumn('products_id', 'product_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('order_id', 'orders_id');
            $table->renameColumn('product_id', 'products_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('orders_id')->references('id')->on('orders');
            $table->foreign('products_id')->references('id')->on('products');
        });
    }
};