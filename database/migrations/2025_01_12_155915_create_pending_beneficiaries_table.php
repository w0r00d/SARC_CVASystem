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
            $table->string('phonenumber');
            $table->string('recipient_name');  
            $table->string('recipient_phone');
           $table->string('recipient_nid');  
            $table->enum('governate', ['Damascus', 'Aleppo', 'Homs', 'Hama', 'Latakia', 'Tartous', 'As-Sweida', 'Ar-Raqqa', 'Daraa', 'Idleb', 'Quneitra', 'Rural Damascus', 'Der-ezzor', 'Alhasaka']);
            $table->string('project_name');
            $table->string('partner');
            $table->integer('transfer_value');
            $table->integer('transfer_count');
            $table->date('project_start_date');
            $table->date('project_end_date');
            $table->date('recieve_date');
            $table->enum('sector', ['Health', 'Livelihood', 'Protection', 'Disaster Management', 'Wash', 'Risk Education']);
            $table->string('modality');
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
