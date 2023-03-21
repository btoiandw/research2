<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbMajor extends Model
{
    use HasFactory;

    protected $fillable = [
        'major_id',
        'major_name',
        'organization_id',
        'group_disciplines',
    ];
}
