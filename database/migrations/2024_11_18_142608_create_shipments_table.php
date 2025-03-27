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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->foreignId('booking_id')->nullable();
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('line_id')->constrained('lines');

            $table->string('transport_mode')->nullable();
            $table->string('departure_agency')->nullable();
            $table->string('arrival_agency')->nullable();

            $table->boolean('ramassage')->default(false);
            $table->json('info_ramassage')->nullable();

            $table->json('sender_info')->default(json_encode([]));
            $table->json('receiver_info')->default(json_encode([]));
            $table->float('weight')->default(0);
            $table->json('other_prices')->default(json_encode([]));
            $table->json('emballage_prices')->default(json_encode([]));
            $table->float('total_cost')->default(0);
            $table->longText("pictures")->nullable();
            $table->json('tracking_info')->default(json_encode([]));
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
