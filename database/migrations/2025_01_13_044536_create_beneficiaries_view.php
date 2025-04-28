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

        DB::statement('DROP VIEW IF EXISTS beneficiaries_view');
        
        DB::statement('
    CREATE OR REPLACE VIEW beneficiaries_view AS
    SELECT 
        ROW_NUMBER() OVER (ORDER BY national_id) AS id,
        national_id,
        fullname,
        phonenumber, 
        recipient_name,
        recipient_phone,
        recipient_nid,
        governate,
        project_name,
        partner,
        donor,
        transfer_value,
        transfer_count,
        project_start_date,
        project_end_date,
        recieve_date,
        sector,
        modality,
        created_at,
        updated_at,
        ben
    FROM (
        SELECT 
            b.national_id,
            b.fullname,
            b.phonenumber, 
            b.recipient_name,
            b.recipient_phone,
            b.recipient_nid,
            b.governate,
            b.project_name,
            b.partner,
            b.donor,
            b.transfer_value,
            b.transfer_count,
            b.project_start_date,
            b.project_end_date,
            b.recieve_date,
            b.sector,
            b.modality,
            b.created_at,
            b.updated_at,
            "ben" as ben -- 
        FROM beneficiaries b

        UNION ALL

        SELECT 
            pb.national_id,
            pb.fullname,
            pb.phonenumber, 
            pb.recipient_name,
            pb.recipient_phone,
            pb.recipient_nid,
            pb.governate,
            pb.project_name,
            pb.partner,
            pb.donor,
            pb.transfer_value,
            pb.transfer_count,
            pb.project_start_date,
            pb.project_end_date,
            pb.recieve_date,
            pb.sector,
            pb.modality,
            pb.created_at,
            pb.updated_at,
            "pending" as ben 
        FROM pending_beneficiaries pb
    ) AS combined_data
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
