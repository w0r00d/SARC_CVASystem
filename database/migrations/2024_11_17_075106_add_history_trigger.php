<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER beneficiary_name_history
            BEFORE UPDATE ON beneficiaries
            FOR EACH ROW
            BEGIN
              IF NEW.fullname != OLD.fullname THEN
                SET NEW.h_fullname = OLD.fullname;
            End IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
