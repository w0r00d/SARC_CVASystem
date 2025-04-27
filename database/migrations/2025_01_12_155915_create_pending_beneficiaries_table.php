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
        Schema::create('pending_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('national_id');     
            $table->string('fullname');  
            $table->string('phonenumber')->nullable();
            $table->string('recipient_name')->nullable();  
            $table->string('recipient_phone')->nullable();
            $table->string('recipient_nid')->nullable();  
            $table->string('governate');
            $table->string('project_name')->nullable();
            $table->string('partner')->nullable();
            $table->string('donor')->nullable();
            $table->integer('transfer_value')->nullable();
            $table->integer('transfer_count')->nullable();
            $table->date('project_start_date')->nullable();
            $table->date('project_end_date')->nullable();
            $table->date('recieve_date')->nullable();
            $table->string('sector')->nullable();
            $table->string('modality')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_beneficiaries');
    }
};
