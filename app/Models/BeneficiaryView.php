<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryView extends Model
{
    //
    protected $table = 'beneficiaries_view';

    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality', 'ben'];

    public static function getDups()
    {

        $pen = PendingBeneficiary::get('national_id'); // getting emps to find their duplicates

        $dups = Beneficiary::whereIn('national_id', $pen)->get('national_id')->union($pen); // getting the employees with same nid
        $dups2 = Beneficiary::whereIn('national_id', $pen);
        $d = BeneficiaryView::whereIn('national_id', $dups)->orderBy('national_id');

        return $d;

    }

    public  function checkRecord() {

        if(BeneficiaryView::where('national_id', $this->national_id)->count()>1)
        return true;
    return false;
    }
}
