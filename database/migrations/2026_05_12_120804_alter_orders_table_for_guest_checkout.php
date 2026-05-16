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

        // allow guest checkout
        $table->foreignId('user_id')->nullable()->change();

        // ensure required fields exist safely
        if (!Schema::hasColumn('orders', 'email')) {
            $table->string('email')->nullable();
        }

        if (!Schema::hasColumn('orders', 'total_amount')) {
            $table->decimal('total_amount', 10, 2)->default(0);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
