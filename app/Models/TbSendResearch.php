<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbSendResearch extends Model
{
    use HasFactory;
    protected $fillable = [
        'send_id',
        'research_id',
        'id',
        'pc'
    ];
}
