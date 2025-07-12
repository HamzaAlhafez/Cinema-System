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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Show::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->integer('Seats_Booked');
            $table->float('tickets_Price');
            $table->boolean('Booking_Status')->default(false);
            $table->date('Booking_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
