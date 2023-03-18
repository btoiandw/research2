<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'research_id',
        'file_cont',
        'date_start_cont',
        'date_end_cont',
        'money_cont',
        'date_upload_file',
        'date_gen',
        'deliver_id',
        'contract_status',
    ];
}
