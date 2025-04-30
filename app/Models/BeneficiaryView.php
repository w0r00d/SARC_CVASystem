<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class BeneficiaryView extends Model
{
    //
    protected $table = 'beneficiaries_view';

    protected $primaryKey = 'id'; // fake ID
    public $incrementing = false; // not auto-incremented by the DB
    protected $keyType = 'int'; // ROW_NUMBER gives integers

    public $timestamps = false; // Views typically don't have created_at / updated_at

    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'donor', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality', 'ben'];

    public static function getDups()
    {

    //    return Cache::remember('duplicate_beneficiaries', 600, function () {

        $pen = PendingBeneficiary::pluck('national_id'); // getting emps to find their duplicates

        $d = BeneficiaryView::whereIn('national_id', $pen)
         ->orderBy('national_id');
      //  dump($d);
        return $d;
       // });
    }

    public  function checkRecord() {
        $r = BeneficiaryView::where('national_id', $this->national_id)->count();
     
          return $r>1;
    }
}
