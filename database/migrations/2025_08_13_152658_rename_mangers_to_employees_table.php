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
        // تغيير اسم الجدول من mangers إلى employees
        Schema::rename('mangers', 'employees');
        
       
       
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // التراجع عن التغييرات (للعودة للوضع السابق)
        Schema::rename('employees', 'mangers');
        
        
    }
};
