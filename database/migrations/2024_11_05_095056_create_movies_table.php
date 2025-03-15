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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Categorie::class);
            $table->foreignIdFor(App\Models\Admin::class);
            $table->string('title');
            $table->string('image');
            $table->text('storyline');
            $table->float('rating');
            $table->string('language');
            $table->date('production_date');
            $table->string('director');
             $table->text('Actors');
              $table->timestamps();
            
           
            
            
           
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
