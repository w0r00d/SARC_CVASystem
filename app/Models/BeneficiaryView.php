<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryView extends Model
{
    //
    protected $table = 'beneficiaries_view';

    protected $primaryKey = 'id'; // now you have a fake ID!
    public $incrementing = false; // Because it's not auto-incremented by the DB
    protected $keyType = 'int'; // Because ROW_NUMBER gives integers

    public $timestamps = false; // Views typically don't have created_at / updated_at

    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'donor', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality', 'ben'];

    public static function getDups()
    {

        $pen = PendingBeneficiary::pluck('national_id'); // getting emps to find their duplicates

        $d = BeneficiaryView::whereIn('national_id', $pen)
         ->orderBy('national_id');
      //  dump($d);
        return $d;

    }

    public  function checkRecord() {
        $r = BeneficiaryView::where('national_id', $this->national_id)->count();
     
          return $r>1;
    }
}
