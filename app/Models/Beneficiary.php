<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    //
    public $fillable = ['national_id', 'fullname', 'phonenumber', 'recipient_name', 'recipient_phone', 'recipient_nid', 'governate', 'project_name', 'partner', 'donor', 'statement_num', 'transfer_value', 'transfer_count', 'project_start_date', 'project_end_date', 'recieve_date', 'sector', 'modality', 'created_by', 'updated_by'];

    public function get_dups_count()
    {
        return Beneficiary::where('national_id', 'like', $this->national_id)->count();
    }

    public function get_dups()
    {

        return Beneficiary::where('national_id', 'like', $this->national_id);
    }
    public function getCount()
    {

        return Beneficiary::where('national_id', $this->national_id)->count();
    }
    public function getCreatedAtDate()
    {

        return Date($this->created_at);
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
