<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    //
    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality'];

    public function get_dups_count()
    {
        return Beneficiary::where('national_id', 'like', $this->national_id)->count();
    }

    public function get_dups()
    {   
      
        return Beneficiary::where('national_id', 'like', $this->national_id);
 

    }
    public function getCount(){

        return Beneficiary::where('national_id', $this->national_id)->count();
    }
    public function getCreatedAtDate(){

        return Date($this->created_at);
    }

}
