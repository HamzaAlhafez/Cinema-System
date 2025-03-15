<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Movie::class);
            $table->foreignIdFor(\App\Models\Hall::class);
            $table->foreignIdFor(App\Models\Admin::class);
            $table->float('price');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('remaining_seats');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
