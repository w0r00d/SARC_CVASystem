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
        DB::statement('
        CREATE VIEW beneficiaries_view AS
        SELECT 
        b.id,
        b.national_id,
        b.fullname,
        b.phonenumber, 
        b.recipient_name ,
        b.recipient_phone ,
        b.recipient_nid ,
        b.governate ,
        b.project_name ,
        b.partner ,
        b.donor ,
        b.transfer_value ,
        b.transfer_count  ,
        b.project_start_date ,
        b.project_end_date ,
        b.recieve_date ,
        b.sector ,
        b.modality ,
        b.created_at,
        b.updated_at,
        "ben"
        FROM beneficiaries b
        UNION ALL
        select pb.* ,"pending"
        FROM pending_beneficiaries pb
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries_view');
    }
};
