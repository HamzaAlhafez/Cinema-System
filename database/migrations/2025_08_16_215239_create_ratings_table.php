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
        Schema::create('ratings', function (Blueprint $table) {
    $table->id();
    $table->foreignIdFor(App\Models\Ticket::class);
    $table->foreignIdFor(App\Models\User::class);
    $table->tinyInteger('movie_quality');
    $table->tinyInteger('hall_cleanliness');
    $table->tinyInteger('seat_comfort');
    $table->tinyInteger('sound_quality');
    $table->tinyInteger('screen_quality');
    $table->tinyInteger('food_quality')->nullable();
    $table->tinyInteger('staff_behavior');
    $table->tinyInteger('overall_experience');
    $table->text('comments')->nullable();
    $table->timestamps();
    
    
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
