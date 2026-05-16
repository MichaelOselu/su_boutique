<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_id')->constrained()->cascadeOnDelete();

        $table->string('phone');
        $table->string('checkout_request_id')->nullable();
        $table->string('merchant_request_id')->nullable();

        $table->string('receipt_number')->nullable();
        $table->decimal('amount', 10, 2);

        $table->string('status')->default('pending');
        // pending | paid | failed

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
