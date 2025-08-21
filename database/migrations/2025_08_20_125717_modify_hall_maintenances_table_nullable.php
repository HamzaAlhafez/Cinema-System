<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hall_maintenances', function (Blueprint $table) {
            $table->foreignIdFor(Employee::class)
            ->nullable()
            ->change();
            $table->foreign('employee_id')
            ->references('id')
            ->on('employees')
            ->nullOnDelete();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hall_maintenances', function (Blueprint $table) {
           
           
            $table->dropForeign(['employee_id']);
            
            
         
                  
            $table->foreignIdFor(Employee::class)
                  ->nullable(false)
                  ->change();
            
          
        
                  
            $table->foreign('employee_id')
                  ->references('id')
                  ->on('employees');
        });
        
    }
};
