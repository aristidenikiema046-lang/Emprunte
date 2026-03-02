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
            // Informations de base et professionnelles
            $table->string('avatar')->nullable()->after('name');
            $table->string('employee_id')->nullable()->after('id'); 
            $table->string('phone')->nullable()->after('email');
            $table->string('department')->nullable(); 
            $table->string('post')->nullable(); 
            $table->string('gender')->nullable(); 
            $table->date('birth_date')->nullable();
            $table->string('contract_type')->nullable(); 
            $table->date('hire_date')->nullable(); 

            // Nouvelles informations personnelles (extraites des captures)
            $table->string('address')->nullable();
            $table->string('family_status')->nullable(); // Célibataire, Marié, etc.
            $table->string('cnps_number')->nullable();

            // Contact d'urgence
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'employee_id', 
                'phone', 
                'department', 
                'post', 
                'gender', 
                'birth_date', 
                'contract_type', 
                'hire_date',
                'address',
                'family_status',
                'cnps_number',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relation'
            ]);
        });
    }
};