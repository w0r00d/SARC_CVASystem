<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    //

    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality'];
}
