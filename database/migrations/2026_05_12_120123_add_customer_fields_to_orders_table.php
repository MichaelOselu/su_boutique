<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {

        if (!Schema::hasColumn('orders', 'email')) {
            $table->string('email')->nullable();
        }

        if (!Schema::hasColumn('orders', 'address')) {
            $table->text('address')->nullable();
        }

    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {

        if (Schema::hasColumn('orders', 'email')) {
            $table->dropColumn('email');
        }

        if (Schema::hasColumn('orders', 'address')) {
            $table->dropColumn('address');
        }

    });
}
};
