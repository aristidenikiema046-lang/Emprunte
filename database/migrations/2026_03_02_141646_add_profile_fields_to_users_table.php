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
        Schema::table('users', function (Blueprint $table) {
            // Ajout des colonnes pour le profil utilisateur
            $table->string('employee_id')->nullable()->after('id'); 
            $table->string('phone')->nullable()->after('email');
            $table->string('department')->nullable(); 
            $table->string('post')->nullable(); 
            $table->string('gender')->nullable(); 
            $table->date('birth_date')->nullable();
            $table->string('contract_type')->nullable(); 
            $table->date('hire_date')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Suppression des colonnes en cas de rollback
            $table->dropColumn([
                'employee_id', 
                'phone', 
                'department', 
                'post', 
                'gender', 
                'birth_date', 
                'contract_type', 
                'hire_date'
            ]);
        });
    }
};