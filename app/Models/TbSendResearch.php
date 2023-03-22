<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbSendResearch extends Model
{
    use HasFactory;
    protected $fillable = [
        'research_id',
        'id',
        'pc'
    ];
}
