<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->decimal('sale_price', 10, 2)
                ->nullable()
                ->after('price');

            $table->boolean('is_flash_sale')
                ->default(false)
                ->after('sale_price');

            $table->timestamp('sale_ends_at')
                ->nullable()
                ->after('is_flash_sale');

        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn([
                'sale_price',
                'is_flash_sale',
                'sale_ends_at'
            ]);

        });
    }
};
