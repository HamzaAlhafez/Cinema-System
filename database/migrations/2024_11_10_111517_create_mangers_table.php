<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('mangers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin::class);
              $table->string('name');
              $table->string('phone')->unique();
            $table->string('email')->unique();
             $table->string('password');
              $table->timestamps();

           
           
           

           
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('mangers');
    }
};
