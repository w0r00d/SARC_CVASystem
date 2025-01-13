<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingBeneficiary extends Model
{
    //
    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality'];

    public static function getDups()
    {

        $pen = PendingBeneficiary::get('national_id'); // getting emps to find their duplicates

        $dups = Beneficiary::whereIn('national_id', $pen)->get('national_id')->union($pen); // getting the employees with same nid
        $dups2 = Beneficiary::whereIn('national_id', $pen);
        $d = BeneficiaryView::whereIn('national_id', $dups)->orderBy('national_id');

        return $d;

    }
}
